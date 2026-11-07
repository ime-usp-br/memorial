#!/bin/sh
set -e

# -----------------------------------------------------------------------------
# Entrypoint da aplicação (php-fpm)
#
# Executa como root apenas para ajustar permissões do bind mount, instalar as
# dependências e rodar migrations. O php-fpm inicia os workers como www-data.
#
# Variáveis relevantes (injetadas pelo compose/Portainer):
#   APP_KEY, DB_*, RUN_MIGRATIONS, RUN_SEEDERS
# -----------------------------------------------------------------------------

cd /var/www

LARAVEL_USER="www-data"
LARAVEL_GROUP="www-data"

# UID/GID do dono do projeto no host (evita arquivos root no bind mount)
HOST_UID=$(stat -c '%u' composer.json)
HOST_GID=$(stat -c '%g' composer.json)

# Diretórios de runtime do Laravel (o bind mount de storage pode sombrear a
# estrutura que existiria na imagem)
mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/testing \
    storage/logs \
    storage/app/public \
    bootstrap/cache

chown -R "${LARAVEL_USER}:${LARAVEL_GROUP}" storage bootstrap/cache
chmod -R u+rwX,g+rwX storage bootstrap/cache

touch storage/logs/laravel.log storage/logs/php-fpm.log
chown "${LARAVEL_USER}:${LARAVEL_GROUP}" storage/logs/laravel.log storage/logs/php-fpm.log
chmod u+rw,g+rw storage/logs/laravel.log storage/logs/php-fpm.log

# APP_KEY: prioriza a variável do ambiente (Portainer); se ausente, gera uma
# única vez e persiste em storage/app/app_key.
KEY_FILE="storage/app/app_key"
if [ -z "${APP_KEY:-}" ] && [ -f "${KEY_FILE}" ]; then
    APP_KEY=$(cat "${KEY_FILE}")
fi
if [ -z "${APP_KEY:-}" ]; then
    APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
    printf '%s' "${APP_KEY}" > "${KEY_FILE}"
    chown "${LARAVEL_USER}:${LARAVEL_GROUP}" "${KEY_FILE}"
    chmod 600 "${KEY_FILE}"
    echo "[memorial] APP_KEY gerada e persistida em ${KEY_FILE}"
fi
export APP_KEY

# Dependências PHP: instala no primeiro boot e sempre que o composer.lock mudar.
LOCK_HASH=$(sha1sum composer.lock | awk '{print $1}')
if [ ! -f vendor/autoload.php ] || [ "$(cat vendor/.composer-lock-hash 2>/dev/null)" != "${LOCK_HASH}" ]; then
    echo "[memorial] Instalando dependências PHP (composer install)..."
    composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --optimize-autoloader \
        --ignore-platform-reqs
    printf '%s\n' "${LOCK_HASH}" > vendor/.composer-lock-hash
fi

# Link público de storage (config/filesystems.php: public/storage -> storage/app)
php artisan storage:link --force || true

# Espera o banco local do stack (ou o banco externo configurado em DB_HOST)
echo "[memorial] Aguardando banco de dados..."
until php -r '
try {
    $host = getenv("DB_HOST") ?: "mysql";
    $port = getenv("DB_PORT") ?: "3306";
    $db = getenv("DB_DATABASE") ?: "memorial";
    new PDO(
        "mysql:host=$host;port=$port;dbname=$db",
        getenv("DB_USERNAME") ?: "memorial",
        getenv("DB_PASSWORD") ?: ""
    );
} catch (Throwable $e) {
    exit(1);
}
' >/dev/null 2>&1; do
    sleep 2
done

if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "[memorial] Executando migrations..."
    php artisan migrate --force --no-interaction
fi

# O projeto não possui seeders idempotentes. Use RUN_SEEDERS=true apenas se
# você adicionar seeds próprios.
if [ "${RUN_SEEDERS:-false}" = "true" ]; then
    echo "[memorial] Executando seeders..."
    php artisan db:seed --force --no-interaction
fi

# Limpa caches. NÃO usamos config:cache porque pacotes uspdev leem env()
# diretamente (Senha Única).
php artisan cache:clear || true
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Permissões finais: storage/cache para www-data; código gerado para o host
chown -R "${LARAVEL_USER}:${LARAVEL_GROUP}" storage bootstrap/cache
chmod -R u+rwX,g+rwX storage bootstrap/cache

chown -R "${HOST_UID}:${HOST_GID}" vendor 2>/dev/null || true
chown -R "${HOST_UID}:${HOST_GID}" public 2>/dev/null || true
chmod -R u+rwX,g+rX public 2>/dev/null || true

exec php-fpm

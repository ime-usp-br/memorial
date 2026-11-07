# =============================================================================
# Memorial — PHP-FPM (produção)
# =============================================================================
# Runtime PHP 8.5.12 (mesma linha do Laravel 8 / pacotes uspdev do projeto).
# O código-fonte é montado via bind mount no docker-compose.yml; a imagem
# contém apenas PHP, Composer e as extensões exigidas pela aplicação.
#
# Extensões relevantes:
#   - pdo_mysql   (banco local do Laravel)
#   - gd          (Dompdf/Cezpdf e imagens)
#   - zip, intl, mbstring, bcmath, exif, pcntl, opcache
# =============================================================================

FROM php:8.5.12-fpm

ARG uid=1001
ARG gid=1001

ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1 \
    TZ=America/Sao_Paulo

# O índice público do bullseye-security está inconsistente (Packages aponta
# para .debs já removidos do pool). Mantemos apenas main + updates.
RUN set -eux; \
    apt-get update -o Acquire::Retries=5; \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        unzip \
        zip; \
    rm -rf /var/lib/apt/lists/*

# Instalador de extensões (resolve dependências de sistema automaticamente)
COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/local/bin/install-php-extensions
RUN chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions \
        pdo_mysql \
        pdo_dblib \
        mbstring \
        exif \
        pcntl \
        bcmath \
        zip \
        intl \
        gd \
        opcache

# Alinha www-data com o UID/GID do host para o bind mount de storage ficar
# gravável sem arquivos root no projeto.
RUN groupmod -g "${gid}" www-data \
    && usermod -u "${uid}" www-data

# gosu: executar artisan/composer como www-data quando necessário
RUN curl -fsSL -o /usr/local/bin/gosu \
        "https://github.com/tianon/gosu/releases/download/1.17/gosu-$(dpkg --print-architecture)" \
    && chmod +x /usr/local/bin/gosu


# Composer 2
RUN git config --global --add safe.directory /var/www

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Fuso horário do container
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone

WORKDIR /var/www

EXPOSE 9000
CMD ["php-fpm"]

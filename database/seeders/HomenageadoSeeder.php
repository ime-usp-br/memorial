<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Homenageado;
use App\Models\Foto;
use Carbon\Carbon;

class HomenageadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homenageado = [
            'nome' => 'José de Silva',
            'data_nascimento' => Carbon::now(),
            'data_falecimento' => Carbon::now()->addDays(30),
            'funcao' => "Professor do instituto",
            'biografia' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
        ];
        $homenageado = Homenageado::create($homenageado);
        $fotoPerfil = [
            'descricao' => null,
            'caminho' => '',
            'foto_perfil' => true,
            'homenageado_id' => $homenageado->id
        ];
        Foto::create($fotoPerfil);
        for($i = 0; $i < 50; $i++){
            $fakeHomenageado = Homenageado::factory()->create();
            $fotoPerfil['homenageado_id'] = $fakeHomenageado->id;
            Foto::create($fotoPerfil);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Homenageado;
use App\Models\Foto;

class FotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homenageados = Homenageado::select('*')->get();
        foreach($homenageados as $homenageado){
            $mensagem = [
                'descricao' => 'descricao teste',
                'caminho' => '',
                'foto_perfil' => false,
                'homenageado_id' => $homenageado->id
            ];
            Foto::create($mensagem);
            Foto::factory(11)->create(['homenageado_id' => $homenageado->id]);
        }
    }
}

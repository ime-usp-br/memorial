<?php

namespace Database\Seeders;

use App\Models\Homenageado;
use Illuminate\Database\Seeder;
use App\Models\Mensagem;


class MensagemSeeder extends Seeder
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
                'nome' => 'Jorge',
                'email' => 'jorge@hotmail.com',
                'instituicao' => 'USP',
                'mensagem' => 'mensagem teste',
                'estado' => 'APROVADO',
                'homenageado_id' => $homenageado->id
            ];
            Mensagem::create($mensagem);
            Mensagem::factory(30)->create(['homenageado_id' => $homenageado->id]);
        }
    }
}

<?php

namespace Database\Factories;

use App\Models\Mensagem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MensagemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mensagem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'email' => $this->faker->email,
            'instituicao' => 'Instiuição teste',
            'mensagem' => $this->faker->sentence(50),
            'estado' => 'APROVADO',
            'homenageado_id' => 'overridden'
        ];
    }
}

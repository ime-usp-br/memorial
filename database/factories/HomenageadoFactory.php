<?php

namespace Database\Factories;

use App\Models\Homenageado;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomenageadoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Homenageado::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'data_nascimento' => $this->faker->dateTime,
            'data_falecimento' => $this->faker->dateTime,
            'biografia' => $this->faker->sentence(200),
            'funcao' => 'Função teste'
        ];
    }
}

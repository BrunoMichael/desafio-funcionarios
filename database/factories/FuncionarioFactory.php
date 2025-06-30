<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioFactory extends Factory
{
    protected $model = \App\Models\Funcionario::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'cargo' => $this->faker->jobTitle(),
            'dataAdmissao' => $this->faker->date(),
            'salario' => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}

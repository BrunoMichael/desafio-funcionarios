<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Funcionario;
use Illuminate\Support\Str;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Funcionario::truncate();

        Funcionario::create([
            'nome' => 'João Silva',
            'email' => 'joao.silva@example.com',
            'cpf' => '11122233344',
            'cargo' => 'Desenvolvedor Frontend',
            'dataAdmissao' => '2020-01-15',
            'salario' => 5000.00,
        ]);

        Funcionario::create([
            'nome' => 'Maria Oliveira',
            'email' => 'maria.oliveira@example.com',
            'cpf' => '55566677788',
            'cargo' => 'Analista de Dados',
            'dataAdmissao' => '2019-06-01',
            'salario' => 6500.50,
        ]);

        Funcionario::create([
            'nome' => 'Pedro Souza',
            'email' => 'pedro.souza@example.com',
            'cpf' => '99988877766',
            'cargo' => 'Gerente de Projeto',
            'dataAdmissao' => '2021-03-10',
            'salario' => 9000.75,
        ]);

    }
}
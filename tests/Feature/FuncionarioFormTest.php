<?php

namespace Tests\Feature;

use App\Models\Funcionario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FuncionarioFormTest extends TestCase
{
    use RefreshDatabase; // Garante banco limpo a cada teste

    public function test_email_deve_ser_unico_no_cadastro()
    {
        // Cria um funcionário no banco
        Funcionario::factory()->create([
            'email' => 'exemplo@teste.com',
            'cpf' => '12345678901',
        ]);

        // Tenta criar um novo funcionário com mesmo email
        Livewire::test('funcionario-form')
            ->set('nome', 'Funcionario Teste')
            ->set('email', 'exemplo@teste.com') // email duplicado
            ->set('cpf', '09876543210')
            ->call('saveFuncionario')
            ->assertHasErrors(['email' => 'unique']);
    }

    public function test_campo_email_deve_ser_email_valido()
    {
        Livewire::test('funcionario-form')
            ->set('nome', 'Funcionario Teste')
            ->set('email', 'email-invalido')
            ->set('cpf', '12345678901')
            ->call('saveFuncionario')
            ->assertHasErrors(['email' => 'email']);
    }

    public function test_campo_nome_e_obrigatorio()
    {
        Livewire::test('funcionario-form')
            ->set('nome', '') // vazio
            ->set('email', 'teste@teste.com')
            ->set('cpf', '12345678901')
            ->call('saveFuncionario')
            ->assertHasErrors(['nome' => 'required']);
    }
}

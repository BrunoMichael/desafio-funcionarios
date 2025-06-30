<?php

namespace Tests\Feature;

use App\Models\Funcionario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FuncionarioFormTest extends TestCase
{
    use RefreshDatabase; // Garante banco limpo a cada teste para evitar interferências

    /**
     * Testa se o email deve ser único no cadastro.
     * Cria um funcionário e tenta cadastrar outro com mesmo email para validar erro.
     */
    public function test_email_deve_ser_unico_no_cadastro()
    {
        // Cria um funcionário no banco com email e cpf fixos
        Funcionario::factory()->create([
            'email' => 'exemplo@teste.com',
            'cpf' => '12345678901',
        ]);

        // Tenta salvar outro funcionário com email duplicado e espera erro de validação unique
        Livewire::test('funcionario-form')
            ->set('nome', 'Funcionario Teste')
            ->set('email', 'exemplo@teste.com') // email duplicado
            ->set('cpf', '09876543210')
            ->call('saveFuncionario')
            ->assertHasErrors(['email' => 'unique']);
    }

    /**
     * Testa se o campo email aceita somente formatos válidos.
     */
    public function test_campo_email_deve_ser_email_valido()
    {
        Livewire::test('funcionario-form')
            ->set('nome', 'Funcionario Teste')
            ->set('email', 'email-invalido') // formato inválido
            ->set('cpf', '12345678901')
            ->call('saveFuncionario')
            ->assertHasErrors(['email' => 'email']);
    }

    /**
     * Testa se o campo nome é obrigatório.
     */
    public function test_campo_nome_e_obrigatorio()
    {
        Livewire::test('funcionario-form')
            ->set('nome', '') // campo vazio
            ->set('email', 'teste@teste.com')
            ->set('cpf', '12345678901')
            ->call('saveFuncionario')
            ->assertHasErrors(['nome' => 'required']);
    }
}

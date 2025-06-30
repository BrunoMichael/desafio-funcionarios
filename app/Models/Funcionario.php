<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Funcionario
 *
 * Representa a entidade Funcionário no banco de dados.
 * Utiliza o Eloquent ORM do Laravel para facilitar operações CRUD.
 *
 * Padrão recomendado para Models:
 * - Uso do trait HasFactory para facilitar criação de factories em testes.
 * - Definição do array $fillable para proteção contra mass assignment.
 * - Uso do $casts para conversão automática de tipos de dados.
 * - Definir relacionamentos (se houver) com outros models.
 *
 * @package App\Models
 */
class Funcionario extends Model
{
    use HasFactory;

    /**
     * Campos permitidos para atribuição em massa (mass assignment).
     * Serve para proteger contra atribuição indevida de campos pelo usuário.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'cargo',
        'dataAdmissao',
        'salario',
    ];

    /**
     * Conversões automáticas de atributos para tipos nativos do PHP.
     * Facilita manipulação dos dados ao acessar propriedades do model.
     *
     * 'dataAdmissao' será tratado como instância Carbon (date).
     * 'salario' será tratado como decimal com 2 casas decimais.
     *
     * @var array
     */
    protected $casts = [
        'dataAdmissao' => 'date',
        'salario' => 'decimal:2',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'cargo',
        'dataAdmissao',
        'salario',
    ];

    protected $casts = [
        'dataAdmissao' => 'date',
        'salario' => 'decimal:2',
    ];
}

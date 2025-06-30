<?php

namespace App\Livewire;

use App\Models\Funcionario;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FuncionarioForm extends Component
{
    public $funcionarioId;
    public $nome;
    public $email;
    public $cpf;
    public $cargo;
    public $dataAdmissao;
    public $salario;

    protected $messages = [
        'nome.required' => 'O campo Nome é obrigatório.',
        'email.required' => 'O campo Email é obrigatório.',
        'email.email' => 'O Email deve ser um endereço de email válido.',
        'email.unique' => 'Este Email já está em uso.',
        'cpf.required' => 'O campo CPF é obrigatório.',
        'cpf.digits' => 'O CPF deve conter exatamente 11 dígitos.',
        'cpf.unique' => 'Este CPF já está cadastrado.',
        'salario.numeric' => 'O Salário deve ser um número.',
        'salario.between' => 'O Salário deve estar entre 0 e 9.999.999,99.',
    ];

    protected function rules()
    {
        $emailUniqueRule = 'unique:funcionarios,email';
        $cpfUniqueRule = 'unique:funcionarios,cpf';

        if ($this->funcionarioId) {
            $emailUniqueRule .= ',' . $this->funcionarioId;
            $cpfUniqueRule .= ',' . $this->funcionarioId;
        }

        return [
            'nome' => 'required|string|max:150',
            'email' => ['required', 'email', 'max:150', $emailUniqueRule],
            'cpf' => ['required', 'string', 'digits:11', $cpfUniqueRule],
            'cargo' => 'nullable|string|max:100',
            'dataAdmissao' => 'nullable|date',
            'salario' => 'nullable|numeric|between:0,9999999.99',
        ];
    }

    public function layout()
    {
        return 'layouts.app';
    }

    public function title()
    {
        return $this->funcionarioId ? 'Editar Funcionário' : 'Novo Funcionário';
    }

    public function mount(?Funcionario $funcionario = null)
    {
        if ($funcionario instanceof Funcionario) {
            $this->funcionarioId = $funcionario->id;
            $this->nome = $funcionario->nome;
            $this->email = $funcionario->email;
            $this->cpf = $funcionario->cpf;
            $this->cargo = $funcionario->cargo;
            $this->dataAdmissao = $funcionario->dataAdmissao ? Carbon::parse($funcionario->dataAdmissao)->format('Y-m-d') : null;
            $this->salario = $funcionario->salario;
        }
    }

    public function saveFuncionario()
    {
        $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);
        $this->validate();

        $data = [
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'cargo' => $this->cargo,
            'dataAdmissao' => $this->dataAdmissao,
            'salario' => $this->salario,
        ];

        try {
            if ($this->funcionarioId) {
                $funcionario = Funcionario::find($this->funcionarioId);
                if ($funcionario) {
                    $funcionario->update($data);
                    session()->flash('message', 'Funcionário atualizado com sucesso!');
                    Log::info('Funcionário ID ' . $this->funcionarioId . ' atualizado.');
                } else {
                    session()->flash('error', 'Funcionário não encontrado para atualização.');
                    Log::warning('Tentativa de atualização de funcionário inexistente ID: ' . $this->funcionarioId);
                }
            } else {
                Funcionario::create($data);
                session()->flash('message', 'Funcionário cadastrado com sucesso!');
                Log::info('Novo funcionário cadastrado: ' . $this->nome);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro ao salvar o funcionário: ' . $e->getMessage());
            Log::error('Erro ao salvar funcionário: ' . $e->getMessage(), ['data' => $data]);
        }

        return redirect()->route('funcionarios.index');
    }

    public function render()
    {
        return view('livewire.funcionario-form');
    }
}
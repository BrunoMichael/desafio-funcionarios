<?php

namespace App\Livewire;

use App\Models\Funcionario;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ListFuncionarios extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'nome';
    public $sortDirection = 'asc';
    public $confirmingFuncionarioDeletion = false;
    public $funcionarioIdToDelete;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function layout()
    {
        return 'layouts.app';
    }


    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
    }

    public function confirmFuncionarioDeletion($id)
    {
        $funcionario = Funcionario::find($id);
        if ($funcionario) {
            $this->confirmingFuncionarioDeletion = true;
            $this->funcionarioIdToDelete = $id;
            Log::info('Modal de exclusão aberto para o funcionário ID: ' . $id);
        } else {
            Log::warning('Tentativa de abrir modal para funcionário inexistente ID: ' . $id);
        }
    }

    public function deleteFuncionario()
    {
        if ($this->funcionarioIdToDelete) {
            $deleted = Funcionario::destroy($this->funcionarioIdToDelete);
            if ($deleted) {
                $this->confirmingFuncionarioDeletion = false;
                $this->funcionarioIdToDelete = null;
                session()->flash('message', 'Funcionário excluído com sucesso!');
                Log::info('Funcionário ID ' . $this->funcionarioIdToDelete . ' excluído com sucesso.');
            } else {
                session()->flash('error', 'Erro ao excluir funcionário.');
                Log::error('Falha ao excluir funcionário ID: ' . $this->funcionarioIdToDelete);
            }
        } else {
            session()->flash('error', 'Nenhum funcionário selecionado para exclusão.');
            Log::warning('Tentativa de excluir funcionário sem ID selecionado.');
        }
        $this->resetPage();
    }

    public function cancelFuncionarioDeletion()
    {
        $this->confirmingFuncionarioDeletion = false;
        $this->funcionarioIdToDelete = null;
        Log::info('Modal de exclusão cancelado e fechado.');
    }

    public function render()
    {
        $funcionarios = Funcionario::query()
            ->when($this->search, function ($query) {
                $query->where('nome', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('cpf', 'like', '%' . $this->search . '%')
                    ->orWhere('cargo', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.list-funcionarios', [
            'funcionarios' => $funcionarios,
        ]);
    }
}
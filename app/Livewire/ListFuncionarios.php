<?php

namespace App\Livewire;

use App\Models\Funcionario;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

/**
 * Componente Livewire para listagem, pesquisa, ordenação e exclusão de Funcionários.
 *
 * Funcionalidades:
 * - Paginação com Livewire
 * - Pesquisa dinâmica por nome, email, cpf ou cargo
 * - Ordenação crescente/decrescente por colunas
 * - Confirmação e exclusão de funcionário com modal
 * - Logs de ações importantes para auditoria
 *
 * Padrão recomendado para componentes de listagem:
 * - Uso do trait WithPagination para paginação automática
 * - Propriedades públicas para filtros, ordenação e controle de estado
 * - Métodos claros para atualização do estado (ex: updatingSearch)
 * - Feedback e logs para cada ação relevante
 * - Renderização da view com os dados filtrados e paginados
 *
 * @package App\Livewire
 */
class ListFuncionarios extends Component
{
    use WithPagination; // Habilita paginação automática do Livewire

    // Filtros e ordenação usados na consulta
    public $search = ''; // Termo de busca do usuário
    public $sortBy = 'nome'; // Coluna padrão para ordenação
    public $sortDirection = 'asc'; // Direção padrão de ordenação

    // Controle da modal de confirmação de exclusão
    public $confirmingFuncionarioDeletion = false; // Exibe ou não modal de confirmação
    public $funcionarioIdToDelete; // Guarda o ID do funcionário que será excluído

    /**
     * Método chamado automaticamente pelo Livewire ao atualizar o campo de busca.
     * Reseta a página da paginação para a primeira página.
     *
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Define o layout utilizado pelo componente.
     *
     * @return string Nome do layout blade
     */
    public function layout()
    {
        return 'layouts.app';
    }

    /**
     * Altera a coluna de ordenação e alterna a direção (asc/desc) se a mesma coluna for clicada novamente.
     *
     * @param string $field Nome da coluna para ordenar
     * @return void
     */
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            // Alterna a direção de ordenação
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // Define nova coluna e padrão ascendente
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
    }

    /**
     * Abre o modal de confirmação para exclusão de um funcionário.
     * Verifica se o funcionário existe antes de abrir o modal.
     *
     * @param int $id ID do funcionário a ser excluído
     * @return void
     */
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

    /**
     * Executa a exclusão do funcionário confirmado.
     * Se a exclusão for bem-sucedida, emite mensagem de sucesso e limpa variáveis.
     * Em caso de erro, emite mensagem de erro e registra no log.
     *
     * @return void
     */
    public function deleteFuncionario()
    {
        if ($this->funcionarioIdToDelete) {
            $deleted = Funcionario::destroy($this->funcionarioIdToDelete);
            if ($deleted) {
                // Guarda o ID para log antes de zerar a variável
                $deletedId = $this->funcionarioIdToDelete;

                $this->confirmingFuncionarioDeletion = false;
                $this->funcionarioIdToDelete = null;

                session()->flash('message', 'Funcionário excluído com sucesso!');
                Log::info('Funcionário ID ' . $deletedId . ' excluído com sucesso.');
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

    /**
     * Cancela a exclusão e fecha o modal.
     * Limpa as variáveis de controle.
     *
     * @return void
     */
    public function cancelFuncionarioDeletion()
    {
        $this->confirmingFuncionarioDeletion = false;
        $this->funcionarioIdToDelete = null;
        Log::info('Modal de exclusão cancelado e fechado.');
    }

    /**
     * Renderiza a view com os funcionários filtrados, ordenados e paginados.
     * Aplica busca dinâmica por nome, email, cpf e cargo.
     *
     * @return \Illuminate\View\View
     */
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

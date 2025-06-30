<?php

namespace App\Livewire;

use App\Models\Funcionario;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * Componente Livewire para criação e edição de Funcionários.
 *
 * Controla o formulário com os dados do funcionário e validação.
 * Salva os dados no banco de dados, tratando inserção e atualização.
 *
 * Padrão para próximos componentes de formulários:
 * - Propriedades públicas para campos do formulário
 * - Regras de validação definidas em método rules()
 * - Mensagens customizadas em $messages
 * - Método mount() para inicializar dados (edição)
 * - Método saveFuncionario() para validar e salvar os dados
 * - Log e feedback via session para operações
 * - Método render() para retornar a view do componente
 *
 * @package App\Livewire
 */
class FuncionarioForm extends Component
{
    // Propriedades públicas correspondentes aos campos do formulário
    public $funcionarioId; // id do funcionário para edição (null se cadastro novo)
    public $nome;
    public $email;
    public $cpf;
    public $cargo;
    public $dataAdmissao;
    public $salario;

    /**
     * Mensagens personalizadas para validação.
     * Mantém padrão claro para comunicação com o usuário.
     * Chave => mensagem
     *
     * @var array
     */
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

    /**
     * Regras de validação para os campos do formulário.
     *
     * O método adapta a regra unique para email e cpf quando em edição,
     * ignorando o registro atual.
     *
     * @return array Regras de validação
     */
    protected function rules()
    {
        // Regras unique que desconsideram o registro atual (no update)
        $emailUniqueRule = 'unique:funcionarios,email';
        $cpfUniqueRule = 'unique:funcionarios,cpf';

        if ($this->funcionarioId) {
            // Ignora o funcionário atual nas validações unique para update
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
     * Define o título da página/formulário baseado no contexto.
     *
     * @return string
     */
    public function title()
    {
        return $this->funcionarioId ? 'Editar Funcionário' : 'Novo Funcionário';
    }

    /**
     * Monta o componente com dados existentes (edição).
     *
     * Recebe um objeto Funcionario opcional para popular o formulário.
     * Converte datas para formato Y-m-d para input date.
     *
     * @param Funcionario|null $funcionario
     * @return void
     */
    public function mount(?Funcionario $funcionario = null)
    {
        if ($funcionario instanceof Funcionario) {
            $this->funcionarioId = $funcionario->id;
            $this->nome = $funcionario->nome;
            $this->email = $funcionario->email;
            $this->cpf = $funcionario->cpf;
            $this->cargo = $funcionario->cargo;
            // Formata data para campo date (ex: 2024-01-30)
            $this->dataAdmissao = $funcionario->dataAdmissao ? Carbon::parse($funcionario->dataAdmissao)->format('Y-m-d') : null;
            $this->salario = $funcionario->salario;
        }
    }

    /**
     * Valida os dados e salva o funcionário.
     * Realiza inserção ou atualização conforme $funcionarioId.
     *
     * Faz limpeza do CPF para manter apenas números.
     * Em caso de sucesso exibe mensagem via session e registra log.
     * Em caso de erro exibe mensagem e registra log de erro.
     *
     * @return \Illuminate\Http\RedirectResponse Redireciona para lista de funcionários
     */
    public function saveFuncionario()
    {
        // Remove caracteres não numéricos do CPF
        $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);

        // Valida os dados conforme regras definidas
        $this->validate();

        // Dados preparados para salvar no banco
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
                // Atualiza funcionário existente
                $funcionario = Funcionario::find($this->funcionarioId);
                if ($funcionario) {
                    $funcionario->update($data);
                    session()->flash('message', 'Funcionário atualizado com sucesso!');
                    Log::info('Funcionário ID ' . $this->funcionarioId . ' atualizado.');
                } else {
                    // Caso o funcionário não exista mais no banco
                    session()->flash('error', 'Funcionário não encontrado para atualização.');
                    Log::warning('Tentativa de atualização de funcionário inexistente ID: ' . $this->funcionarioId);
                }
            } else {
                // Cria novo funcionário
                Funcionario::create($data);
                session()->flash('message', 'Funcionário cadastrado com sucesso!');
                Log::info('Novo funcionário cadastrado: ' . $this->nome);
            }
        } catch (\Exception $e) {
            // Captura erros inesperados e registra log
            session()->flash('error', 'Ocorreu um erro ao salvar o funcionário: ' . $e->getMessage());
            Log::error('Erro ao salvar funcionário: ' . $e->getMessage(), ['data' => $data]);
        }

        // Redireciona para rota da listagem de funcionários
        return redirect()->route('funcionarios.index');
    }

    /**
     * Renderiza a view do componente Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.funcionario-form');
    }
}

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lista de Funcionários
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session()->has('message'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-100 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                        <svg class="fill-current h-6 w-6 text-green-500 dark:text-green-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Fechar</title>
                            <path d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.107l-2.651 2.652a1.2 1.2 0 11-1.697-1.697L8.303 9.414 5.651 6.763a1.2 1.2 0 011.697-1.697L10 7.72l2.651-2.651a1.2 1.2 0 011.697 1.697L11.697 9.414l2.651 2.651a1.2 1.2 0 010 1.697z" />
                        </svg>
                    </span>
                </div>
                @endif
                @if (session()->has('error'))
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-100 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                        <svg class="fill-current h-6 w-6 text-red-500 dark:text-red-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Fechar</title>
                            <path d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.107l-2.651 2.652a1.2 1.2 0 11-1.697-1.697L8.303 9.414 5.651 6.763a1.2 1.2 0 011.697-1.697L10 7.72l2.651-2.651a1.2 1.2 0 011.697 1.697L11.697 9.414l2.651 2.651a1.2 1.2 0 010 1.697z" />
                        </svg>
                    </span>
                </div>
                @endif

                <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-4 sm:space-y-0 sm:space-x-4">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar funcionários..."
                        class="flex-grow w-full sm:w-auto border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                    <a href="{{ route('funcionarios.create') }}"
                        class="w-full sm:w-auto inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-500 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition duration-150 justify-center">
                        Novo Funcionário
                    </a>
                </div>

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg scrollbar-dark">
                    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="py-3 px-6">#</th>
                                @foreach (['nome', 'email', 'cpf', 'cargo', 'dataAdmissao', 'salario'] as $field)
                                <th scope="col" class="py-3 px-6 cursor-pointer" wire:click="sortBy('{{ $field }}')">
                                    {{ ucfirst($field === 'dataAdmissao' ? 'Data de Admissão' : $field) }}
                                    @if ($sortBy === $field)
                                    <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($funcionarios as $funcionario)
                            <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-4 px-6 whitespace-nowrap space-x-4 flex items-center">
                                    <a href="{{ route('funcionarios.edit', $funcionario->id) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
                                        title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0 00.707-.293l9.914-9.914a1 1 0 000-1.414l-4.586-4.586a1 1 0 00-1.414 0L4 15.414V20z" />
                                        </svg>
                                    </a>

                                    <button wire:click="confirmFuncionarioDeletion({{ $funcionario->id }})"
                                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"
                                        title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="py-4 px-6">{{ $funcionario->nome }}</td>
                                <td class="py-4 px-6">{{ $funcionario->email }}</td>
                                <td class="py-4 px-6">{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $funcionario->cpf) }}</td>
                                <td class="py-4 px-6">{{ $funcionario->cargo }}</td>
                                <td class="py-4 px-6">{{ $funcionario->dataAdmissao ? \Carbon\Carbon::parse($funcionario->dataAdmissao)->format('d/m/Y') : 'N/A' }}</td>
                                <td class="py-4 px-6">R$ {{ number_format($funcionario->salario, 2, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr class="bg-white dark:bg-gray-800">
                                <td colspan="7" class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum funcionário encontrado.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $funcionarios->links() }}
                </div>

                @if ($confirmingFuncionarioDeletion)
                <div x-data="{ open: @entangle('confirmingFuncionarioDeletion') }" x-show="open"
                    x-transition class="fixed inset-0 bg-gray-600 bg-opacity-50 dark:bg-opacity-70 flex items-center justify-center z-50">
                    <div x-show="open"
                        x-transition class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg max-w-sm w-full text-gray-800 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-2">Confirmar Exclusão</h3>
                        <p class="mb-4">Tem certeza que deseja excluir este funcionário? Esta ação não poderá ser desfeita.</p>
                        <div class="flex justify-end space-x-4">
                            <button @click="open = false; $wire.cancelFuncionarioDeletion()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">Cancelar</button>
                            <button wire:click="deleteFuncionario" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800">Excluir</button>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
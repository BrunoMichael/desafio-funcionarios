<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Mensagem de sucesso via session, exibida quando Livewire seta session()->flash('message') --}}
                @if (session()->has('message'))
                    <div
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                        {{-- Botão para fechar o alerta usando JS puro --}}
                        <button
                            type="button"
                            class="absolute top-0 bottom-0 right-0 px-4 py-3"
                            onclick="this.parentElement.style.display='none'"
                            aria-label="Fechar alerta">
                            <svg
                                class="fill-current h-6 w-6 text-green-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                role="img"
                                aria-hidden="true">
                                <title>Close</title>
                                <path
                                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.107l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 9.414 5.651 6.763a1.2 1.2 0 0 1 1.697-1.697L10 7.72l2.651-2.651a1.2 1.2 0 0 1 1.697 1.697l-2.652 2.651 2.652 2.651a1.2 1.2 0 0 1 0 1.697z" />
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- Mensagem de erro via session, exibida quando Livewire seta session()->flash('error') --}}
                @if (session()->has('error'))
                    <div
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <button
                            type="button"
                            class="absolute top-0 bottom-0 right-0 px-4 py-3"
                            onclick="this.parentElement.style.display='none'"
                            aria-label="Fechar alerta">
                            <svg
                                class="fill-current h-6 w-6 text-red-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                role="img"
                                aria-hidden="true">
                                <title>Close</title>
                                <path
                                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.107l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 9.414 5.651 6.763a1.2 1.2 0 0 1 1.697-1.697L10 7.72l2.651-2.651a1.2 1.2 0 0 1 1.697 1.697l-2.652 2.651 2.652 2.651a1.2 1.2 0 0 1 0 1.697z" />
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- Formulário com Livewire: o submit é interceptado por Livewire, chamando o método saveFuncionario --}}
                <form wire:submit.prevent="saveFuncionario">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Campo nome com binding Livewire direto --}}
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                            <input
                                type="text"
                                id="nome"
                                wire:model="nome" {{-- Livewire faz o bind reativo com a propriedade $nome --}}
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                            {{-- Exibe erros de validação para 'nome' --}}
                            @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Campo email com binding lazy do Livewire (atualiza quando perde foco) --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input
                                type="email"
                                id="email"
                                wire:model.lazy="email" {{-- Atualiza no Livewire ao perder foco --}}
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Campo CPF com binding Livewire e uso do Alpine.js para máscara --}}
                        <div>
                            <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CPF</label>
                            <input
                                type="text"
                                id="cpf"
                                wire:model.debounce.300ms="cpf" {{-- Atualiza no Livewire após 300ms sem digitação --}}
                                x-data {{-- Inicializa Alpine.js neste input --}}
                                x-mask="999.999.999-99" {{-- Máscara de CPF usando Alpine.js e plugin de máscara --}}
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                            @error('cpf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Campo cargo com binding Livewire --}}
                        <div>
                            <label for="cargo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargo</label>
                            <input
                                type="text"
                                id="cargo"
                                wire:model="cargo"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                            @error('cargo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Campo data de admissão com binding Livewire --}}
                        <div>
                            <label for="dataAdmissao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Admissão</label>
                            <input
                                type="date"
                                id="dataAdmissao"
                                wire:model="dataAdmissao"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                            @error('dataAdmissao') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Campo salário com binding Livewire --}}
                        <div>
                            <label for="salario" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Salário</label>
                            <input
                                type="number"
                                step="0.01"
                                id="salario"
                                wire:model="salario"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500
                                dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                            @error('salario') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Botões do formulário --}}
                    <div class="mt-6 flex justify-end space-x-3">
                        {{-- Link para cancelar e voltar para listagem --}}
                        <a
                            href="{{ route('funcionarios.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md
                            font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400
                            focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25
                            transition ease-in-out duration-150
                            dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            Cancelar
                        </a>
                        {{-- Botão submit que dispara o metodo saveFuncionario via Livewire --}}
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md
                            font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900
                            focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25
                            transition ease-in-out duration-150">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

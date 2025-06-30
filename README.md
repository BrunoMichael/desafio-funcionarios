# Projeto de Gerenciamento de Funcionários

Este README.md documenta os comandos essenciais e as melhores práticas de desenvolvimento utilizadas neste projeto. **Desenvolvido com a stack TALL (Tailwind CSS, Alpine.js, Laravel e Livewire)**, que venho estudando há cerca de um mês. No meu dia a dia de trabalho, utilizo principalmente PHP e Laravel. Esta foi minha primeira experiência prática com Alpine.js e Livewire em um contexto de teste, embora já tivesse feito alguns estudos prévios.

**Pré-requisitos:**
Antes de iniciar, certifique-se de que você tem o PHP e o MySQL instalados e configurados em seu ambiente. Para um guia detalhado de instalação no Windows, consulte o arquivo [instalacao-windows.md](instalacao-windows.md).

## 🚀 Como Iniciar o Projeto

1.  **Clone o repositório** (se ainda não o fez):

    ```bash
    git clone [https://github.com/BrunoMichael/desafio-funcionarios](https://github.com/BrunoMichael/desafio-funcionarios)
    cd desafio-funcionarios
    ```

2.  **Instale as dependências do Composer (PHP):**

    ```bash
    composer install
    ```

3.  **Copie o arquivo de ambiente e configure-o:**

    ```bash
    cp .env.example .env
    # Edite o arquivo .env com suas configurações de banco de dados
    # DB_CONNECTION=mysql
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=desafio_funcionarios
    # DB_USERNAME=your_username
    # DB_PASSWORD=your_password
    ```

4.  **Gere a chave da aplicação:**

    ```bash
    php artisan key:generate
    ```

5.  **Execute as migrações do banco de dados e os seeders:**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6.  **Instale as dependências do Node.js (frontend):**

    ```bash
    npm install
    ```

7.  **Compile os assets frontend (e mantenha o watch mode em desenvolvimento):**

    ```bash
    npm run dev
    ```

8.  **Inicie o servidor de desenvolvimento do Laravel:**

    ```bash
    php artisan serve
    # Mantenha este comando rodando em outro terminal separado.
    ```

Agora o projeto deve estar acessível em `http://127.0.0.1:8000`.

-----

## ⚙️ Comandos Essenciais do Laravel Artisan

| Comando                        | Descrição                                                                                                    |
| :----------------------------- | :----------------------------------------------------------------------------------------------------------- |
| `php artisan serve`            | Inicia o servidor de desenvolvimento local.                                                                  |
| `php artisan migrate`          | Executa as migrações do banco de dados para criar ou atualizar as tabelas.                                   |
| `php artisan db:seed`          | Executa os seeders para popular o banco de dados com dados de teste.                                         |
| `php artisan route:list`       | Lista todas as rotas registradas na aplicação. Útil para depuração de rotas.                                 |
| `php artisan make:model <Nome>`| Cria um novo modelo Eloquent. Use `-m` para criar a migração junto (`php artisan make:model Funcionario -m`). |
| `php artisan make:controller <Nome>` | Cria um novo controlador.                                                                              |

-----

## 🧹 Comandos de Limpeza de Cache (Depuração)

Esses comandos são vitais para resolver problemas onde as mudanças no código não estão sendo refletidas na aplicação, geralmente devido a caches persistentes do Laravel.

| Comando                      | Descrição                                                                                             |
| :--------------------------- | :---------------------------------------------------------------------------------------------------- |
| `php artisan optimize:clear` | **Recomendado para limpeza geral.** Limpa o cache de configuração, rotas, views e da aplicação.       |
| `php artisan config:clear`   | Limpa o cache de configuração.                                                                        |
| `php artisan route:clear`    | Limpa o cache de rotas. **Crucial após modificar `routes/web.php` ou `routes/api.php`.** |
| `php artisan view:clear`     | Limpa o cache de views Blade compiladas.                                                              |
| `php artisan cache:clear`    | Limpa o cache da aplicação configurado no `config/cache.php`.                                         |
| `composer dump-autoload`     | Regera o arquivo de otimização de autoload do Composer. Útil após adicionar novas classes ou namespaces. |

-----

## ⚡ Comandos Específicos do Livewire

| Comando                          | Descrição                                                                     |
| :------------------------------- | :---------------------------------------------------------------------------- |
| `php artisan make:livewire <NomeComponente>` | Cria um novo componente Livewire (classe PHP e arquivo Blade).          |
| `php artisan livewire:publish --config` | Publica o arquivo de configuração `config/livewire.php`. **Essencial para definir o layout padrão.** |
| `php artisan livewire:publish --assets` | Publica os assets do Livewire na pasta `public/vendor/livewire`. Normalmente não é necessário, pois o Vite cuida disso. |

-----

## 📦 Comandos do NPM (Frontend)

| Comando                          | Descrição                                                                                                              |
| :------------------------------- | :--------------------------------------------------------------------------------------------------------------------- |
| `npm install`                    | Instala todas as dependências do Node.js listadas no `package.json`.                                                    |
| `npm run dev`                    | Compila os assets para desenvolvimento (com watch mode padrão).                                                         |
| `npm run build`                  | Compila e minifica os assets para produção.                                                                            |
| `npm cache clean --force`        | Limpa o cache do npm de forma forçada. Útil em problemas de dependência.                                               |
| `rm -rf node_modules package-lock.json` | **Comando agressivo\!** Remove as pastas `node_modules` e o arquivo `package-lock.json`. Use antes de `npm install` para uma instalação limpa. (No Windows, use `rd /s /q node_modules` e `del package-lock.json`) |

-----

## 🧪 Testes

O Laravel vem com suporte para testes unitários e de funcionalidade.

| Comando             | Descrição                                                                                                                              |
| :------------------ | :------------------------------------------------------------------------------------------------------------------------------------- |
| `php artisan test`  | Executa todos os testes da aplicação.                                                                                                  |
| `php artisan make:test <NomeTeste>` | Cria um novo arquivo de teste na pasta `tests/Feature` (para testes de funcionalidade) ou `tests/Unit` (para testes unitários). |

*Observação: Para este projeto, foi criado o teste de funcionalidade `tests/Feature/FuncionarioFormTest.php` para validar o comportamento do formulário.*

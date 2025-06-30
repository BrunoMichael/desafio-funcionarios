# Guia de Instalação para Ambiente Laravel no Windows

## 1. Instalar o PHP

Baixe a versão 8.2 do PHP:

```
https://windows.php.net/downloads/releases/php-8.2.28-Win32-vs16-x64.zip
```

Extraia para o diretório:

```
C:\server\php-8.2.28
```

### Adicionando PHP ao PATH

1. Abra **Editar variáveis de ambiente do sistema**.
2. Em **Variáveis de usuário**, selecione `Path` > **Editar**.
3. Clique em **Novo** e adicione:

```
C:\server\php-8.2.28
```

### Verificando a instalação

Abra o **CMD** e execute:

```bash
php -v
```

Saída esperada:

```bash
PHP 8.2.28 (cli) (built: Mar 11 2025 18:37:30) (ZTS Visual C++ 2019 x64)
```

---

## 2. Instalar o MySQL

> Pule se já tiver o MySQL instalado.

### Baixar MySQL 5.5

```
https://dev.mysql.com/downloads/mysql/5.5.html?os=3&version=5
```

* Escolha: **Windows (x86, 64-bit), ZIP Archive**
* Crie:

```
C:\server\mysql
```

* Extraia o ZIP para essa pasta.

### Criar subpastas

```
C:\server\mysql\data
C:\server\mysql\logs
```

### Criar o `my.ini`

Crie `C:\server\mysql\my.ini` com:

```ini
[mysqld]
basedir=C:/server/mysql
datadir=C:/server/mysql/data
port=3306
sql_mode=NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES
```

### Inicializar banco (sem senha)

```bash
cd C:\server\mysql\bin
mysqld --initialize-insecure
```

### Registrar como serviço do Windows

```bash
mysqld --install MySQL --defaults-file="C:\server\mysql\my.ini"
```

### Iniciar o serviço

```bash
net start MySQL
```

---

## 3. Instalar o PhpMyAdmin

Baixe:

```
https://files.phpmyadmin.net/phpMyAdmin/5.2.2/phpMyAdmin-5.2.2-all-languages.zip
```

* Crie a pasta:

```
C:\server\www\phpmyadmin
```

* Extraia o conteúdo do ZIP nela.

Acesse via navegador após configurar um servidor (Apache/Nginx).

---

## 4. Instalar o Composer

Baixe o instalador:

```
https://getcomposer.org/download/
```

Durante a instalação:

* Quando solicitado, selecione:

```
C:\server\php-8.2.28\php.exe
```

Verifique no **CMD**:

```bash
composer -V
```

---

## 5. Configurar o `php.ini`

### Localizar o arquivo

Vá até:

```
C:\server\php-8.2.28
```

Se `php.ini` não existir, renomeie:

* `php.ini-development` → `php.ini`

### Configurar diretório de extensões

No `php.ini`, ajuste:

```ini
extension_dir = "C:\server\php-8.2.28\ext"
```

### Habilitar extensões

Descomente:

```ini
extension=curl
extension=ffi
extension=ftp
extension=fileinfo
extension=gd
extension=gettext
extension=gmp
extension=intl
extension=imap
extension=mbstring
extension=exif
extension=mysqli
extension=odbc
extension=openssl
extension=pdo_mysql
extension=pdo_odbc
extension=pdo_pgsql
extension=pdo_sqlite
extension=sqlite3
extension=pgsql
extension=shmop
extension=zip
```

> Ative `oci8` apenas se usar Oracle.

---

## 6. Iniciar servidor PHP manualmente

```bash
cd C:\server\php-8.2.28
php.exe -S localhost:8000 -t C:\server\www
```

Acesse:

```
http://localhost:8000
```

PhpMyAdmin:

```
http://localhost:8000/phpmyadmin/index.php
```

---

## 7. Corrigir erro "AllowNoPassword" no PhpMyAdmin

### Definir senha para o root

Abra PowerShell como admin:

```bash
C:\server\mysql\bin\mysql.exe -u root
```

No prompt do MySQL:

```sql
ALTER USER 'root'@'localhost' IDENTIFIED BY 'admin';
FLUSH PRIVILEGES;
EXIT;
```

Reinicie o serviço:

```bash
net stop MySQL
net start MySQL
```

Acesse PhpMyAdmin:

* **Usuário:** `root`
* **Senha:** `admin`

---

✅ Ambiente Windows pronto para projetos Laravel com PHP 8.2, MySQL e PhpMyAdmin.

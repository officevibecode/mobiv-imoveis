# MOBIV Imóveis

Sistema de gestão de imóveis desenvolvido com Laravel 10, Livewire 3, Tailwind CSS e Alpine.js.

## Stack Tecnológica

- **Laravel** 10.49.0
- **PHP** 8.1+
- **Livewire** 3.6
- **Tailwind CSS** 3.x
- **Alpine.js** 3.x
- **Vite** 5.x
- **MySQL** 8.0+
- **Redis** (opcional)

## Requisitos

- PHP 8.1 ou superior
- Composer
- Node.js 18+ e NPM
- MySQL 8.0+
- Redis (opcional)

## Instalação

### 1. Clonar o repositório

```bash
git clone git@github.com:officevibecode/mobiv-imoveis.git
cd mobiv-imoveis
```

### 2. Instalar dependências PHP

```bash
composer install
```

### 3. Instalar dependências JavaScript

```bash
npm install
```

### 4. Configurar ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Edite o arquivo `.env` e configure as credenciais do banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mobiv_imoveis
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Criar base de dados

```bash
mysql -u root -p -e "CREATE DATABASE mobiv_imoveis CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 6. Executar migrações

```bash
php artisan migrate
```

## Executar o Projeto

### Desenvolvimento

Abra dois terminais:

**Terminal 1 - Servidor Laravel:**
```bash
php artisan serve
```

**Terminal 2 - Build de assets (Vite):**
```bash
npm run dev
```

Acesse: [http://localhost:8000](http://localhost:8000)

### Build de Produção

```bash
npm run build
```

## Scripts NPM Disponíveis

```bash
npm run dev          # Inicia Vite em modo desenvolvimento
npm run build        # Build de produção dos assets
```

## Scripts Composer Disponíveis

```bash
composer lint        # Executa Laravel Pint (code style)
composer lint:fix    # Corrige code style automaticamente
composer cs-fix      # Executa PHP CS Fixer
```

## Estrutura do Projeto

```
app/
├── Http/
│   ├── Controllers/
│   └── Livewire/
├── Models/
├── Services/           # Lógica de negócio
├── Repositories/       # Camada de acesso a dados
└── View/
    └── Components/     # Componentes Blade

resources/
├── css/
│   └── app.css        # Tailwind CSS
├── js/
│   └── app.js         # Alpine.js + Bootstrap
└── views/
    ├── layouts/
    └── livewire/

routes/
└── web.php            # Rotas web
```

## Tema de Cores

- **Primary:** `#01589F` (Azul MOBIV)
- **Accent:** `#C1D460` (Verde MOBIV)

As cores estão configuradas no `tailwind.config.js` e podem ser usadas como:
- `bg-primary`, `text-primary`, `border-primary`
- `bg-accent`, `text-accent`, `border-accent`

## Code Style

O projeto usa **Laravel Pint** e **PHP CS Fixer** para manter consistência no código.

Executar antes de cada commit:
```bash
composer lint
```

## Licença

Proprietário - MOBIV © 2025

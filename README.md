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

### 6. Executar migrações e seeders

```bash
php artisan migrate --seed
```

Este comando irá:
- Criar todas as tabelas da base de dados
- Popular com 50 imóveis de demonstração
- Criar 5 categorias e 12 tags
- Criar 1 utilizador admin (email: `imoveis@grupomobiv.pt`, password: `password`)
- Criar 1 token de feed demo

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

## Testes

O projeto usa **Pest PHP** para testes.

### Executar todos os testes

```bash
php artisan test
```

ou

```bash
./vendor/bin/pest
```

### Executar testes específicos

```bash
php artisan test --filter PropertyTest
```

### Testes disponíveis

- Criação de propriedades com campos obrigatórios
- Validação de slug único
- Relações (tags/categorias)
- Geração de gallery JSON pela factory
- Validação de casts e tipos

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

## Data Seeding (PT-PT)

O projeto inclui seeders realistas com dados em português de Portugal.

### Executar Seeding Completo

```bash
php artisan migrate:fresh --seed
```

Isto irá criar:
- **50 propriedades** (70% ativas, 15% reservadas, 10% vendidas, 5% rascunho)
- **5 categorias** (Apartamento, Moradia, Terreno, Loja/Comércio, Investimento)
- **12 tags** (Vista Mar, Pronto a Habitar, Remodelado, Garagem, etc.)
- **1 utilizador admin** (email: `office@vibecode.pt`, password: `M0biv#2025!`)
- **1 feeds token** (demo)

### Executar Seeders Individuais

```bash
php artisan db:seed --class=PropertySeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=TagSeeder
```

### Características dos Dados

- **Localização:** Cidades portuguesas reais (Lisboa, Porto, Cascais, Oeiras, Braga, Coimbra, Aveiro, Setúbal, Faro, Albufeira)
- **Coordenadas:** Latitude/longitude coerentes por região
- **Preços:** Ranges realistas por tipologia (T0: 80k-180k, T3: 220k-450k, T6: 500k-1.2M)
- **Áreas:** Coerentes com tipologia (T1: 50-75m², T4: 120-200m²)
- **Imagens:** Placeholders públicos via Picsum (5-8 por propriedade)
- **Descrições:** HTML com bullets, em PT-PT
- **SEO:** Títulos ≤70 chars, descrições ≤170 chars

> **Nota:** As imagens são URLs públicas de placeholder. Substitua por imagens reais em produção.

## Code Style

O projeto usa **Laravel Pint** e **PHP CS Fixer** para manter consistência no código.

Executar antes de cada commit:
```bash
composer lint
```

## Autenticação OTP (Sem Password)

### Fluxo de Autenticação

1. **Solicitar Código:**
```bash
POST /api/otp/request
{
  "email": "user@example.com"
}
```

2. **Verificar Código:**
```bash
POST /api/otp/verify
{
  "email": "user@example.com",
  "code": "123456"
}
```

### Configuração de E-mail

Adicione ao `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=imoveis@grupomobiv.pt
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=imoveis@grupomobiv.pt
MAIL_FROM_NAME="MOBIV Imóveis"
```

### Segurança

- **Rate Limiting:** 5 tentativas/hora por IP/email
- **Expiração:** Códigos expiram em 10 minutos
- **Bloqueio:** 5 tentativas falhadas = bloqueio de 15 minutos
- **Hash:** Códigos guardados com SHA-256

### Erros Comuns

- `Demasiadas tentativas` - Aguarde o tempo indicado
- `Código expirado` - Solicite novo código
- `Código inválido` - Verifique o código recebido por e-mail

## Analytics & RGPD

### Configuração

Adicione ao `.env`:
```env
GA4_ID=G-XXXXXXXXXX
FACEBOOK_PIXEL_ID=XXXXXXXXXX
```

### Consent Mode

- **Sem consentimento:** GA4/Pixel NÃO carregam
- **Com consentimento:** Scripts carregam automaticamente
- **Preferências:** Essenciais / Analytics / Marketing

### Eventos Tracked

- `property_view` - Visualização de imóvel
- `property_click` - Clique em card de imóvel
- `whatsapp_click` - Clique no CTA WhatsApp

## Licença

Proprietário - MOBIV © 2025

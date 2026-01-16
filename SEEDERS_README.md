# Sistema de Seeders - CodeVilla Qualitativas

## 📋 Índice

- [Visão Geral](#visão-geral)
- [Estrutura](#estrutura)
- [Uso Básico](#uso-básico)
- [Seeders por Ambiente](#seeders-por-ambiente)
- [Comando Customizado](#comando-customizado)
- [Factories](#factories)
- [Importação de Dados](#importação-de-dados)
- [Configurações](#configurações)

## 🎯 Visão Geral

O sistema de seeders foi completamente refatorado para:

- ✅ **Separação por ambiente**: Produção, Staging, Desenvolvimento
- ✅ **Idempotência**: Seeders podem ser executados múltiplas vezes sem duplicar dados
- ✅ **Feedback visual**: Mensagens coloridas e informativas
- ✅ **Tratamento de erros**: Try-catch em todos os seeders
- ✅ **Configuração centralizada**: Dados de negócio em `config/seeders.php`
- ✅ **Factories completas**: Para testes automatizados
- ✅ **Importação CSV/Excel**: Para dados reais
- ✅ **Staging com anonimização**: Cópia de produção com dados sensíveis protegidos

## 📁 Estrutura

```
database/
├── seeders/
│   ├── DatabaseSeeder.php         # Orquestrador principal (detecta ambiente)
│   ├── EssentialSeeder.php        # Dados essenciais (todos os ambientes)
│   ├── DevelopmentSeeder.php      # Dados fictícios (desenvolvimento)
│   ├── StagingSeeder.php          # Cópia de produção ou fake
│   ├── CriterioSeeder.php         # Critérios de avaliação
│   ├── DisciplinaSeeder.php       # Disciplinas do currículo
│   ├── UserSeeder.php             # Usuários base
│   ├── ProfessorSeeder.php        # Professores fictícios
│   ├── TurmaSeeder.php            # Turmas do ano letivo
│   ├── AlunoSeeder.php            # Alunos fictícios
│   └── AtribuicaoSeeder.php       # Relações professor-disciplina-turma
│
├── factories/
│   ├── UserFactory.php            # Geração de usuários
│   ├── TurmaFactory.php           # Geração de turmas
│   ├── AlunoFactory.php           # Geração de alunos
│   ├── DisciplinaFactory.php      # Geração de disciplinas
│   └── AvaliacaoFactory.php       # Geração de avaliações
│
config/
└── seeders.php                    # Configuração centralizada

app/
├── Imports/
│   ├── AlunosImport.php           # Importação de alunos via CSV/Excel
│   └── UsersImport.php            # Importação de usuários via CSV/Excel
│
├── Services/
│   └── DataAnonymizer.php         # Anonimização de dados sensíveis
│
└── Console/Commands/
    └── SeedEnvironment.php        # Comando customizado
```

## 🚀 Uso Básico

### Execução Padrão (Auto-detecta Ambiente)

```bash
php artisan db:seed
```

**Comportamento por ambiente:**

- **Production**: Apenas `EssentialSeeder` (critérios, disciplinas, dev user)
- **Staging**: 
  - Se `DATABASE_SOURCE_TYPE=production`: Copia de produção com anonimização
  - Se `DATABASE_SOURCE_TYPE=fake`: Dados fictícios completos
- **Local/Development/Testing**: `EssentialSeeder` + `DevelopmentSeeder`

### Execução de Seeder Específico

```bash
# Apenas dados essenciais
php artisan db:seed --class=EssentialSeeder

# Apenas desenvolvimento
php artisan db:seed --class=DevelopmentSeeder

# Staging com cópia de produção
php artisan db:seed --class=StagingSeeder
```

### Refresh + Seed

```bash
# ATENÇÃO: Apaga todos os dados!
php artisan migrate:fresh --seed
```

## 🌍 Seeders por Ambiente

### EssentialSeeder

**Propósito**: Dados indispensáveis para qualquer ambiente

**Cria:**
- ✅ 12 critérios de avaliação (c1 a c12)
- ✅ 10 disciplinas do currículo
- ✅ 1 usuário desenvolvedor (configurável em `config/seeders.php`)

**Quando usar:**
- Primeiro deploy em produção
- Setup inicial de qualquer ambiente
- Após `migrate:fresh`

```bash
php artisan db:seed --class=EssentialSeeder
```

### DevelopmentSeeder

**Propósito**: Dados fictícios para testes locais

**Cria:**
- ✅ 3 usuários base (dev, coord, professor)
- ✅ 8 professores fictícios
- ✅ 8 turmas (6ºA, 6ºB, 7ºA, 7ºB, 8ºA, 8ºB, 9ºA, 9ºB)
- ✅ ~200 alunos (25 por turma)
- ✅ Atribuições professor-disciplina-turma

**Quando usar:**
- Desenvolvimento local
- Testes de interface
- Testes automatizados

```bash
php artisan db:seed --class=DevelopmentSeeder
```

### StagingSeeder

**Propósito**: Ambiente de testes com dados realistas

**Modos de operação:**

#### 1. Dados Fictícios (padrão)
```bash
# .env
DATABASE_SOURCE_TYPE=fake

php artisan db:seed --class=StagingSeeder
```

#### 2. Cópia de Produção com Anonimização
```bash
# .env
DATABASE_SOURCE_TYPE=production
DATABASE_SOURCE_CONNECTION=mysql_production

# config/database.php (adicione conexão de produção)
'mysql_production' => [
    'driver' => 'mysql',
    'host' => env('PROD_DB_HOST'),
    'database' => env('PROD_DB_DATABASE'),
    'username' => env('PROD_DB_USERNAME'),
    'password' => env('PROD_DB_PASSWORD'),
    // ...
],

php artisan db:seed --class=StagingSeeder
```

**Dados anonimizados:**
- Usuários: emails → `usuario_abc123@escola.com`
- Alunos: nomes → `João S. S.`
- Avaliações: observações sensíveis redatadas

**Dados preservados:**
- Critérios de avaliação
- Disciplinas
- Turmas
- Estrutura de dados
- Relacionamentos

## 🎮 Comando Customizado

### php artisan db:seed-environment

Comando inteligente com detecção de ambiente e flags específicas.

#### Flags Disponíveis

```bash
# Apenas dados essenciais
php artisan db:seed-environment --essential

# Dados de desenvolvimento (essencial + fictícios)
php artisan db:seed-environment --development

# Staging (com confirmação se for cópia de produção)
php artisan db:seed-environment --staging

# Produção (com confirmação obrigatória)
php artisan db:seed-environment --production
```

#### Auto-detecção (sem flags)

```bash
php artisan db:seed-environment
```

**Comportamento:**
- Detecta `app()->environment()`
- Executa seeders apropriados
- Exibe mensagens coloridas
- Solicita confirmação em produção

## 🏭 Factories

### Uso em Testes

```php
use App\Domains\Usuarios\Models\User;
use App\Domains\Alunos\Models\{Turma, Aluno};
use App\Domains\Disciplinas\Models\Disciplina;
use App\Domains\Avaliacoes\Models\Avaliacao;

// UserFactory
$professor = User::factory()->professor()->create();
$coord = User::factory()->coordenacao()->create();
$dev = User::factory()->desenvolvedor()->create();
$inativo = User::factory()->inactive()->create();

// TurmaFactory
$turma = Turma::factory()->create();
$turma2024 = Turma::factory()->ano(2024)->create();
$turmaInativa = Turma::factory()->inactive()->create();

// AlunoFactory
$aluno = Aluno::factory()->create(); // Com turma automática
$alunoComFoto = Aluno::factory()->withPhoto()->create();
$alunoNaTurma = Aluno::factory()->forTurma($turma->id)->create();
$alunoInativo = Aluno::factory()->inactive()->create();

// DisciplinaFactory
$disciplina = Disciplina::factory()->create();
$disciplinaInativa = Disciplina::factory()->inactive()->create();

// AvaliacaoFactory
$avaliacao = Avaliacao::factory()->create();
$avalFinali = Avaliacao::factory()->finalizada()->create();
$aval1Tri = Avaliacao::factory()->trimestre(1)->create();
$avalSemObs = Avaliacao::factory()->semObservacoes()->create();
```

### Uso em Tinker

```bash
php artisan tinker

>>> User::factory()->count(10)->create()
>>> Turma::factory()->count(5)->ano(2025)->create()
>>> Aluno::factory()->count(30)->forTurma(1)->create()
```

## 📤 Importação de Dados

### Importar Alunos via CSV/Excel

```php
use App\Imports\AlunosImport;
use Maatwebsite\Excel\Facades\Excel;

// Importar para uma turma específica
$turma = Turma::find(1);
$import = new AlunosImport($turma->id);

Excel::import($import, 'alunos.csv');

// Verificar resultados
$stats = $import->getStats();
// ['imported' => 25, 'skipped' => 2]

$errors = $import->getErrors();
// [['row' => 3, 'errors' => ['O campo email é obrigatório']]]
```

**Template CSV:** `storage/templates/alunos_template.csv`

```csv
nome,numero_chamada,turma,ano_letivo,ativo
João Silva,1,6 Ano A,2026,true
Maria Santos,2,6 Ano A,2026,true
```

### Importar Usuários via CSV/Excel

```php
use App\Imports\UsersImport;

$import = new UsersImport(); // Senha padrão: 'mudar@123'
// OU
$import = new UsersImport('senha_customizada');

Excel::import($import, 'usuarios.csv');
```

**Template CSV:** `storage/templates/usuarios_template.csv`

```csv
nome,email,role,password,ativo
Prof. João,joao@escola.com,professor,senha123,true
Coord. Maria,maria@escola.com,coordenacao,senha123,true
```

## ⚙️ Configurações

### config/seeders.php

```php
return [
    // Ano letivo atual (pode ser sobrescrito via ENV)
    'ano_letivo_atual' => env('SEEDER_ANO_LETIVO', date('Y')),

    // Critérios de avaliação (12 critérios)
    'criterios' => [
        ['codigo' => 'PART', 'descricao' => 'Participação e Interesse', ...],
        // ...
    ],

    // Disciplinas do currículo (10 disciplinas)
    'disciplinas' => [
        ['nome' => 'Português', 'codigo' => 'PORT', ...],
        // ...
    ],

    // Usuário desenvolvedor
    'dev_user' => [
        'name' => 'Desenvolvedor',
        'email' => 'dev@codevilla.com',
        'password' => 'Dev@2026',
        'role' => 'desenvolvedor',
    ],
];
```

### Variáveis de Ambiente (.env)

```bash
# Ano letivo customizado
SEEDER_ANO_LETIVO=2026

# Staging com cópia de produção
DATABASE_SOURCE_TYPE=production
DATABASE_SOURCE_CONNECTION=mysql_production

# Credenciais da conexão de produção
PROD_DB_HOST=proddb.example.com
PROD_DB_DATABASE=codevilla_prod
PROD_DB_USERNAME=readonly_user
PROD_DB_PASSWORD=secret
```

## 🐛 Correções Implementadas

### Bug do AtribuicaoSeeder
❌ **Antes**: `'roberto.ferreira@codevilla.edu.br' => 'Arte'`  
✅ **Depois**: `'roberto.ferreira@codevilla.edu.br' => 'Artes'`

### Idempotência
❌ **Antes**: `DB::table()->insert()` duplicava dados  
✅ **Depois**: `Model::firstOrCreate()` previne duplicações

### Hardcoded Emails
❌ **Antes**: Emails fixos no código  
✅ **Depois**: Emails definidos em array, fácil manutenção

### Ano Letivo
❌ **Antes**: `date('Y')` espalhado pelo código  
✅ **Depois**: `config('seeders.ano_letivo_atual')`

### Mensagens de Erro
❌ **Antes**: Falhas silenciosas  
✅ **Depois**: Try-catch com mensagens coloridas

## 📝 Exemplos de Uso

### Setup Inicial (Produção)

```bash
# 1. Rodar migrations
php artisan migrate

# 2. Criar dados essenciais
php artisan db:seed-environment --production

# 3. Importar dados reais via CSV
# (use interface ou comando personalizado)
```

### Setup Inicial (Desenvolvimento)

```bash
# Tudo de uma vez
php artisan migrate:fresh --seed

# Ou passo a passo
php artisan migrate:fresh
php artisan db:seed-environment --development
```

### Setup Staging com Produção

```bash
# 1. Configurar .env
DATABASE_SOURCE_TYPE=production
DATABASE_SOURCE_CONNECTION=mysql_production

# 2. Executar
php artisan migrate:fresh
php artisan db:seed-environment --staging

# Confirma cópia de produção? [yes/no]
> yes
```

### Testes Automatizados

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvaliacaoTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_avaliacao()
    {
        $avaliacao = Avaliacao::factory()
            ->finalizada()
            ->trimestre(1)
            ->create();

        $this->assertTrue($avaliacao->finalizada);
        $this->assertEquals(1, $avaliacao->trimestre);
    }
}
```

## 🔒 Segurança

### Produção
- ⚠️ Comando `db:seed-environment --production` requer confirmação
- ⚠️ Apenas `EssentialSeeder` é executado
- ⚠️ Não cria dados de teste

### Staging
- ✅ Anonimização automática quando copia de produção
- ✅ Emails sensíveis são mascarados
- ✅ Nomes parcialmente ocultados
- ✅ Observações de avaliação redatadas

### Development
- ⚠️ Dados fictícios não devem ir para produção
- ⚠️ Senhas padrão devem ser alteradas em produção

## 📚 Referências

- [Laravel Seeding](https://laravel.com/docs/11.x/seeding)
- [Laravel Factories](https://laravel.com/docs/11.x/eloquent-factories)
- [Laravel Excel](https://docs.laravel-excel.com/)
- [Maatwebsite Excel Import](https://docs.laravel-excel.com/3.1/imports/)

---

**Desenvolvido por**: CodeVilla  
**Última atualização**: 2026  
**Laravel Version**: 11.x

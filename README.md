<div align="center">
  <img src="public/assets/images/logo-codevilla.png" alt="Logo Codevilla" width="200"/>
  
  # Sistema de Avaliação Qualitativa
  ### Colégio Codevilla - Ensino Fundamental II
  
  [![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)](https://vuejs.org)
  [![Inertia.js](https://img.shields.io/badge/Inertia.js-2.x-9553E9?style=for-the-badge&logo=inertia&logoColor=white)](https://inertiajs.com)
  [![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
  [![License](https://img.shields.io/badge/license-MIT-green.svg?style=for-the-badge)](LICENSE)
  
  <p align="center">
    <strong>Plataforma completa para avaliação pedagógica baseada em critérios qualitativos</strong>
    <br/>
    <a href="#-sobre-o-projeto">Sobre</a> •
    <a href="#-funcionalidades">Funcionalidades</a> •
    <a href="#-instalação">Instalação</a> •
    <a href="#-tecnologias">Tecnologias</a> •
    <a href="#-documentação">Documentação</a>
  </p>
</div>

---

## 📋 Índice

- [Sobre o Projeto](#-sobre-o-projeto)
- [Funcionalidades](#-funcionalidades)
- [Arquitetura do Sistema](#-arquitetura-do-sistema)
- [Instalação](#-instalação-rápida)
- [Configuração Docker](#-configuração-docker)
- [Credenciais de Teste](#-credenciais-de-teste)
- [Critérios de Avaliação](#-critérios-de-avaliação)
- [Tecnologias](#-stack-tecnológica)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Rotas da Aplicação](#-rotas-da-aplicação)
- [Banco de Dados](#-banco-de-dados)
- [Comandos Úteis](#-comandos-úteis)
- [Status do Projeto](#-status-do-projeto)
- [Contribuindo](#-contribuindo)
- [Licença](#-licença)

---

## 🎯 Sobre o Projeto

O **Sistema de Avaliação Qualitativa** é uma plataforma web desenvolvida para o **Colégio Codevilla** que revoluciona o processo de avaliação pedagógica do Ensino Fundamental II. O sistema substitui métodos tradicionais por uma abordagem baseada em **12 critérios qualitativos** organizados em 5 grupos temáticos, proporcionando uma visão abrangente e holística do desenvolvimento dos alunos.

### 🎯 Objetivos

- **Avaliação Holística**: Avaliação além de notas numéricas, considerando aspectos comportamentais, socioemocionais e de desenvolvimento acadêmico
- **Automação Pedagógica**: Cálculo automático de notas baseado em critérios ponderados, eliminando processos manuais
- **Gestão Centralizada**: Plataforma única para coordenação, professores e acompanhamento de alunos
- **Relatórios Profissionais**: Exportação de dados em PDF e Excel para reuniões pedagógicas e documentação oficial

### 🌟 Diferenciais

- ✅ Interface moderna e intuitiva com **Vue 3** e **Tailwind CSS**
- ✅ Sistema de **roles** (Desenvolvedor, Coordenação, Professor)
- ✅ Navegação fluida sem recarregar a página (**Inertia.js**)
- ✅ Upload de fotos de alunos com processamento automático
- ✅ Ordenação alfabética e numeração automática de alunos
- ✅ Exportação de PDFs otimizados para impressão em 1 página
- ✅ Auditoria completa de ações com **Activity Logs**

---

## ✨ Funcionalidades

### 👨‍🏫 **Para Professores**

<table>
  <tr>
    <td width="50%">
      <h4>📊 Dashboard Personalizado</h4>
      <ul>
        <li>Visão geral de turmas e disciplinas atribuídas</li>
        <li>Estatísticas de avaliações pendentes</li>
        <li>Acesso rápido a avaliações do trimestre</li>
      </ul>
    </td>
    <td width="50%">
      <h4>📝 Sistema de Avaliação</h4>
      <ul>
        <li>Avaliação individual por aluno (12 critérios de 0-4)</li>
        <li>Cálculo automático da nota final ponderada</li>
        <li>Navegação sequencial entre alunos (Anterior/Próximo)</li>
      </ul>
    </td>
  </tr>
  <tr>
    <td width="50%">
      <h4>📈 Histórico e Acompanhamento</h4>
      <ul>
        <li>Visualização de avaliações anteriores</li>
        <li>Comparação de evolução trimestral</li>
        <li>Edição e exclusão de avaliações próprias</li>
      </ul>
    </td>
    <td width="50%">
      <h4>📄 Relatórios</h4>
      <ul>
        <li>Exportação CSV por turma/trimestre</li>
        <li>Geração de relatórios consolidados</li>
        <li>Filtros por disciplina e período</li>
      </ul>
    </td>
  </tr>
</table>

### 👩‍💼 **Para Coordenação**

<table>
  <tr>
    <td width="50%">
      <h4>👥 Gestão de Alunos</h4>
      <ul>
        <li>CRUD completo de alunos</li>
        <li>Upload e gerenciamento de fotos</li>
        <li>Ordenação alfabética automática</li>
        <li>Numeração automática por turma</li>
        <li>Vinculação a turmas e rematrículas</li>
      </ul>
    </td>
    <td width="50%">
      <h4>🏫 Gestão de Turmas</h4>
      <ul>
        <li>Criação e edição de turmas</li>
        <li>Controle de ano letivo e turno</li>
        <li>Listagem de alunos matriculados</li>
        <li>Exportação de relação de alunos (PDF/Excel)</li>
        <li>Ativação/desativação de turmas</li>
      </ul>
    </td>
  </tr>
  <tr>
    <td width="50%">
      <h4>🎓 Gestão de Professores</h4>
      <ul>
        <li>Cadastro e edição de professores</li>
        <li>Ativação/desativação de contas</li>
        <li>Visualização de atribuições</li>
        <li>Controle de acesso ao sistema</li>
      </ul>
    </td>
    <td width="50%">
      <h4>🔗 Sistema de Atribuições</h4>
      <ul>
        <li>Vinculação Professor → Turma → Disciplina</li>
        <li>Controle de ano letivo</li>
        <li>Listagem de atribuições por professor</li>
        <li>Remoção e reatribuição de turmas</li>
      </ul>
    </td>
  </tr>
  <tr>
    <td width="50%">
      <h4>📚 Gestão de Disciplinas</h4>
      <ul>
        <li>CRUD de disciplinas</li>
        <li>Definição de carga horária</li>
        <li>Organização por área do conhecimento</li>
      </ul>
    </td>
    <td width="50%">
      <h4>📊 Relatórios Gerenciais</h4>
      <ul>
        <li>Dashboard com estatísticas globais</li>
        <li>PDF profissional de relação de alunos</li>
        <li>Exportação Excel de turmas</li>
        <li>Relatórios de avaliações consolidadas</li>
      </ul>
    </td>
  </tr>
</table>

### 🛠️ **Para Desenvolvedores**

- **Gestão de Usuários**: CRUD completo de todos os perfis (Desenvolvedor, Coordenação, Professor)
- **Controle de Permissões**: Atribuição e revogação de roles
- **Dashboard Técnico**: Monitoramento de sistema e logs
- **Acesso Total**: Permissões administrativas completas

---

## 🏗️ Arquitetura do Sistema

### Estrutura em Camadas

```
┌─────────────────────────────────────────┐
│         Frontend (Vue 3 + Inertia)      │
│  ┌─────────┬─────────┬──────────────┐  │
│  │ Admin   │Professor│ Desenvolvedor│  │
│  │ Pages   │ Pages   │    Pages     │  │
│  └─────────┴─────────┴──────────────┘  │
└──────────────────┬──────────────────────┘
                   │ Inertia.js
┌──────────────────▼──────────────────────┐
│      Backend (Laravel 11 + PHP 8.2)     │
│  ┌───────────────────────────────────┐  │
│  │   Controllers (Admin/Professor)   │  │
│  ├───────────────────────────────────┤  │
│  │   Middlewares (Role-based Auth)   │  │
│  ├───────────────────────────────────┤  │
│  │   Models (Eloquent ORM)           │  │
│  ├───────────────────────────────────┤  │
│  │   Services (Business Logic)       │  │
│  └───────────────────────────────────┘  │
└──────────────────┬──────────────────────┘
                   │
┌──────────────────▼──────────────────────┐
│      Banco de Dados (MySQL 8.0)         │
│  ┌───────────────────────────────────┐  │
│  │ users, turmas, alunos, avaliacoes │  │
│  │ disciplinas, criterios, logs      │  │
│  └───────────────────────────────────┘  │
└─────────────────────────────────────────┘
```

### Fluxo de Dados

```
Usuario → Login → Middleware (Role Check) → Dashboard (Role-based)
                                               ↓
                  ┌────────────────────────────┼────────────────────────┐
                  ↓                            ↓                        ↓
          Admin Routes                  Professor Routes       Desenvolvedor Routes
          (Coordenação)                 (Professores)          (Desenvolvedores)
                  ↓                            ↓                        ↓
         CRUD Turmas/Alunos          Sistema de Avaliação       Gestão de Usuários
         Export PDF/Excel            Cálculo de Notas           Permissões
```

---

## 🚀 Instalação Rápida

### 📋 Pré-requisitos

| Requisito | Versão Mínima | Recomendado |
|-----------|---------------|-------------|
| PHP | 8.2 | 8.3+ |
| Composer | 2.5 | 2.7+ |
| Node.js | 18.x | 20.x LTS |
| MySQL | 8.0 | 8.4+ |
| Git | 2.0 | Latest |

### 🔧 Instalação Local

```bash
# 1️⃣ Clone o repositório
git clone https://github.com/seu-usuario/codevilla-qualitativas.git
cd codevilla-qualitativas

# 2️⃣ Instale as dependências PHP
composer install

# 3️⃣ Instale as dependências JavaScript
npm install

# 4️⃣ Configure o ambiente
cp .env.example .env
php artisan key:generate

# 5️⃣ Configure o banco de dados no arquivo .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=codevilla_qualitativas
DB_USERNAME=root
DB_PASSWORD=sua_senha

# 6️⃣ Execute as migrations e seeders
php artisan migrate:fresh --seed

# 7️⃣ Crie o link simbólico para storage
php artisan storage:link

# 8️⃣ Compile os assets para desenvolvimento
npm run dev

# 9️⃣ Em outro terminal, inicie o servidor
php artisan serve
```

✅ **Acesse**: `http://localhost:8000`

### 🐳 Configuração Docker

O projeto inclui configuração Docker completa para desenvolvimento rápido:

```bash
# 1️⃣ Copie o arquivo de ambiente Docker
cp .env.docker .env

# 2️⃣ Suba os containers
docker-compose up -d

# 3️⃣ Acesse o container da aplicação
docker exec -it codevilla-app bash

# 4️⃣ Dentro do container, execute
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm install
npm run build

# 5️⃣ Acesse a aplicação
# http://localhost:8080
```

**Serviços Docker:**
- **App (PHP 8.2)**: `localhost:8080`
- **MySQL 8.0**: `localhost:3307`
- **Redis**: `localhost:6380`
- **Mailhog**: `localhost:8025`

---

## 👤 Credenciais de Teste

### 🔑 Acesso Coordenação
```
Email: coord@codevilla.edu.br
Senha: password123
```

### 🔑 Acesso Professor
```
Email: professor@codevilla.edu.br
Senha: password123
```

### 🔑 Acesso Desenvolvedor
```
Email: dev@codevilla.edu.br
Senha: password123
```

> **⚠️ Importante**: Altere estas senhas em produção!

---

## 📊 Critérios de Avaliação

O sistema utiliza **12 critérios qualitativos** organizados em 5 grupos temáticos. Cada critério recebe uma pontuação de **0 a 4**, e a nota final é calculada automaticamente através de uma fórmula ponderada.

### 📋 Grupos e Critérios

<table>
<thead>
  <tr>
    <th width="25%">Grupo Temático</th>
    <th width="40%">Critérios</th>
    <th width="15%">Peso</th>
    <th width="20%">Escala</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td rowspan="2"><strong>📅 Assiduidade e Postura</strong></td>
    <td>Frequência e pontualidade</td>
    <td>0.6</td>
    <td rowspan="12">0 - Não Demonstrado<br>1 - Iniciante<br>2 - Em Desenvolvimento<br>3 - Desenvolvido<br>4 - Plenamente Desenvolvido</td>
  </tr>
  <tr>
    <td>Postura e disciplina em sala</td>
    <td>0.6</td>
  </tr>
  <tr>
    <td rowspan="2"><strong>🎯 Engajamento Acadêmico</strong></td>
    <td>Participação ativa nas aulas</td>
    <td>0.8</td>
  </tr>
  <tr>
    <td>Engajamento cognitivo</td>
    <td>0.8</td>
  </tr>
  <tr>
    <td rowspan="3"><strong>📝 Responsabilidade e Execução</strong></td>
    <td>Entrega das atividades</td>
    <td>1.0</td>
  </tr>
  <tr>
    <td>Organização do caderno/livro</td>
    <td>1.0</td>
  </tr>
  <tr>
    <td>Vistos e correções realizadas</td>
    <td>1.0</td>
  </tr>
  <tr>
    <td rowspan="3"><strong>🤝 Relações e Socioemocional</strong></td>
    <td>Respeito ao professor</td>
    <td>0.7</td>
  </tr>
  <tr>
    <td>Respeito aos colegas</td>
    <td>0.7</td>
  </tr>
  <tr>
    <td>Colaboração em grupo</td>
    <td>0.7</td>
  </tr>
  <tr>
    <td rowspan="2"><strong>🌱 Autonomia e Evolução</strong></td>
    <td>Autonomia</td>
    <td>0.7</td>
  </tr>
  <tr>
    <td>Evolução ao longo do trimestre</td>
    <td>0.7</td>
  </tr>
</tbody>
</table>

### 🧮 Fórmula de Cálculo

```python
# Cálculo da Nota Final (0 a 10)
nota_final = (Σ (valor_criterio_i / 4 × peso_i) / 9.0) × 10

# Onde:
# - valor_criterio_i: pontuação do critério (0-4)
# - peso_i: peso do critério (0.6, 0.7, 0.8 ou 1.0)
# - 9.0: soma total dos pesos
# - 10: conversão para escala 0-10
```

### 📈 Exemplo Prático

| Critério | Valor | Peso | Cálculo |
|----------|-------|------|---------|
| Frequência e pontualidade | 4 | 0.6 | (4/4) × 0.6 = 0.60 |
| Participação ativa | 3 | 0.8 | (3/4) × 0.8 = 0.60 |
| Entrega das atividades | 4 | 1.0 | (4/4) × 1.0 = 1.00 |
| Respeito ao professor | 4 | 0.7 | (4/4) × 0.7 = 0.70 |
| *... demais critérios ...* | ... | ... | ... |
| **Soma Total** | - | - | **8.50** |

**Nota Final**: `(8.50 / 9.0) × 10 = 9.44`

---

## 🛠️ Stack Tecnológica

### Backend

| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| **Laravel** | 11.x | Framework PHP full-stack |
| **PHP** | 8.2+ | Linguagem de programação |
| **MySQL** | 8.0+ | Banco de dados relacional |
| **Laravel Breeze** | 2.3+ | Kit de autenticação |
| **Spatie Permission** | 6.24+ | Gerenciamento de permissões |
| **Intervention Image** | 3.11+ | Manipulação de imagens |
| **Laravel Excel** | 3.1+ | Export/Import Excel |
| **DomPDF** | 3.1+ | Geração de PDFs |

### Frontend

| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| **Vue.js** | 3.4+ | Framework JavaScript progressivo |
| **Inertia.js** | 2.0+ | SPA sem API REST |
| **Tailwind CSS** | 3.2+ | Framework CSS utility-first |
| **Heroicons** | 2.2+ | Biblioteca de ícones |
| **Vite** | 6.0+ | Build tool e dev server |
| **Ziggy** | 2.0+ | Rotas Laravel em JavaScript |

### DevOps & Ferramentas

| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| **Docker** | 24.x | Containerização |
| **Docker Compose** | 2.x | Orquestração de containers |
| **Redis** | 7.x | Cache e filas |
| **Mailhog** | Latest | Captura de e-mails (dev) |
| **Laravel Pint** | 1.13+ | Code formatter |
| **PHPUnit** | 11.x | Testes unitários |

---

## 📁 Estrutura do Projeto

```
codevilla-qualitativas/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # Controllers da Coordenação
│   │   │   │   ├── AlunoController.php
│   │   │   │   ├── AtribuicaoController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── DisciplinaController.php
│   │   │   │   ├── ProfessorController.php
│   │   │   │   └── TurmaController.php
│   │   │   ├── Professor/                # Controllers do Professor
│   │   │   │   ├── AvaliacaoController.php
│   │   │   │   └── DashboardController.php
│   │   │   ├── Desenvolvedor/            # Controllers do Desenvolvedor
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── UserController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/                   # Middlewares customizados
│   │       ├── CheckCoordenacao.php
│   │       ├── CheckProfessor.php
│   │       ├── CheckRole.php
│   │       ├── DesenvolvedorMiddleware.php
│   │       └── HandleInertiaRequests.php
│   ├── Models/                           # Eloquent Models
│   │   ├── ActivityLog.php
│   │   ├── Aluno.php
│   │   ├── Avaliacao.php
│   │   ├── AvaliacaoCriterio.php
│   │   ├── Criterio.php
│   │   ├── Disciplina.php
│   │   ├── Turma.php
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/                       # Migrations do banco
│   │   ├── 2024_01_01_create_users_table.php
│   │   ├── 2024_01_02_create_disciplinas_table.php
│   │   ├── 2024_01_03_create_turmas_table.php
│   │   ├── 2024_01_04_create_alunos_table.php
│   │   ├── 2024_01_05_create_criterios_table.php
│   │   ├── 2024_01_06_create_avaliacoes_table.php
│   │   ├── 2024_01_07_create_avaliacao_criterio_table.php
│   │   ├── 2024_01_08_create_professor_disciplina_table.php
│   │   ├── 2024_01_09_create_professor_turma_table.php
│   │   └── 2024_01_10_create_activity_logs_table.php
│   └── seeders/                          # Seeders de dados
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── DisciplinaSeeder.php
│       ├── TurmaSeeder.php
│       ├── AlunoSeeder.php
│       ├── CriterioSeeder.php
│       ├── ProfessorSeeder.php
│       └── AtribuicaoSeeder.php
├── resources/
│   ├── js/
│   │   ├── Components/                   # Componentes Vue reutilizáveis
│   │   ├── Layouts/                      # Layouts da aplicação
│   │   │   └── AuthenticatedLayout.vue
│   │   └── Pages/                        # Páginas Inertia.js
│   │       ├── Admin/                    # Páginas da Coordenação
│   │       │   ├── Alunos/
│   │       │   ├── Atribuicoes/
│   │       │   ├── Dashboard.vue
│   │       │   ├── Disciplinas/
│   │       │   ├── Professores/
│   │       │   └── Turmas/
│   │       ├── Professor/                # Páginas do Professor
│   │       │   ├── Avaliacoes/
│   │       │   └── Dashboard.vue
│   │       ├── Desenvolvedor/            # Páginas do Desenvolvedor
│   │       │   ├── Dashboard.vue
│   │       │   └── Users/
│   │       └── Welcome.vue               # Página inicial
│   ├── views/                            # Views Blade
│   │   ├── app.blade.php                 # Layout principal
│   │   └── exports/
│   │       └── turmas-pdf.blade.php      # Template PDF
│   └── css/
│       └── app.css                       # Estilos globais
├── routes/
│   ├── web.php                           # Rotas web principais
│   └── auth.php                          # Rotas de autenticação
├── public/
│   ├── assets/
│   │   └── images/
│   │       └── logo-codevilla.png        # Logo da instituição
│   └── storage/                          # Link simbólico para fotos
├── storage/
│   └── app/
│       └── public/
│           └── fotos_alunos/             # Fotos dos alunos
├── docker/                               # Configurações Docker
├── .env.example                          # Exemplo de configuração
├── docker-compose.yml                    # Orquestração Docker
├── Dockerfile                            # Imagem Docker
└── README.md                             # Este arquivo
```

---

## �️ Rotas da Aplicação

### 🌐 Rotas Públicas

| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/` | Página inicial |
| GET | `/login` | Página de login |
| POST | `/login` | Processar login |
| GET | `/register` | Página de registro |
| POST | `/register` | Processar registro |

### 🔒 Rotas Autenticadas

#### Dashboard Principal
| Método | Rota | Redirecionamento |
|--------|------|------------------|
| GET | `/dashboard` | Redireciona baseado no role do usuário |

#### 👩‍💼 Rotas Admin/Coordenação (`/admin`)

<details>
<summary><strong>Turmas</strong></summary>

| Método | Rota | Ação | Nome da Rota |
|--------|------|------|--------------|
| GET | `/admin/turmas` | Listar turmas | `admin.turmas.index` |
| GET | `/admin/turmas/create` | Formulário criar turma | `admin.turmas.create` |
| POST | `/admin/turmas` | Salvar turma | `admin.turmas.store` |
| GET | `/admin/turmas/{id}` | Detalhes da turma | `admin.turmas.show` |
| GET | `/admin/turmas/{id}/edit` | Formulário editar turma | `admin.turmas.edit` |
| PUT | `/admin/turmas/{id}` | Atualizar turma | `admin.turmas.update` |
| DELETE | `/admin/turmas/{id}` | Excluir turma | `admin.turmas.destroy` |
| GET | `/admin/turmas/{id}/detalhes` | Detalhes + alunos | `admin.turmas.detalhes` |
| POST | `/admin/turmas/{id}/alunos` | Adicionar aluno | `admin.turmas.adicionar-aluno` |
| DELETE | `/admin/turmas/{id}/alunos/{aluno}` | Remover aluno | `admin.turmas.remover-aluno` |
| GET | `/admin/turmas/export/pdf` | Exportar PDF | `admin.turmas.export.pdf` |
| GET | `/admin/turmas/export/excel` | Exportar Excel | `admin.turmas.export.excel` |

</details>

<details>
<summary><strong>Alunos</strong></summary>

| Método | Rota | Ação | Nome da Rota |
|--------|------|------|--------------|
| GET | `/admin/turmas/{turma}/alunos/create` | Formulário criar aluno | `admin.turmas.alunos.create` |
| POST | `/admin/turmas/{turma}/alunos` | Salvar aluno | `admin.turmas.alunos.store` |
| GET | `/admin/alunos` | Listar todos os alunos | `admin.alunos.index` |
| GET | `/admin/alunos/{id}` | Detalhes do aluno | `admin.alunos.show` |
| GET | `/admin/alunos/{id}/edit` | Formulário editar aluno | `admin.alunos.edit` |
| PUT | `/admin/alunos/{id}` | Atualizar aluno | `admin.alunos.update` |
| DELETE | `/admin/alunos/{id}` | Excluir aluno | `admin.alunos.destroy` |
| GET | `/admin/alunos/{id}/detalhes` | Detalhes completos | `admin.alunos.detalhes` |

</details>

<details>
<summary><strong>Professores</strong></summary>

| Método | Rota | Ação | Nome da Rota |
|--------|------|------|--------------|
| GET | `/admin/professores` | Listar professores | `admin.professores.index` |
| GET | `/admin/professores/create` | Formulário criar professor | `admin.professores.create` |
| POST | `/admin/professores` | Salvar professor | `admin.professores.store` |
| GET | `/admin/professores/{id}` | Detalhes do professor | `admin.professores.show` |
| GET | `/admin/professores/{id}/edit` | Formulário editar professor | `admin.professores.edit` |
| PUT | `/admin/professores/{id}` | Atualizar professor | `admin.professores.update` |
| DELETE | `/admin/professores/{id}` | Excluir professor | `admin.professores.destroy` |

</details>

<details>
<summary><strong>Disciplinas</strong></summary>

| Método | Rota | Ação | Nome da Rota |
|--------|------|------|--------------|
| GET | `/admin/disciplinas` | Listar disciplinas | `admin.disciplinas.index` |
| GET | `/admin/disciplinas/create` | Formulário criar disciplina | `admin.disciplinas.create` |
| POST | `/admin/disciplinas` | Salvar disciplina | `admin.disciplinas.store` |
| GET | `/admin/disciplinas/{id}/edit` | Formulário editar disciplina | `admin.disciplinas.edit` |
| PUT | `/admin/disciplinas/{id}` | Atualizar disciplina | `admin.disciplinas.update` |
| DELETE | `/admin/disciplinas/{id}` | Excluir disciplina | `admin.disciplinas.destroy` |

</details>

<details>
<summary><strong>Atribuições (Professor → Turma → Disciplina)</strong></summary>

| Método | Rota | Ação | Nome da Rota |
|--------|------|------|--------------|
| GET | `/admin/atribuicoes` | Listar atribuições | `admin.atribuicoes.index` |
| GET | `/admin/atribuicoes/create` | Formulário criar atribuição | `admin.atribuicoes.create` |
| POST | `/admin/atribuicoes` | Salvar atribuição | `admin.atribuicoes.store` |
| DELETE | `/admin/atribuicoes/{id}` | Excluir atribuição | `admin.atribuicoes.destroy` |
| GET | `/admin/atribuicoes/professor/{id}` | Atribuições por professor | `admin.atribuicoes.professor` |

</details>

#### 👨‍🏫 Rotas Professor (`/professor`)

<details>
<summary><strong>Avaliações</strong></summary>

| Método | Rota | Ação | Nome da Rota |
|--------|------|------|--------------|
| GET | `/professor/dashboard` | Dashboard do professor | `professor.dashboard` |
| GET | `/professor/avaliacoes` | Listar avaliações | `professor.avaliacoes.index` |
| GET | `/professor/turma/{turma}/disciplina/{disciplina}/trimestre/{trimestre}` | Listar alunos para avaliar | `professor.avaliacoes.alunos` |
| GET | `/professor/avaliar/{aluno}/{disciplina}/{trimestre}` | Formulário de avaliação | `professor.avaliacoes.avaliar` |
| POST | `/professor/avaliacoes` | Salvar avaliação | `professor.avaliacoes.store` |
| PUT | `/professor/avaliacoes/{id}` | Atualizar avaliação | `professor.avaliacoes.update` |
| DELETE | `/professor/avaliacoes/{id}` | Excluir avaliação | `professor.avaliacoes.destroy` |

</details>

#### 🛠️ Rotas Desenvolvedor (`/desenvolvedor`)

<details>
<summary><strong>Gestão de Usuários</strong></summary>

| Método | Rota | Ação | Nome da Rota |
|--------|------|------|--------------|
| GET | `/desenvolvedor/dashboard` | Dashboard desenvolvedor | `desenvolvedor.dashboard` |
| GET | `/desenvolvedor/users` | Listar usuários | `desenvolvedor.users.index` |
| GET | `/desenvolvedor/users/create` | Formulário criar usuário | `desenvolvedor.users.create` |
| POST | `/desenvolvedor/users` | Salvar usuário | `desenvolvedor.users.store` |
| GET | `/desenvolvedor/users/{id}/edit` | Formulário editar usuário | `desenvolvedor.users.edit` |
| PUT | `/desenvolvedor/users/{id}` | Atualizar usuário | `desenvolvedor.users.update` |
| DELETE | `/desenvolvedor/users/{id}` | Excluir usuário | `desenvolvedor.users.destroy` |

</details>

---

## 💾 Banco de Dados

### 📊 Diagrama ER

```
┌─────────────────┐
│     users       │
│─────────────────│
│ id (PK)         │──┐
│ name            │  │
│ email           │  │
│ password        │  │
│ role            │  │
│ ativo           │  │
└─────────────────┘  │
                     │
    ┌────────────────┼────────────────────┐
    │                │                    │
    ↓                ↓                    ↓
┌─────────────┐ ┌──────────────┐ ┌──────────────────┐
│disciplinas  │ │professor_    │ │professor_turma   │
│─────────────│ │disciplina    │ │──────────────────│
│ id (PK)     │←┤──────────────├─┤ id (PK)          │
│ nome        │ │ user_id (FK) │ │ user_id (FK)     │──┐
│ carga_hor.  │ │ disciplina_  │ │ turma_id (FK)    │  │
│ ativa       │ │    id (FK)   │ │ disciplina_id (FK)│  │
└─────────────┘ └──────────────┘ │ ano_letivo       │  │
                                 └──────────────────┘  │
                                                       │
┌──────────────┐                                       │
│   turmas     │←──────────────────────────────────────┘
│──────────────│
│ id (PK)      │──┐
│ nome         │  │
│ ano_letivo   │  │
│ turno        │  │
│ ativa        │  │
└──────────────┘  │
                  │
                  ↓
┌───────────────────┐
│      alunos       │
│───────────────────│
│ id (PK)           │──┐
│ turma_id (FK)     │  │
│ numero            │  │
│ nome              │  │
│ data_nascimento   │  │
│ foto              │  │
│ ativo             │  │
└───────────────────┘  │
                       │
                       ↓
┌───────────────────────┐
│     avaliacoes        │
│───────────────────────│
│ id (PK)               │──┐
│ aluno_id (FK)         │  │
│ professor_id (FK)     │  │
│ disciplina_id (FK)    │  │
│ trimestre             │  │
│ nota_final            │  │
│ observacoes           │  │
└───────────────────────┘  │
                           │
                           ↓
┌───────────────────────────┐        ┌──────────────┐
│   avaliacao_criterio      │        │  criterios   │
│───────────────────────────│        │──────────────│
│ id (PK)                   │        │ id (PK)      │
│ avaliacao_id (FK)         │        │ nome         │
│ criterio_id (FK)          │───────→│ grupo        │
│ valor (0-4)               │        │ peso         │
└───────────────────────────┘        │ ordem        │
                                     │ ativo        │
                                     └──────────────┘

┌──────────────────┐
│  activity_logs   │
│──────────────────│
│ id (PK)          │
│ user_id (FK)     │
│ action           │
│ description      │
│ ip_address       │
│ user_agent       │
│ created_at       │
└──────────────────┘
```

### 📋 Tabelas Detalhadas

<details>
<summary><strong>users</strong> - Usuários do sistema</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| name | string(255) | Nome completo |
| email | string(255) | E-mail (único) |
| password | string | Senha hash (bcrypt) |
| role | enum | 'desenvolvedor', 'coordenacao', 'professor' |
| ativo | boolean | Status ativo/inativo |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

</details>

<details>
<summary><strong>turmas</strong> - Turmas escolares</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| nome | string(100) | Nome da turma (ex: "6º A") |
| ano_letivo | year | Ano letivo |
| turno | enum | 'manhã', 'tarde', 'noite', 'integral' |
| ativa | boolean | Status ativo/inativo |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

</details>

<details>
<summary><strong>alunos</strong> - Alunos matriculados</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| turma_id | UUID (FK) | Referência à turma |
| numero | integer | Número do aluno na turma (auto) |
| nome | string(255) | Nome completo |
| data_nascimento | date | Data de nascimento |
| foto | string | Caminho da foto |
| ativo | boolean | Status ativo/inativo |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

**Índices**: `turma_id`, `nome`, `ativo`

</details>

<details>
<summary><strong>disciplinas</strong> - Disciplinas escolares</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| nome | string(100) | Nome da disciplina |
| carga_horaria | integer | Carga horária semanal |
| ativa | boolean | Status ativo/inativo |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

</details>

<details>
<summary><strong>criterios</strong> - Critérios de avaliação</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| nome | string(255) | Nome do critério |
| grupo | string(100) | Grupo temático |
| peso | decimal(3,2) | Peso do critério (0.6-1.0) |
| ordem | integer | Ordem de exibição |
| ativo | boolean | Status ativo/inativo |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

**Seed**: 12 critérios pré-cadastrados

</details>

<details>
<summary><strong>avaliacoes</strong> - Avaliações realizadas</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| aluno_id | UUID (FK) | Referência ao aluno |
| professor_id | UUID (FK) | Referência ao professor |
| disciplina_id | UUID (FK) | Referência à disciplina |
| trimestre | integer | Trimestre (1, 2 ou 3) |
| nota_final | decimal(4,2) | Nota calculada (0-10) |
| observacoes | text | Observações do professor |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

**Índices**: `aluno_id`, `professor_id`, `disciplina_id`, `trimestre`  
**Unique**: `aluno_id + disciplina_id + trimestre` (uma avaliação por trimestre)

</details>

<details>
<summary><strong>avaliacao_criterio</strong> - Tabela pivot (Avaliação ↔ Critério)</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| avaliacao_id | UUID (FK) | Referência à avaliação |
| criterio_id | UUID (FK) | Referência ao critério |
| valor | integer | Valor do critério (0-4) |
| created_at | timestamp | Data de criação |
| updated_at | timestamp | Data de atualização |

**Índices**: `avaliacao_id`, `criterio_id`

</details>

<details>
<summary><strong>professor_disciplina</strong> - Tabela pivot (Professor ↔ Disciplina)</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| user_id | UUID (FK) | Referência ao professor |
| disciplina_id | UUID (FK) | Referência à disciplina |
| created_at | timestamp | Data de criação |

</details>

<details>
<summary><strong>professor_turma</strong> - Tabela pivot (Professor ↔ Turma ↔ Disciplina)</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| user_id | UUID (FK) | Referência ao professor |
| turma_id | UUID (FK) | Referência à turma |
| disciplina_id | UUID (FK) | Referência à disciplina |
| ano_letivo | year | Ano letivo da atribuição |
| created_at | timestamp | Data de criação |

**Unique**: `user_id + turma_id + disciplina_id + ano_letivo`

</details>

<details>
<summary><strong>activity_logs</strong> - Logs de auditoria</summary>

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | UUID (PK) | Identificador único |
| user_id | UUID (FK) | Usuário que executou |
| action | string(50) | Tipo de ação |
| description | text | Descrição detalhada |
| ip_address | string(45) | IP do usuário |
| user_agent | string | User agent do navegador |
| created_at | timestamp | Data/hora da ação |

**Índices**: `user_id`, `action`, `created_at`

</details>

---

### Fase 1: Setup e Fundação ✅ COMPLETO
- ✅ Projeto Laravel 11 criado
- ✅ Pacotes instalados (Breeze, Spatie, Excel, Intervention, DomPDF)
- ✅ 10 Migrations criadas
- ✅ 3 Seeders implementados
- ✅ 7 Models com relacionamentos
- ✅ 3 Middlewares customizados

### Fase 2: Módulo Administrativo ✅ COMPLETO
- ✅ CRUD de Turmas (com ordenação alfabética)
- ✅ CRUD de Alunos (com upload de foto e numeração automática)
- ✅ CRUD de Professores
- ✅ Dashboard administrativo
- ✅ Exportação de PDF de relação de alunos
- ✅ Sistema de vinculação professor-disciplina-turma

### Fase 3: Módulo Professor ✅ COMPLETO
- ✅ Dashboard do professor
- ✅ Sistema de avaliação qualitativa
- ✅ Navegação entre alunos
- ✅ Cálculo automático de notas

### Fase 4: Otimizações e Refinamentos 🚧 EM ANDAMENTO
- ✅ PDF otimizado para impressão em 1 página
- ✅ Layout profissional com logo Codevilla
- 🚧 Melhorias de performance e UX

---

## 🧪 Comandos Úteis

### 🔧 Desenvolvimento

```bash
# Executar servidor de desenvolvimento
php artisan serve

# Compilar assets em modo watch
npm run dev

# Compilar assets para produção
npm run build

# Executar testes unitários
php artisan test

# Executar teste específico
php artisan test --filter=NomeDoTeste

# Executar testes com coverage
php artisan test --coverage
```

### 🗄️ Banco de Dados

```bash
# Executar migrations
php artisan migrate

# Rollback última migration
php artisan migrate:rollback

# Resetar banco e executar seeds
php artisan migrate:fresh --seed

# Executar seeder específico
php artisan db:seed --class=NomeDoSeeder

# Criar nova migration
php artisan make:migration nome_da_migration

# Criar novo seeder
php artisan make:seeder NomeDoSeeder
```

### 🧹 Cache e Otimização

```bash
# Limpar todos os caches
php artisan optimize:clear

# Limpar cache de configuração
php artisan config:clear

# Limpar cache de rotas
php artisan route:clear

# Limpar cache de views
php artisan view:clear

# Cachear configurações (produção)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Formatar código (Laravel Pint)
./vendor/bin/pint

# Formatar arquivos específicos
./vendor/bin/pint app/Models
```

### 📝 Artisan Úteis

```bash
# Ver lista de rotas
php artisan route:list

# Ver lista de rotas filtrada
php artisan route:list --name=admin

# Criar controller
php artisan make:controller NomeController

# Criar model com migration
php artisan make:model NomeModel -m

# Criar model completo (migration, factory, seeder, controller)
php artisan make:model NomeModel -mfsc

# Criar middleware
php artisan make:middleware NomeMiddleware

# Gerar link simbólico storage
php artisan storage:link

# Limpar compilados
php artisan clear-compiled
```

### 🐳 Docker

```bash
# Subir containers
docker-compose up -d

# Parar containers
docker-compose down

# Ver logs
docker-compose logs -f

# Acessar container da aplicação
docker exec -it codevilla-app bash

# Acessar MySQL
docker exec -it codevilla-db mysql -u root -p

# Rebuild containers
docker-compose build --no-cache
docker-compose up -d
```

### 🔍 Debug e Logs

```bash
# Ver logs em tempo real
tail -f storage/logs/laravel.log

# Limpar logs
> storage/logs/laravel.log

# Ver queries SQL no Tinker
php artisan tinker
>>> DB::enableQueryLog();
>>> // Execute operações
>>> DB::getQueryLog();
```

---

## 🗓️ Status do Projeto

### ✅ Fase 1: Setup e Fundação (COMPLETO)

- ✅ Projeto Laravel 11 criado
- ✅ Pacotes instalados (Breeze, Spatie, Excel, Intervention, DomPDF)
- ✅ 10 Migrations criadas (users, turmas, alunos, disciplinas, criterios, avaliacoes, pivots, logs)
- ✅ 8 Seeders implementados (DatabaseSeeder, User, Disciplina, Turma, Aluno, Criterio, Professor, Atribuicao)
- ✅ 8 Models com relacionamentos (User, Turma, Aluno, Disciplina, Criterio, Avaliacao, AvaliacaoCriterio, ActivityLog)
- ✅ 4 Middlewares customizados (CheckRole, CheckProfessor, CheckCoordenacao, DesenvolvedorMiddleware)
- ✅ Sistema de autenticação com Laravel Breeze
- ✅ Configuração Docker completa (PHP 8.2, MySQL 8.0, Redis, Mailhog)

**Highlights:**
- UUIDs em todas as tabelas principais
- Soft deletes implementado
- Relacionamentos many-to-many configurados
- Seeders com dados realistas (Faker)

### ✅ Fase 2: Módulo Administrativo (COMPLETO)

**CRUD Turmas:**
- ✅ Listagem com paginação e ordenação
- ✅ Formulário de criação e edição
- ✅ Detalhes com listagem de alunos
- ✅ Adicionar/remover alunos da turma
- ✅ Exportação PDF otimizada (1 página, logo Codevilla)
- ✅ Exportação Excel com formatação

**CRUD Alunos:**
- ✅ Listagem global com busca e filtros
- ✅ Formulário simplificado de criação
- ✅ Upload de fotos com validação e resize
- ✅ **Ordenação alfabética automática**
- ✅ **Numeração automática por turma**
- ✅ Edição com manutenção de foto anterior
- ✅ Vinculação automática à turma

**CRUD Professores:**
- ✅ Listagem de professores ativos/inativos
- ✅ Formulário de cadastro com validação de e-mail
- ✅ Edição de dados e ativação/desativação
- ✅ Visualização de atribuições do professor

**CRUD Disciplinas:**
- ✅ Listagem de disciplinas ativas/inativas
- ✅ Formulário de criação com carga horária
- ✅ Edição e exclusão com validação

**Sistema de Atribuições:**
- ✅ Vinculação Professor → Turma → Disciplina
- ✅ Controle de ano letivo
- ✅ Listagem paginada de atribuições
- ✅ Filtro por professor
- ✅ Remoção de atribuições

**Dashboard Administrativo:**
- ✅ Cards com estatísticas (alunos, turmas, professores, avaliações)
- ✅ Gráficos e métricas visuais
- ✅ Acesso rápido a funcionalidades principais

### ✅ Fase 3: Módulo Professor (COMPLETO)

**Dashboard do Professor:**
- ✅ Visão geral de turmas e disciplinas atribuídas
- ✅ Cards com estatísticas pessoais
- ✅ Lista de avaliações recentes
- ✅ Atalhos para avaliação

**Sistema de Avaliação:**
- ✅ Seleção de Turma → Disciplina → Trimestre
- ✅ Listagem de alunos da turma
- ✅ Formulário de avaliação com 12 critérios (0-4)
- ✅ **Cálculo automático da nota final** (fórmula ponderada)
- ✅ Campo de observações
- ✅ **Navegação sequencial** (botões Anterior/Próximo)
- ✅ Validação de dados completa
- ✅ Edição de avaliações existentes
- ✅ Visualização de histórico de avaliações

**Regras de Negócio:**
- ✅ Professor só avalia alunos de suas turmas atribuídas
- ✅ Uma avaliação por aluno/disciplina/trimestre
- ✅ Nota final entre 0 e 10 (duas casas decimais)
- ✅ Todos os 12 critérios obrigatórios

### ✅ Fase 4: Otimizações e Refinamentos (EM ANDAMENTO)

**PDF Profissional:**
- ✅ Layout otimizado para impressão em **1 página**
- ✅ Logo Codevilla integrada (base64)
- ✅ Tabela de assinaturas para presença
- ✅ Cores e fontes do sistema (#1A2E6B, #2E63BF)
- ✅ Informações de turma compactadas
- ✅ Rodapé com assinaturas (Professor/Coordenador)

**UX/UI:**
- ✅ Interface moderna com Tailwind CSS
- ✅ Heroicons para ícones consistentes
- ✅ Feedback visual (toasts de sucesso/erro)
- ✅ Loading states em ações assíncronas
- ✅ Responsividade mobile-first

**Performance:**
- ✅ Eager loading de relacionamentos
- ✅ Paginação em todas as listagens
- ✅ Índices no banco de dados
- 🚧 Cache de queries frequentes (planejado)

### 📅 Fase 5: Features Avançadas (PLANEJADO)

**Relatórios:**
- 📅 Relatório consolidado por turma (PDF/Excel)
- 📅 Relatório individual do aluno (boletim)
- 📅 Gráficos de evolução trimestral
- 📅 Comparativo de desempenho entre turmas

**Notificações:**
- 📅 E-mail de avaliação criada/atualizada
- 📅 Alertas de avaliações pendentes
- 📅 Notificações para coordenação

**Auditoria:**
- 📅 Log completo de ações (Activity Logs)
- 📅 Histórico de alterações em avaliações
- 📅 Rastreamento de usuário/IP/data

**API (Opcional):**
- 📅 API RESTful para integração externa
- 📅 Autenticação via Sanctum
- 📅 Endpoints para consulta de avaliações

---

## 📚 Documentação

### 📖 Guias Disponíveis

- **[SETUP.md](SETUP.md)** - Guia completo de instalação e configuração
- **[CHECKLIST.md](CHECKLIST.md)** - Checklist de inicialização do projeto
- **README.md** (este arquivo) - Visão geral e documentação técnica

### 🔗 Links Úteis

- [Documentação Laravel 11](https://laravel.com/docs/11.x)
- [Documentação Vue 3](https://vuejs.org/guide/introduction.html)
- [Documentação Inertia.js](https://inertiajs.com)
- [Documentação Tailwind CSS](https://tailwindcss.com/docs)
- [Laravel Breeze](https://laravel.com/docs/11.x/starter-kits#laravel-breeze)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)

### 📝 Convenções do Projeto

**Nomenclatura:**
- Controllers: `PascalCase` + sufixo `Controller` (ex: `AlunoController`)
- Models: `PascalCase` singular (ex: `Aluno`)
- Tabelas: `snake_case` plural (ex: `alunos`)
- Rotas: `kebab-case` (ex: `turmas.adicionar-aluno`)
- Variáveis PHP: `snake_case`
- Componentes Vue: `PascalCase.vue`

**Estrutura de Commits:**
- `feat:` Nova funcionalidade
- `fix:` Correção de bug
- `refactor:` Refatoração de código
- `docs:` Atualização de documentação
- `style:` Formatação de código
- `test:` Adição/correção de testes

---

## 🤝 Contribuindo

Contribuições são bem-vindas! Siga os passos abaixo:

### 1️⃣ Fork o Projeto

```bash
git clone https://github.com/seu-usuario/codevilla-qualitativas.git
cd codevilla-qualitativas
```

### 2️⃣ Crie uma Branch

```bash
git checkout -b feature/MinhaNovaFuncionalidade
```

### 3️⃣ Faça suas Alterações

- Siga as convenções do projeto
- Adicione testes quando aplicável
- Formate o código com Laravel Pint: `./vendor/bin/pint`

### 4️⃣ Commit suas Mudanças

```bash
git add .
git commit -m "feat: Adiciona funcionalidade X"
```

### 5️⃣ Push para o GitHub

```bash
git push origin feature/MinhaNovaFuncionalidade
```

### 6️⃣ Abra um Pull Request

- Descreva suas alterações claramente
- Referencie issues relacionadas
- Aguarde revisão do código

### 📋 Checklist de PR

- [ ] Código formatado com Pint
- [ ] Testes passando (`php artisan test`)
- [ ] Migrations executam sem erros
- [ ] Documentação atualizada (se necessário)
- [ ] Sem conflitos com `main`

---

## 📄 Licença

Este projeto está sob a licença **MIT**. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

### Resumo da Licença MIT

- ✅ Uso comercial permitido
- ✅ Modificação permitida
- ✅ Distribuição permitida
- ✅ Uso privado permitido
- ⚠️ Sem garantia
- ⚠️ Autores não são responsáveis

---

## 👥 Autores e Agradecimentos

### 👨‍💻 Desenvolvedor Principal

**Angelo Oliveira**  
📧 Email: [angelo@exemplo.com](mailto:angelo@exemplo.com)  
💼 GitHub: [@DevAngeloOliveira](https://github.com/DevAngeloOliveira)  
🔗 LinkedIn: [Angelo Oliveira](https://linkedin.com/in/angelo-oliveira)

### 🙏 Agradecimentos

- **Colégio Codevilla** - Por confiar no projeto
- **Comunidade Laravel** - Pela excelente documentação
- **Vue.js Core Team** - Pelo framework incrível
- **Tailwind Labs** - Pelo Tailwind CSS

---

## 📞 Suporte

### 🐛 Reportar Bugs

Encontrou um bug? [Abra uma issue](https://github.com/seu-usuario/codevilla-qualitativas/issues/new?template=bug_report.md)

### 💡 Sugerir Features

Tem uma ideia? [Abra uma issue](https://github.com/seu-usuario/codevilla-qualitativas/issues/new?template=feature_request.md)

### 📧 Contato

- Email: [suporte@codevilla.edu.br](mailto:suporte@codevilla.edu.br)
- Documentação: [Wiki do Projeto](https://github.com/seu-usuario/codevilla-qualitativas/wiki)

---

<div align="center">

### 🌟 Se este projeto foi útil, deixe uma ⭐ no GitHub!

---

**Última atualização:** 09/01/2026  
**Versão:** 0.3.0-beta (Fases 1-3 Completas + Otimizações)  
**Laravel:** 11.x | **Vue:** 3.4+ | **PHP:** 8.2+

---

**© 2026 Colégio Codevilla - Sistema de Avaliação Qualitativa**  
Desenvolvido com ❤️ por Angelo Oliveira

</div>

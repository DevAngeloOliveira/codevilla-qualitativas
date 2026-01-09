# ✅ Checklist de Inicialização do Projeto

## 📦 O Que Foi Criado Automaticamente

### ✅ Estrutura Base
- [x] Projeto Laravel 11.x instalado
- [x] Node.js e NPM configurados
- [x] Arquivo `.env` configurado (pt_BR, timezone)
- [x] Laravel Breeze instalado (autenticação Blade)
- [x] Tailwind CSS 3.x configurado

### ✅ Pacotes Instalados
- [x] `laravel/breeze` ^2.3 - Autenticação
- [x] `spatie/laravel-permission` ^6.24 - Gerenciamento de roles
- [x] `maatwebsite/excel` ^3.1 - Exportação de relatórios
- [x] `intervention/image` ^3.11 - Manipulação de fotos

### ✅ Banco de Dados
- [x] **10 Migrations criadas:**
  1. `add_role_to_users_table`
  2. `create_disciplinas_table`
  3. `create_turmas_table`
  4. `create_alunos_table`
  5. `create_criterios_table`
  6. `create_avaliacoes_table`
  7. `create_avaliacao_criterio_table`
  8. `create_professor_disciplina_table`
  9. `create_professor_turma_table`
  10. `create_activity_logs_table`

- [x] **3 Seeders implementados:**
  1. `CriterioSeeder` - 12 critérios de avaliação
  2. `DisciplinaSeeder` - 10 disciplinas do Fundamental II
  3. `UserSeeder` - Coordenação + Professor de teste

### ✅ Models e Relacionamentos
- [x] `User` - com roles, disciplinas, turmas, avaliações
- [x] `Aluno` - com turma, avaliações, foto
- [x] `Turma` - com alunos, professores, disciplinas
- [x] `Disciplina` - com professores, turmas
- [x] `Criterio` - com avaliações (pivot)
- [x] `Avaliacao` - com aluno, professor, disciplina, turma
- [x] `AvaliacaoCriterio` - tabela pivot
- [x] `ActivityLog` - auditoria

### ✅ Middlewares
- [x] `CheckRole` - Verificação genérica por role
- [x] `CheckProfessor` - Acesso exclusivo para professores
- [x] `CheckCoordenacao` - Acesso exclusivo para coordenação
- [x] Middlewares registrados no `bootstrap/app.php`

### ✅ Documentação
- [x] `README.md` - Visão geral do projeto
- [x] `SETUP.md` - Guia completo de instalação
- [x] `.gitignore` atualizado

---

## ⚠️ AÇÕES NECESSÁRIAS ANTES DE USAR

### 1️⃣ Configurar Banco de Dados

**Opção A: MySQL (Recomendado)**

1. Inicie o MySQL (XAMPP ou serviço standalone)
2. Crie o banco de dados:
   ```sql
   CREATE DATABASE codevilla_qualitativas 
   CHARACTER SET utf8mb4 
   COLLATE utf8mb4_unicode_ci;
   ```
3. Configure o `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=codevilla_qualitativas
   DB_USERNAME=root
   DB_PASSWORD=sua_senha
   ```

**Opção B: SQLite (Desenvolvimento)**

1. Habilite extensões no `php.ini`:
   ```ini
   extension=pdo_sqlite
   extension=sqlite3
   ```
2. Reinicie o Apache/PHP
3. Configure o `.env`:
   ```env
   DB_CONNECTION=sqlite
   # Comente as outras linhas DB_*
   ```
4. Crie o arquivo:
   ```bash
   New-Item -ItemType File -Path "database\database.sqlite"
   ```

### 2️⃣ Executar Migrations

```bash
php artisan migrate:fresh --seed
```

**Isso vai criar:**
- Todas as tabelas do banco
- 12 critérios de avaliação
- 10 disciplinas
- 2 usuários de teste (coord + professor)

### 3️⃣ Iniciar Servidor de Desenvolvimento

```bash
# Terminal 1 - Servidor Laravel
php artisan serve

# Terminal 2 - Compilação de assets (Vite)
npm run dev
```

### 4️⃣ Acessar o Sistema

Abra o navegador em: **http://localhost:8000**

**Login Coordenação:**
- Email: `coord@codevilla.edu.br`
- Senha: `password123`

**Login Professor:**
- Email: `professor@codevilla.edu.br`
- Senha: `password123`

---

## 🚀 Próximos Passos de Desenvolvimento

### Sprint 2: Módulo Administrativo (Recomendado)

#### 1. Criar Controllers
```bash
php artisan make:controller Admin/DashboardController
php artisan make:controller Admin/TurmaController --resource
php artisan make:controller Admin/AlunoController --resource
php artisan make:controller Admin/ProfessorController --resource
```

#### 2. Criar Form Requests
```bash
php artisan make:request StoreAlunoRequest
php artisan make:request UpdateAlunoRequest
php artisan make:request StoreTurmaRequest
```

#### 3. Criar Views Blade
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/turmas/index.blade.php`
- `resources/views/admin/turmas/create.blade.php`
- `resources/views/admin/turmas/edit.blade.php`
- `resources/views/admin/alunos/index.blade.php`
- `resources/views/admin/alunos/create.blade.php`
- `resources/views/admin/alunos/edit.blade.php`

#### 4. Configurar Upload de Fotos
```bash
php artisan storage:link
```

Criar Service:
```bash
php artisan make:class Services/ImageUploadService
```

#### 5. Criar Rotas
Em `routes/web.php`:
```php
Route::middleware(['auth', 'coordenacao'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('turmas', TurmaController::class);
    Route::resource('alunos', AlunoController::class);
    Route::resource('professores', ProfessorController::class);
});
```

---

## 📋 Checklist de Validação

Antes de continuar, verifique:

- [ ] Banco de dados criado e conectado
- [ ] Migrations executadas com sucesso
- [ ] Seeders rodaram (12 critérios + 10 disciplinas + 2 users)
- [ ] Servidor Laravel rodando (`php artisan serve`)
- [ ] Assets compilados (`npm run dev`)
- [ ] Login funcionando com credenciais de teste
- [ ] Sem erros no console/terminal

---

## 🐛 Problemas Comuns

### "could not find driver"
**Solução:** Habilite extensões no `php.ini`:
```ini
extension=pdo_mysql
extension=pdo_sqlite
```

### "Connection refused"
**Solução:** Verifique se o MySQL está rodando:
```bash
net start mysql
```

### "Class 'ZipArchive' not found"
**Solução:** Habilite no `php.ini`:
```ini
extension=zip
```

### "Port 8000 already in use"
**Solução:** Use outra porta:
```bash
php artisan serve --port=8080
```

---

## 📞 Onde Obter Ajuda

1. **Documentação do Laravel:** https://laravel.com/docs/11.x
2. **SETUP.md:** Guia detalhado de instalação
3. **Logs:** `storage/logs/laravel.log`

---

**Status:** Fase 1 Completa ✅  
**Próximo Passo:** Configurar banco de dados e rodar migrations  
**Data:** 07/01/2026

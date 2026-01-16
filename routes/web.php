<?php

use App\Http\Controllers\Admin\AlunoController;
use App\Http\Controllers\Admin\AtribuicaoController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DisciplinaController;
use App\Http\Controllers\Admin\ProfessorController;
use App\Http\Controllers\Admin\TurmaController;
use App\Http\Controllers\Professor\AvaliacaoController;
use App\Http\Controllers\Professor\DashboardController as ProfessorDashboardController;
use App\Http\Controllers\ProfileController;
use App\Domains\Usuarios\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Redirecionamento do dashboard baseado em role
Route::get('/dashboard', function () {
    /** @var User $user */
    $user = Auth::user();

    if ($user->isDesenvolvedor()) {
        return redirect()->route('desenvolvedor.dashboard');
    }

    if ($user->isCoordenacao()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('professor.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de Perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas Admin/Coordenação
Route::middleware(['auth', 'coordenacao'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestão de Turmas
    Route::resource('turmas', TurmaController::class);
    Route::get('/turmas/{turma}/detalhes', [TurmaController::class, 'detalhes'])->name('turmas.detalhes');
    Route::post('/turmas/{turma}/alunos', [TurmaController::class, 'adicionarAluno'])->name('turmas.adicionar-aluno');
    Route::delete('/turmas/{turma}/alunos/{aluno}', [TurmaController::class, 'removerAluno'])->name('turmas.remover-aluno');
    Route::get('/turmas/export/pdf', [TurmaController::class, 'exportPdf'])->name('turmas.export.pdf');
    Route::get('/turmas/export/excel', [TurmaController::class, 'exportExcel'])->name('turmas.export.excel');

    // Gestão de Alunos
    Route::get('/turmas/{turma}/alunos/create', [AlunoController::class, 'create'])->name('turmas.alunos.create');
    Route::post('/turmas/{turma}/alunos', [AlunoController::class, 'store'])->name('turmas.alunos.store');
    Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');
    Route::get('/alunos/{aluno}', [AlunoController::class, 'show'])->name('alunos.show');
    Route::get('/alunos/{aluno}/edit', [AlunoController::class, 'edit'])->name('alunos.edit');
    Route::put('/alunos/{aluno}', [AlunoController::class, 'update'])->name('alunos.update');
    Route::delete('/alunos/{aluno}', [AlunoController::class, 'destroy'])->name('alunos.destroy');
    Route::get('/alunos/{aluno}/detalhes', [AlunoController::class, 'detalhes'])->name('alunos.detalhes');

    // Gestão de Professores
    Route::resource('professores', ProfessorController::class);

    // Gestão de Disciplinas
    Route::resource('disciplinas', DisciplinaController::class);

    // Gestão de Atribuições (Professor -> Turma -> Disciplina)
    Route::resource('atribuicoes', AtribuicaoController::class)->except(['show', 'edit', 'update']);
    Route::get('/atribuicoes/professor/{professor}', [AtribuicaoController::class, 'porProfessor'])
        ->name('atribuicoes.professor');
});

// Rotas Professor
Route::middleware(['auth', 'professor'])->prefix('professor')->name('professor.')->group(function () {
    Route::get('/dashboard', [ProfessorDashboardController::class, 'index'])->name('dashboard');

    // Avaliações
    Route::resource('avaliacoes', AvaliacaoController::class);

    // Rotas específicas de avaliação
    Route::get(
        '/turma/{turma}/disciplina/{disciplina}/trimestre/{trimestre}',
        [AvaliacaoController::class, 'listarAlunos']
    )->name('avaliacoes.alunos');

    Route::get(
        '/avaliar/{aluno}/{disciplina}/{trimestre}',
        [AvaliacaoController::class, 'avaliar']
    )->name('avaliacoes.avaliar');
});

// Rotas Desenvolvedor
Route::middleware(['auth', 'desenvolvedor'])->prefix('desenvolvedor')->name('desenvolvedor.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Desenvolvedor\DashboardController::class, 'index'])->name('dashboard');

    // Gestão de Usuários (Desenvolvedores, Coordenadores e Professores)
    Route::resource('users', \App\Http\Controllers\Desenvolvedor\UserController::class);
});

require __DIR__ . '/auth.php';

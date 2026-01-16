<?php

namespace App\Domains\Avaliacoes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Alunos\Models\Aluno;
use App\Domains\Alunos\Models\Turma;
use App\Domains\Disciplinas\Models\Disciplina;
use App\Domains\Usuarios\Models\User;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'aluno_id',
        'professor_id',
        'disciplina_id',
        'turma_id',
        'trimestre',
        'ano_letivo',
        'nota_final',
        'observacoes',
        'finalizada',
    ];

    protected $casts = [
        'trimestre' => 'integer',
        'ano_letivo' => 'integer',
        'nota_final' => 'decimal:2',
        'finalizada' => 'boolean',
    ];

    // Relacionamentos
    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class);
    }

    public function professor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function disciplina(): BelongsTo
    {
        return $this->belongsTo(Disciplina::class);
    }

    public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class);
    }

    public function criterios(): BelongsToMany
    {
        return $this->belongsToMany(Criterio::class, 'avaliacao_criterio')
            ->withPivot('valor')
            ->withTimestamps();
    }

    // Scopes
    public function scopePorProfessor($query, $professorId)
    {
        return $query->where('professor_id', $professorId);
    }

    public function scopePorTurma($query, $turmaId)
    {
        return $query->where('turma_id', $turmaId);
    }

    public function scopePorDisciplina($query, $disciplinaId)
    {
        return $query->where('disciplina_id', $disciplinaId);
    }

    public function scopePorTrimestre($query, $trimestre)
    {
        return $query->where('trimestre', $trimestre);
    }

    public function scopeFinalizada($query)
    {
        return $query->where('finalizada', true);
    }
}

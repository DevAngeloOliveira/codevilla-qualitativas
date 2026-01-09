<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disciplina extends Model
{
    protected $fillable = [
        'nome',
        'codigo',
        'segmento',
        'ativa',
    ];

    protected $casts = [
        'ativa' => 'boolean',
    ];

    // Relacionamentos
    public function professores(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'professor_disciplina', 'disciplina_id', 'user_id');
    }

    public function turmas(): BelongsToMany
    {
        return $this->belongsToMany(Turma::class, 'professor_turma')
            ->withPivot(['user_id', 'ano_letivo']);
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ativa', true);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('nome');
    }
}

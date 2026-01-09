<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Turma extends Model
{
    protected $fillable = [
        'uuid',
        'nome',
        'ano_letivo',
        'turno',
        'segmento',
        'ativa',
    ];

    protected $casts = [
        'ativa' => 'boolean',
        'ano_letivo' => 'integer',
    ];

    public const TURNOS = [
        'Matutino' => 'Matutino',
        'Vespertino' => 'Vespertino',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($turma) {
            if (empty($turma->uuid)) {
                $turma->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    // Relacionamentos
    public function alunos(): HasMany
    {
        return $this->hasMany(Aluno::class);
    }

    public function professores(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'professor_turma', 'turma_id', 'user_id')
            ->withPivot(['disciplina_id', 'ano_letivo']);
    }

    public function disciplinas(): BelongsToMany
    {
        return $this->belongsToMany(Disciplina::class, 'professor_turma')
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

    public function scopeAnoAtual($query)
    {
        return $query->where('ano_letivo', date('Y'));
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('nome');
    }
}

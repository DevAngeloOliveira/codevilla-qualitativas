<?php

namespace App\Domains\Alunos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Domains\Avaliacoes\Models\Avaliacao;

class Aluno extends Model
{
    protected $fillable = [
        'uuid',
        'nome',
        'numero_chamada',
        'turma_id',
        'foto',
        'ativo',
    ];

    protected $casts = [
        'numero_chamada' => 'integer',
        'ativo' => 'boolean',
    ];

    protected $appends = [
        'foto_url',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($aluno) {
            if (empty($aluno->uuid)) {
                $aluno->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    // Relacionamentos
    public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class);
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeByTurma($query, $turmaId)
    {
        return $query->where('turma_id', $turmaId);
    }

    public function scopeOrdenadoPorChamada($query)
    {
        return $query->orderBy('numero_chamada');
    }

    // Accessors
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('assets/images/placeholder-icon.png');
    }
}

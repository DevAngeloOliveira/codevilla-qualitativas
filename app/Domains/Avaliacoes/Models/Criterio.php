<?php

namespace App\Domains\Avaliacoes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Criterio extends Model
{
    protected $fillable = [
        'codigo',
        'grupo',
        'titulo',
        'descricao',
        'peso',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'peso' => 'decimal:2',
        'ordem' => 'integer',
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function avaliacoes(): BelongsToMany
    {
        return $this->belongsToMany(Avaliacao::class, 'avaliacao_criterio')
            ->withPivot('valor')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem');
    }

    public function scopePorGrupo($query)
    {
        return $query->orderBy('grupo')->orderBy('ordem');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    const UPDATED_AT = null; // Apenas created_at

    protected $fillable = [
        'user_id',
        'acao',
        'entidade',
        'entidade_id',
        'dados_antigos',
        'dados_novos',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'dados_antigos' => 'array',
        'dados_novos' => 'array',
        'created_at' => 'datetime',
    ];

    // Relacionamentos
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeRecentes($query, $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    public function scopePorEntidade($query, $entidade, $entidadeId = null)
    {
        $query->where('entidade', $entidade);

        if ($entidadeId) {
            $query->where('entidade_id', $entidadeId);
        }

        return $query;
    }
}

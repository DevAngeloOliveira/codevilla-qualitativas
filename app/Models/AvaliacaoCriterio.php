<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvaliacaoCriterio extends Model
{
    protected $table = 'avaliacao_criterio';

    protected $fillable = [
        'avaliacao_id',
        'criterio_id',
        'valor',
    ];

    protected $casts = [
        'valor' => 'integer',
    ];

    // Relacionamentos
    public function avaliacao(): BelongsTo
    {
        return $this->belongsTo(Avaliacao::class);
    }

    public function criterio(): BelongsTo
    {
        return $this->belongsTo(Criterio::class);
    }
}

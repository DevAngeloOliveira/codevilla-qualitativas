<?php

namespace App\Domains\Avaliacoes\Queries;

use App\Domains\Avaliacoes\Models\Avaliacao;
use Illuminate\Database\Eloquent\Builder;

class AvaliacaoQuery
{
    public function query(): Builder
    {
        return Avaliacao::query();
    }
}

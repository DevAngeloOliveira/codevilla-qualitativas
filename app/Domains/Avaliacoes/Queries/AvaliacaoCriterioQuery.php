<?php

namespace App\Domains\Avaliacoes\Queries;

use App\Domains\Avaliacoes\Models\AvaliacaoCriterio;
use Illuminate\Database\Eloquent\Builder;

class AvaliacaoCriterioQuery
{
    public function query(): Builder
    {
        return AvaliacaoCriterio::query();
    }
}

<?php

namespace App\Domains\Avaliacoes\Services;

use App\Domains\Avaliacoes\Queries\AvaliacaoCriterioQuery;
use Illuminate\Database\Eloquent\Builder;

class AvaliacaoCriterioService
{
    public function __construct(private readonly AvaliacaoCriterioQuery $avaliacaoCriterioQuery)
    {
    }

    public function query(): Builder
    {
        return $this->avaliacaoCriterioQuery->query();
    }
}

<?php

namespace App\Domains\Avaliacoes\Services;

use App\Domains\Avaliacoes\Queries\AvaliacaoQuery;
use Illuminate\Database\Eloquent\Builder;

class AvaliacaoService
{
    public function __construct(private readonly AvaliacaoQuery $avaliacaoQuery)
    {
    }

    public function query(): Builder
    {
        return $this->avaliacaoQuery->query();
    }
}

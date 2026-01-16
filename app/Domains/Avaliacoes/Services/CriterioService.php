<?php

namespace App\Domains\Avaliacoes\Services;

use App\Domains\Avaliacoes\Queries\CriterioQuery;
use Illuminate\Database\Eloquent\Builder;

class CriterioService
{
    public function __construct(private readonly CriterioQuery $criterioQuery)
    {
    }

    public function query(): Builder
    {
        return $this->criterioQuery->query();
    }
}

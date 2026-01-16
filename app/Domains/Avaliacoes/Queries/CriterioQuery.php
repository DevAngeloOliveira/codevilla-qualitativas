<?php

namespace App\Domains\Avaliacoes\Queries;

use App\Domains\Avaliacoes\Models\Criterio;
use Illuminate\Database\Eloquent\Builder;

class CriterioQuery
{
    public function query(): Builder
    {
        return Criterio::query();
    }
}

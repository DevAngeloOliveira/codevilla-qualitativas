<?php

namespace App\Domains\Disciplinas\Services;

use App\Domains\Disciplinas\Queries\DisciplinaQuery;
use Illuminate\Database\Eloquent\Builder;

class DisciplinaService
{
    public function __construct(private readonly DisciplinaQuery $disciplinaQuery)
    {
    }

    public function query(): Builder
    {
        return $this->disciplinaQuery->query();
    }
}

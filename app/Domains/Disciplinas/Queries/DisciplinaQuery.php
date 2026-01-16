<?php

namespace App\Domains\Disciplinas\Queries;

use App\Domains\Disciplinas\Models\Disciplina;
use Illuminate\Database\Eloquent\Builder;

class DisciplinaQuery
{
    public function query(): Builder
    {
        return Disciplina::query();
    }
}

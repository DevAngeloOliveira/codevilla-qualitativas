<?php

namespace App\Domains\Alunos\Queries;

use App\Domains\Alunos\Models\Turma;
use Illuminate\Database\Eloquent\Builder;

class TurmaQuery
{
    public function query(): Builder
    {
        return Turma::query();
    }
}

<?php

namespace App\Domains\Alunos\Queries;

use App\Domains\Alunos\Models\Aluno;
use Illuminate\Database\Eloquent\Builder;

class AlunoQuery
{
    public function query(): Builder
    {
        return Aluno::query();
    }
}

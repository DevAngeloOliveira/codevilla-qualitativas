<?php

namespace App\Domains\Alunos\Services;

use App\Domains\Alunos\Queries\AlunoQuery;
use Illuminate\Database\Eloquent\Builder;

class AlunoService
{
    public function __construct(private readonly AlunoQuery $alunoQuery)
    {
    }

    public function query(): Builder
    {
        return $this->alunoQuery->query();
    }

    public function count(): int
    {
        return $this->alunoQuery->query()->count();
    }

    public function countByTurma(int $turmaId): int
    {
        return $this->alunoQuery->query()
            ->where('turma_id', $turmaId)
            ->count();
    }
}

<?php

namespace App\Domains\Alunos\Services;

use App\Domains\Alunos\Models\Turma;
use App\Domains\Alunos\Queries\TurmaQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TurmaService
{
    public function __construct(private readonly TurmaQuery $turmaQuery)
    {
    }

    public function query(): Builder
    {
        return $this->turmaQuery->query();
    }

    public function find(int $id): ?Turma
    {
        return $this->turmaQuery->query()->find($id);
    }

    public function allOrdered(): Collection
    {
        return $this->turmaQuery->query()->orderBy('nome')->get();
    }
}

<?php

namespace App\Domains\Usuarios\Services;

use App\Domains\Usuarios\Models\User;
use App\Domains\Usuarios\Queries\UserQuery;
use Illuminate\Database\Eloquent\Builder;

class UserService
{
    public function __construct(private readonly UserQuery $userQuery)
    {
    }

    public function query(): Builder
    {
        return $this->userQuery->query();
    }

    public function count(): int
    {
        return $this->userQuery->query()->count();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }
}

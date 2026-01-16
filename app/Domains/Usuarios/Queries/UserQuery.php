<?php

namespace App\Domains\Usuarios\Queries;

use App\Domains\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserQuery
{
    public function query(): Builder
    {
        return User::query();
    }
}

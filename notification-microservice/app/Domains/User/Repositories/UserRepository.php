<?php

namespace App\Domains\User\Repositories;


use App\Domains\User\Interface\UserInterface;
use App\Domains\User\Models\User;

class UserRepository implements UserInterface
{
    public function create($data): User
    {
        return User::create($data);
    }
}

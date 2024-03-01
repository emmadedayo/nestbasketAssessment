<?php

namespace App\Domains\User\Interface;

use App\Domains\User\Models\User;

interface UserInterface
{
    public function create($data): User;
}

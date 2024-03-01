<?php

namespace App\Domains\User\Http\Controllers;

use App\Domains\User\Http\Requests\CreateUserRequest;
use App\Domains\User\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    protected $usersService;

    public function __construct(UserService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function createUser(CreateUserRequest $request)
    {
        $data = $request->validated();
        //append auto generated email with random string
        $data['email'] = $data['email'] . '@' . uniqid() . '.com';
        $this->usersService->createUser($data);

        return response()->json(['message' => 'User created successfully']);
    }
}

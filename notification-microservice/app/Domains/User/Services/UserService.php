<?php

namespace App\Domains\User\Services;


use App\Domains\User\Interface\UserInterface;
use App\Domains\User\Jobs\NotificationLogJob;
use App\Domains\User\Jobs\UserJob;
use Illuminate\Broadcasting\PrivateChannel;

class UserService
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser($data): void
    {
        $user = $this->userRepository->create($data);
        UserJob::dispatch($user)->onQueue('user-server');
    }
}

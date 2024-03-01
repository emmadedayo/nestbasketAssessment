<?php

namespace Tests\Feature;

use App\Domains\User\Interface\UserInterface;
use App\Domains\User\Models\User;
use App\Domains\User\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_user_and_dispatch_jobs()
    {
        Bus::fake();

        // Mock the UserRepository
        $userRepository = $this->mock(UserInterface::class);
        $userRepository->shouldReceive('create')->andReturn(new User());

        $userService = new UserService($userRepository);

        $userData = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->email,
        ];
        $userService->createUser($userData);
        // Assertions
        Bus::assertDispatched(UserJob::class);
        Bus::assertDispatched(NotificationLogJob::class);
    }
}

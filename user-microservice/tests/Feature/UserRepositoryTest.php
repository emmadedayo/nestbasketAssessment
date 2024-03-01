<?php

namespace Tests\Feature;

use App\Domains\User\Models\User;
use App\Domains\User\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_user()
    {
        $userRepository = new UserRepository();

        $userData = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->email,
        ];

        $user = $userRepository->create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
        $this->assertEquals($userData['firstName'], $user->firstName);
        $this->assertEquals($userData['lastName'], $user->lastName);
        $this->assertEquals($userData['email'], $user->email);
    }
}

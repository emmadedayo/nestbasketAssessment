<?php

namespace Tests\Feature;

use App\Domains\User\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations
        $this->artisan('migrate');
    }

    /** @test */
    public function it_can_create_user()
    {
        $userData = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->email,
        ];
        $response = $this->post('/user/add', $userData);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'User created successfully']);
    }
}

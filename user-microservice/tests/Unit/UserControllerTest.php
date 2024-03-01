<?php
namespace Tests\Unit;

use App\Domains\User\Http\Controllers\UserController;
use App\Domains\User\Http\Requests\CreateUserRequest;
use App\Domains\User\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected $userServiceMock;
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->userServiceMock = $this->mock(UserService::class);
    }

    /** @test */
    public function it_creates_user_successfully()
    {
        $userData = [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->email,
        ];
        //use Request File
        $request = new CreateUserRequest([], $userData);
        $request->merge($userData);
        //print $request->all();
        $this->userServiceMock->shouldReceive('createUser')->with($userData)->once();
        $userController = new UserController($this->userServiceMock);
        $response = $userController->createUser($request);
        $this->assertEquals(200, $response->status());
    }
}

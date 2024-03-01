<?php
namespace Tests\Feature;

use App\Domains\User\Jobs\UserJob;
use App\Domains\User\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UserJobTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_logs_user_information()
    {
        $user =(new UserFactory())->definition();
        $job = new UserJob($user);
        //log should be called once with the user information
        Log::shouldReceive('info')->once()->with('Notification Services: ' . json_encode($user));
        $job->handle();
    }
}

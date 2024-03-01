<?php

namespace Tests\Feature;

use App\Domains\User\Jobs\UserJob;
use Database\Factories\UserFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;


class MessageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test to check for message notificattion pushed to queue
     * @return void
     */
    public function test_that_notification_job_is_dispatched()
    {
        Queue::fake();

        $data = (new UserFactory())->definition();

        $this->post('/user/add', $data);

        Queue::assertPushed(UserJob::class);
        Queue::assertCount(1);
    }

}

<?php

namespace Tests\Feature;

use App\Events\UserSaved;
use App\Listeners\SaveUserBackgroundInformation;
use App\Models\User;
use App\services\UserServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class UserSavedEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_saved_event_triggers_listener()
    {
        $userService = Mockery::mock(UserServiceInterface::class);

        $user = User::factory()->create([
            'prefixname' => 'Mr.',
            'firstname' => 'Juan',
            'middlename' => 'Palito',
            'lastname' => 'dela Cruz',
            'username' => 'username',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        Event::fake();
        event(new UserSaved($user));

        Event::assertDispatched(UserSaved::class);

        $userService->shouldReceive('saveUserDetails')->once()->with($user);

        $listener = new SaveUserBackgroundInformation($userService);

        $listener->handle(new UserSaved($user));

        $this->assertDatabaseHas('details', [
            'user_id' => $user->id,
            'key' => 'Full name',
            'value' => 'Juan P. dela Cruz',
            'type' => 'bio',
        ]);

        $this->assertDatabaseHas('details', [
            'user_id' => $user->id,
            'key' => 'Middle Initial',
            'value' => 'P.',
            'type' => 'bio',
        ]);
    }
}

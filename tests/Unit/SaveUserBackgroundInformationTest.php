<?php

namespace Tests\Unit;

use App\Events\UserSaved;
use App\Listeners\SaveUserBackgroundInformation;
use App\Models\User;
use App\services\UserServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class SaveUserBackgroundInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_saves_user_background_information()
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

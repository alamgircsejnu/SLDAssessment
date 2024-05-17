<?php

namespace Tests\Feature;

use App\Events\UserSaved;
use App\Listeners\SaveUserBackgroundInformation;
use App\Models\Detail;
use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class SaveUserBackgroundInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_save_user_background_information_listener()
    {
        Event::fake();

        $user = User::factory()->create();

        $userServiceMock = Mockery::mock(UserServiceInterface::class);
        $this->app->instance(UserServiceInterface::class, $userServiceMock);

        $userServiceMock->shouldReceive('saveUserDetails')
            ->once()
            ->with(Mockery::on(function ($arg) use ($user) {
                return $arg->id === $user->id;
            }))
            ->andReturnUsing(function($user) {
                $details = [
                    [
                        'key' => 'Full name',
                        'value' => "{$user->firstname} {$user->middleinitial} {$user->lastname}",
                        'type' => 'bio',
                        'user_id' => $user->id,
                    ],
                    [
                        'key' => 'Middle Initial',
                        'value' => $user->middleinitial,
                        'type' => 'bio',
                        'user_id' => $user->id,
                    ],
                    [
                        'key' => 'Avatar',
                        'value' => $user->avatar,
                        'type' => 'bio',
                        'user_id' => $user->id,
                    ],
                    [
                        'key' => 'Gender',
                        'value' => $user->prefixname == 'Mr'? 'Male' : 'Female',
                        'type' => 'bio',
                        'user_id' => $user->id,
                    ],
                ];

                foreach ($details as $detail) {
                    Detail::updateOrCreate(
                        ['key' => $detail['key'], 'user_id' => $detail['user_id']],
                        $detail
                    );
                }

            });

        event(new UserSaved($user));

        Event::assertDispatched(UserSaved::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });

        (new SaveUserBackgroundInformation($userServiceMock))->handle(new UserSaved($user));

        $this->assertDatabaseHas('details', [
            'key' => 'Full name',
            'value' => "{$user->firstname} {$user->middleinitial} {$user->lastname}",
            'type' => 'bio',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('details', [
            'key' => 'Middle Initial',
            'value' => $user->middleinitial,
            'type' => 'bio',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('details', [
            'key' => 'Avatar',
            'value' => $user->avatar,
            'type' => 'bio',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('details', [
            'key' => 'Gender',
            'value' => $user->prefixname == 'Mr' ? 'Male' : 'Female',
            'type' => 'bio',
            'user_id' => $user->id,
        ]);
    }
}

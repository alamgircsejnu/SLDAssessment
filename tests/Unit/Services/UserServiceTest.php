<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_return_a_paginated_list_of_users()
    {
        User::factory()->count(15)->create();
        $users = (new UserService())->list();
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $users);
        $this->assertCount(10, $users);
    }

    public function test_it_can_store_a_user_to_database()
    {
        $attributes = User::factory()->make()->toArray();
        $attributes['password'] = 'password';
        $user = (new UserService())->createUser($attributes);
        $this->assertDatabaseHas('users', ['email' => $attributes['email']]);
    }

    public function test_it_can_find_and_return_an_existing_user()
    {
        $user = User::factory()->create();
        $foundUser = (new UserService())->findUser($user->id);
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function test_it_can_update_an_existing_user()
    {
        $user = User::factory()->create();
        $updatedAttributes = ['firstname' => 'UpdatedName'];
        (new UserService())->updateUser($user, $updatedAttributes);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'firstname' => 'UpdatedName']);
    }

    public function test_it_can_soft_delete_an_existing_user()
    {
        $user = User::factory()->create();
        (new UserService())->destroy($user);
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_it_can_return_a_paginated_list_of_trashed_users()
    {
        User::factory()->count(5)->create();
        User::first()->delete();
        $users = (new UserService())->trashedUsers();
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $users);
        $this->assertCount(1, $users);
    }

    public function test_it_can_restore_a_soft_deleted_user()
    {
        $user = User::factory()->create();
        $user->delete();
        (new UserService())->restoreUser($user->id);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    public function test_it_can_permanently_delete_a_soft_deleted_user()
    {
        $user = User::factory()->create();
        $user->delete();
        (new UserService())->deleteUser($user->id);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_it_can_upload_photo()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $path = (new UserService())->uploadPhoto($file);
        $this->assertFileExists(public_path($path));
    }

    public function test_it_can_hash_password()
    {
        $password = 'password';
        $hashedPassword = (new UserService())->hash($password);
        $this->assertStringStartsWith('$2y$', $hashedPassword);
        $this->assertTrue(\Hash::check($password, $hashedPassword));
    }
}

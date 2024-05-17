<?php

namespace Tests\Feature;

use App\Models\User;
use App\services\UserServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected UserServiceInterface $userService;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Mocking UserServiceInterface
        $this->userService = Mockery::mock(UserServiceInterface::class);
        $this->app->instance(UserServiceInterface::class, $this->userService);
        User::unsetEventDispatcher();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    // Test index method
    public function test_it_can_list_all_users()
    {
        User::factory()->count(10)->make();

        $paginator = new LengthAwarePaginator(User::all(), 10, 10);
        $this->userService->shouldReceive('list')->once()->andReturn($paginator);

        $response = $this->get('/users');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.index');

        $response->assertViewHas('users', function ($viewUsers) use ($paginator) {
            return $viewUsers instanceof LengthAwarePaginator &&
                $viewUsers->total() == $paginator->total();
        });
    }

    // Test create method
    public function test_it_can_show_create_user_form()
    {
        $response = $this->get('/users/create');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.create');
    }

    // Test store method
    public function test_it_can_store_user()
    {

        $userData = [
            'firstname' => 'Test',
            'lastname' => 'User',
            'username' => 'username',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->userService->shouldReceive('createUser')
            ->once()
            ->with(Mockery::on(function ($data) use ($userData) {
                // Verify that the data matches
                return $data['firstname'] === $userData['firstname'] && $data['lastname'] === $userData['lastname'] && $data['username'] === $userData['username'] && $data['email'] === $userData['email'];
            }));

        $response = $this->post(route('users.store'), $userData);

        $response->assertStatus(302);

        $response->assertRedirect(route('users.index'));
    }

    // Test show method
    public function test_it_can_show_user_details()
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.show', $user->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.show');
        $response->assertViewHas('user', $user);
    }

    // Test show method
    public function test_it_can_can_show_edit_user_form()
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.edit', $user->id));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user', $user);
    }

    // Test store method
    public function test_update_method_redirects_to_users_index()
    {

        $userToUpdate = User::factory()->create();

        $updateData = [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'username' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
        ];

        $this->userService->shouldReceive('updateUser')
            ->once()
            ->with(Mockery::on(function ($user) use ($userToUpdate) {
                return $user->id === $userToUpdate->id;
            }), Mockery::on(function ($data) use ($updateData) {
                return $data['firstname'] === $updateData['firstname'] && $data['lastname'] === $updateData['lastname'];
            }));

        $response = $this->put(route('users.update', $userToUpdate), $updateData);

        $response->assertStatus(302);

        $response->assertRedirect(route('users.index'));
    }

    // Test destroy method
    public function test_destroy_method_redirects_to_users_index()
    {

        $userToDelete = User::factory()->create();

        $this->userService->shouldReceive('destroy')
            ->once()
            ->with(Mockery::on(function ($user) use ($userToDelete) {
                return $user->id === $userToDelete->id;
            }));

        $response = $this->delete(route('users.destroy', $userToDelete));

        $response->assertStatus(302);

        $response->assertRedirect(route('users.index'));
    }

    // Test trashed method
    public function test_trashed_method_displays_trashed_users()
    {
        User::factory()->count(10)->make(['deleted_at' => now()]);

        $paginator = new LengthAwarePaginator(User::onlyTrashed()->get(), 10, 10);
        $this->userService->shouldReceive('trashedUsers')
            ->once()
            ->andReturn($paginator);

        $response = $this->get(route('users.trashed'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('users.trashed');

        $response->assertViewHas('users', function ($viewUsers) use ($paginator) {
            return $viewUsers instanceof LengthAwarePaginator &&
                $viewUsers->total() == $paginator->total();
        });
    }

    // Test restore method
    public function test_restore_method_restores_user_and_redirects()
    {
        $user = User::factory()->create(['deleted_at' => now()]);
        $this->userService->shouldReceive('restoreUser')
            ->once()
            ->with($user->id);

        $response = $this->patch(route('users.restore', $user->id));

        $response->assertRedirect(route('users.trashed'));
    }

    // Test delete method
    public function test_delete_method_deletes_user_and_redirects()
    {
        $user = User::factory()->create(['deleted_at' => now()]);

        $this->userService->shouldReceive('deleteUser')
            ->once()
            ->with($user->id);

        $response = $this->delete(route('users.delete', $user->id));

        $response->assertRedirect(route('users.trashed'));
    }
}

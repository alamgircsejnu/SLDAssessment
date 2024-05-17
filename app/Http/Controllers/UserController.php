<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\services\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        $users = $this->userService->list();
        return view('users.index', ['users' => $users]);
    }


    public function create(): View
    {
        return view('users.create');
    }


    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->userService->createUser($data);

        return redirect()->route('users.index');
    }


    public function show(User $user): View
    {
        return view('users.show', ['user' => $user]);
    }


    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }


    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();
        $this->userService->updateUser($user, $data);

        return redirect()->route('users.index');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->userService->destroy($user);

        return redirect()->route('users.index');

    }

    public function trashed(): View
    {
        $users = $this->userService->trashedUsers();
        return view('users.trashed', ['users' => $users]);
    }

    public function restore($id): RedirectResponse
    {
        $this->userService->restoreUser($id);

        return redirect()->route('users.trashed');
    }

    public function delete($id): RedirectResponse
    {
        $this->userService->deleteUser($id);

        return redirect()->route('users.trashed');
    }
}

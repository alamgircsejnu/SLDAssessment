<?php

namespace App\services;

use App\Models\User;

interface UserServiceInterface
{
    public function list();

    public function findUser($id);

    public function createUser(array $data);

    public function updateUser(User $user, array $data): User;

    public function destroy(User $user);

    public function trashedUsers();

    public function restoreUser($id);

    public function deleteUser($id);

    public function uploadPhoto(\Illuminate\Http\UploadedFile $file);

    public function hash(string $password): string;

    public function saveUserDetails(User $user): void;
}

<?php

namespace App\services;

use App\Models\Detail;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    public function list(): LengthAwarePaginator
    {
        return User::paginate(10);
    }

    public function findUser($id): User
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data): User
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        $data['password'] = $this->hash($data['password']);

        return User::create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $data['photo'] = $this->uploadPhoto($data['photo']);

            if ($user->photo) {
                unlink(public_path($user->photo));
            }
        }

        if (!empty($data['password'])) {
            $data['password'] = $this->hash($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function destroy(User $user): void
    {
        $user->delete();
    }

    public function trashedUsers(): LengthAwarePaginator
    {
        return User::onlyTrashed()->paginate(10);
    }

    public function restoreUser($id): void
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
    }

    public function deleteUser($id): void
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
    }

    public function uploadPhoto($photo): string
    {
        $imageName = time() . '.' . $photo->extension();
        $photo->move(public_path('media/profile_photo'), $imageName);
        return 'media/profile_photo/' . $imageName;
    }

    public function hash(string $password): string
    {
        return Hash::make($password);
    }

    public function saveUserDetails(User $user): void
    {
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
    }
}

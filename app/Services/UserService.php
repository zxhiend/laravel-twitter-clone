<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    /**
     * Find a user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Update a user's profile
     *
     * @param int $id
     * @param array $data
     * @return User
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user->fresh();
    }

    /**
     * Update a user's password
     *
     * @param int $id
     * @param array $data
     * @return void
     * @throws \Exception
     */
    public function updatePassword(int $id, array $data): void
    {
        $user = User::findOrFail($id);

        if (!Hash::check($data['current_password'], $user->password)) {
            throw new \Exception('Current password is incorrect');
        }

        $user->update([
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Delete user account
     *
     * @param User $user
     * @return bool
     */
    public function deleteAccount(User $user): bool
    {
        return $user->delete();
    }
} 
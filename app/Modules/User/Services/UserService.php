<?php
namespace App\Modules\User\Services;
use App\Models\User;
use App\Modules\User\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class UserService
{
    public function createUser(array $data, array $roles = []): User
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($data, $roles) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'parking_lot_id' => $data['parking_lot_id'] ?? null,
            ]);
            if (!empty($roles)) {
                $roleModels = Role::whereIn('name', $roles)->get();
                $user->roles()->attach($roleModels->pluck('id'));
            }
            Log::info("User created: {$user->email} with roles: " . implode(', ', $roles));
            return $user;
        });
    }
    public function assignRoleToUser(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->firstOrFail();
        if (!$user->roles->contains($role->id)) {
            $user->roles()->attach($role);
            Log::info("Role '{$roleName}' assigned to user: {$user->email}");
        }
    }
}

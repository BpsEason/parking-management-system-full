<?php
namespace App\Modules\User\Policies;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->roles()->where('name', 'admin')->exists()
               ? Response::allow()
               : Response::deny('You do not have permission to view users.');
    }
    public function view(User $user, User $model): bool
    {
        if ($user->roles()->where('name', 'admin')->exists()) {
            return Response::allow();
        }
        return $user->id === $model->id
               ? Response::allow()
               : Response::deny('You do not have permission to view this user.');
    }
    public function create(User $user): bool
    {
        return $user->roles()->where('name', 'admin')->exists();
    }
}

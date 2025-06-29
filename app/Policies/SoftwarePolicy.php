<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Software;
use Illuminate\Auth\Access\HandlesAuthorization;

class SoftwarePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_software');
    }

    public function view(User $user, Software $software): bool
    {
        return $user->can('view_software');
    }

    public function create(User $user): bool
    {
        return $user->can('create_software');
    }

    public function update(User $user, Software $software): bool
    {
        return $user->can('update_software');
    }

    public function delete(User $user, Software $software): bool
    {
        return $user->can('delete_software');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_software');
    }

    public function forceDelete(User $user, Software $software): bool
    {
        return $user->can('force_delete_software');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_software');
    }

    public function restore(User $user, Software $software): bool
    {
        return $user->can('restore_software');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_software');
    }

    public function replicate(User $user, Software $software): bool
    {
        return $user->can('replicate_software');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_software');
    }
}

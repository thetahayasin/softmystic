<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Platform;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlatformPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_platform');
    }

    public function view(User $user, Platform $platform): bool
    {
        return $user->can('view_platform');
    }

    public function create(User $user): bool
    {
        return $user->can('create_platform');
    }

    public function update(User $user, Platform $platform): bool
    {
        return $user->can('update_platform');
    }

    public function delete(User $user, Platform $platform): bool
    {
        return $user->can('delete_platform');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_platform');
    }

    public function forceDelete(User $user, Platform $platform): bool
    {
        return $user->can('force_delete_platform');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_platform');
    }

    public function restore(User $user, Platform $platform): bool
    {
        return $user->can('restore_platform');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_platform');
    }

    public function replicate(User $user, Platform $platform): bool
    {
        return $user->can('replicate_platform');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_platform');
    }
}

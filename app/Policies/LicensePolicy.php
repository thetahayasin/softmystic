<?php

namespace App\Policies;

use App\Models\User;
use App\Models\License;
use Illuminate\Auth\Access\HandlesAuthorization;

class LicensePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_license');
    }

    public function view(User $user, License $license): bool
    {
        return $user->can('view_license');
    }

    public function create(User $user): bool
    {
        return $user->can('create_license');
    }

    public function update(User $user, License $license): bool
    {
        return $user->can('update_license');
    }

    public function delete(User $user, License $license): bool
    {
        return $user->can('delete_license');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_license');
    }

    public function forceDelete(User $user, License $license): bool
    {
        return $user->can('force_delete_license');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_license');
    }

    public function restore(User $user, License $license): bool
    {
        return $user->can('restore_license');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_license');
    }

    public function replicate(User $user, License $license): bool
    {
        return $user->can('replicate_license');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_license');
    }
}

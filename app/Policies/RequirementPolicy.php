<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Requirement;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequirementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_requirement');
    }

    public function view(User $user, Requirement $requirement): bool
    {
        return $user->can('view_requirement');
    }

    public function create(User $user): bool
    {
        return $user->can('create_requirement');
    }

    public function update(User $user, Requirement $requirement): bool
    {
        return $user->can('update_requirement');
    }

    public function delete(User $user, Requirement $requirement): bool
    {
        return $user->can('delete_requirement');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_requirement');
    }

    public function forceDelete(User $user, Requirement $requirement): bool
    {
        return $user->can('force_delete_requirement');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_requirement');
    }

    public function restore(User $user, Requirement $requirement): bool
    {
        return $user->can('restore_requirement');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_requirement');
    }

    public function replicate(User $user, Requirement $requirement): bool
    {
        return $user->can('replicate_requirement');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_requirement');
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SoftwareRequirement;
use Illuminate\Auth\Access\HandlesAuthorization;

class SoftwareRequirementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_software::requirement');
    }

    public function view(User $user, SoftwareRequirement $softwareRequirement): bool
    {
        return $user->can('view_software::requirement');
    }

    public function create(User $user): bool
    {
        return $user->can('create_software::requirement');
    }

    public function update(User $user, SoftwareRequirement $softwareRequirement): bool
    {
        return $user->can('update_software::requirement');
    }

    public function delete(User $user, SoftwareRequirement $softwareRequirement): bool
    {
        return $user->can('delete_software::requirement');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_software::requirement');
    }

    public function forceDelete(User $user, SoftwareRequirement $softwareRequirement): bool
    {
        return $user->can('force_delete_software::requirement');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_software::requirement');
    }

    public function restore(User $user, SoftwareRequirement $softwareRequirement): bool
    {
        return $user->can('restore_software::requirement');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_software::requirement');
    }

    public function replicate(User $user, SoftwareRequirement $softwareRequirement): bool
    {
        return $user->can('replicate_software::requirement');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_software::requirement');
    }
}

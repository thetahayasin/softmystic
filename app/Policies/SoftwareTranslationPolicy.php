<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SoftwareTranslation;
use Illuminate\Auth\Access\HandlesAuthorization;

class SoftwareTranslationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_software::translation');
    }

    public function view(User $user, SoftwareTranslation $softwareTranslation): bool
    {
        return $user->can('view_software::translation');
    }

    public function create(User $user): bool
    {
        return $user->can('create_software::translation');
    }

    public function update(User $user, SoftwareTranslation $softwareTranslation): bool
    {
        return $user->can('update_software::translation');
    }

    public function delete(User $user, SoftwareTranslation $softwareTranslation): bool
    {
        return $user->can('delete_software::translation');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_software::translation');
    }

    public function forceDelete(User $user, SoftwareTranslation $softwareTranslation): bool
    {
        return $user->can('force_delete_software::translation');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_software::translation');
    }

    public function restore(User $user, SoftwareTranslation $softwareTranslation): bool
    {
        return $user->can('restore_software::translation');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_software::translation');
    }

    public function replicate(User $user, SoftwareTranslation $softwareTranslation): bool
    {
        return $user->can('replicate_software::translation');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_software::translation');
    }
}

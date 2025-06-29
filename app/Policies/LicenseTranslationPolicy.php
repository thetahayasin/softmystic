<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LicenseTranslation;
use Illuminate\Auth\Access\HandlesAuthorization;

class LicenseTranslationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_license::translation');
    }

    public function view(User $user, LicenseTranslation $licenseTranslation): bool
    {
        return $user->can('view_license::translation');
    }

    public function create(User $user): bool
    {
        return $user->can('create_license::translation');
    }

    public function update(User $user, LicenseTranslation $licenseTranslation): bool
    {
        return $user->can('update_license::translation');
    }

    public function delete(User $user, LicenseTranslation $licenseTranslation): bool
    {
        return $user->can('delete_license::translation');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_license::translation');
    }

    public function forceDelete(User $user, LicenseTranslation $licenseTranslation): bool
    {
        return $user->can('force_delete_license::translation');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_license::translation');
    }

    public function restore(User $user, LicenseTranslation $licenseTranslation): bool
    {
        return $user->can('restore_license::translation');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_license::translation');
    }

    public function replicate(User $user, LicenseTranslation $licenseTranslation): bool
    {
        return $user->can('replicate_license::translation');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_license::translation');
    }
}

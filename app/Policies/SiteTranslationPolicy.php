<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SiteTranslation;
use Illuminate\Auth\Access\HandlesAuthorization;

class SiteTranslationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_site::translation');
    }

    public function view(User $user, SiteTranslation $siteTranslation): bool
    {
        return $user->can('view_site::translation');
    }

    public function create(User $user): bool
    {
        return $user->can('create_site::translation');
    }

    public function update(User $user, SiteTranslation $siteTranslation): bool
    {
        return $user->can('update_site::translation');
    }

    public function delete(User $user, SiteTranslation $siteTranslation): bool
    {
        return $user->can('delete_site::translation');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_site::translation');
    }

    public function forceDelete(User $user, SiteTranslation $siteTranslation): bool
    {
        return $user->can('force_delete_site::translation');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_site::translation');
    }

    public function restore(User $user, SiteTranslation $siteTranslation): bool
    {
        return $user->can('restore_site::translation');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_site::translation');
    }

    public function replicate(User $user, SiteTranslation $siteTranslation): bool
    {
        return $user->can('replicate_site::translation');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_site::translation');
    }
}

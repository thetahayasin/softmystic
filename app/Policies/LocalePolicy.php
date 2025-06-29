<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Locale;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocalePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_locale');
    }

    public function view(User $user, Locale $locale): bool
    {
        return $user->can('view_locale');
    }

    public function create(User $user): bool
    {
        return $user->can('create_locale');
    }

    public function update(User $user, Locale $locale): bool
    {
        return $user->can('update_locale');
    }

    public function delete(User $user, Locale $locale): bool
    {
        return $user->can('delete_locale');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_locale');
    }

    public function forceDelete(User $user, Locale $locale): bool
    {
        return $user->can('force_delete_locale');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_locale');
    }

    public function restore(User $user, Locale $locale): bool
    {
        return $user->can('restore_locale');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_locale');
    }

    public function replicate(User $user, Locale $locale): bool
    {
        return $user->can('replicate_locale');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_locale');
    }
}

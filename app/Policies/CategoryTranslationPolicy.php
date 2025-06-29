<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CategoryTranslation;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryTranslationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_category::translation');
    }

    public function view(User $user, CategoryTranslation $categoryTranslation): bool
    {
        return $user->can('view_category::translation');
    }

    public function create(User $user): bool
    {
        return $user->can('create_category::translation');
    }

    public function update(User $user, CategoryTranslation $categoryTranslation): bool
    {
        return $user->can('update_category::translation');
    }

    public function delete(User $user, CategoryTranslation $categoryTranslation): bool
    {
        return $user->can('delete_category::translation');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_category::translation');
    }

    public function forceDelete(User $user, CategoryTranslation $categoryTranslation): bool
    {
        return $user->can('force_delete_category::translation');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_category::translation');
    }

    public function restore(User $user, CategoryTranslation $categoryTranslation): bool
    {
        return $user->can('restore_category::translation');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_category::translation');
    }

    public function replicate(User $user, CategoryTranslation $categoryTranslation): bool
    {
        return $user->can('replicate_category::translation');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_category::translation');
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_category');
    }

    public function view(User $user, Category $category): bool
    {
        return $user->can('view_category');
    }

    public function create(User $user): bool
    {
        return $user->can('create_category');
    }

    public function update(User $user, Category $category): bool
    {
        return $user->can('update_category');
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->can('delete_category');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_category');
    }

    public function forceDelete(User $user, Category $category): bool
    {
        return $user->can('force_delete_category');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_category');
    }

    public function restore(User $user, Category $category): bool
    {
        return $user->can('restore_category');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_category');
    }

    public function replicate(User $user, Category $category): bool
    {
        return $user->can('replicate_category');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_category');
    }
}

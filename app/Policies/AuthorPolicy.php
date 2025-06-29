<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Author;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_author');
    }

    public function view(User $user, Author $author): bool
    {
        return $user->can('view_author');
    }

    public function create(User $user): bool
    {
        return $user->can('create_author');
    }

    public function update(User $user, Author $author): bool
    {
        return $user->can('update_author');
    }

    public function delete(User $user, Author $author): bool
    {
        return $user->can('delete_author');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_author');
    }

    public function forceDelete(User $user, Author $author): bool
    {
        return $user->can('force_delete_author');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_author');
    }

    public function restore(User $user, Author $author): bool
    {
        return $user->can('restore_author');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_author');
    }

    public function replicate(User $user, Author $author): bool
    {
        return $user->can('replicate_author');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_author');
    }
}

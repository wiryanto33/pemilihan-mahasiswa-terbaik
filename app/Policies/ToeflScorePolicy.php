<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ToeflScore;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToeflScorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_toefl::score');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ToeflScore $toeflScore): bool
    {
        return $user->can('view_toefl::score');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_toefl::score');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ToeflScore $toeflScore): bool
    {
        return $user->can('update_toefl::score');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ToeflScore $toeflScore): bool
    {
        return $user->can('delete_toefl::score');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_toefl::score');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, ToeflScore $toeflScore): bool
    {
        return $user->can('force_delete_toefl::score');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_toefl::score');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, ToeflScore $toeflScore): bool
    {
        return $user->can('restore_toefl::score');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_toefl::score');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, ToeflScore $toeflScore): bool
    {
        return $user->can('replicate_toefl::score');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_toefl::score');
    }
}

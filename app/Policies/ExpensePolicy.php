<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExpensePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Expense $expense): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Expense $expense)
    {
        // 自分の経費かつ、下書きまたは差戻しの場合のみ編集可能
        return $user->id === $expense->user_id
            && in_array($expense->status, ['draft', 'returned']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Expense $expense)
    {
        return $user->id === $expense->user_id
            && $expense->status === 'draft';
    }

    public function submit(User $user, Expense $expense)
    {
        // 自分の経費かつ、下書きまたは差戻しの場合のみ申請可能
        return $user->id === $expense->user_id
            && in_array($expense->status, ['draft', 'returned']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Expense $expense): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Expense $expense): bool
    {
        return false;
    }
}

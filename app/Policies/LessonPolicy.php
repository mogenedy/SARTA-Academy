<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LessonPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lesson $lesson): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user , Course $course): bool
    {
        return $user->hasRole('super_admin') || $user->hasRole('admin') && $course->institute->user_id == $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lesson $lesson): bool
    {
        return $user->hasRole('super_admin') || $user->hasRole('admin') && $lesson->course->institute->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lesson $lesson): bool
    {
        return $user->hasRole('super_admin') || $user->hasRole('admin') && $lesson->course->user_id  == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lesson $lesson): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lesson $lesson): bool
    {
        //
    }
}

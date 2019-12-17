<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\AuthorizationException;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Post $post)
    {
        logger("check auth");
         if ($user->id === $post->user_id) {
             return true;
         } else {
             throw new AuthorizationException('you are not allowed to update');
         }
    }

    public function delete(User $user, Post $post)
    {
        if ($user->id === $post->user_id) {
            return true;
        } else {
            throw new AuthorizationException('you are not allowed to delete');
        }
    }

}

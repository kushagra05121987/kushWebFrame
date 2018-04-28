<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25/4/18
 * Time: 11:26 PM
 */

namespace App\Classes;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;
class PostGateResource
{
    public function view(User $user, Post $post)
    {
        //
        echo "\n inside gate view \n";
        return false;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        echo "\n inside gate create \n";
        return true;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        //
        echo "\n inside gate update \n";
        return null;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        //
        echo "\n inside gate delete \n";
        return [1,2,3];
    }
    public function views(User $user, Post $post)
    {
        //
        echo "\n inside gate views \n";
        return true;
    }

}
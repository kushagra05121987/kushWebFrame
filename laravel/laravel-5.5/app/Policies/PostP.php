<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostP
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        echo "inside policy view";
        return false;
        //
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Post $post)
    {
        //
        echo "<br />Inside Policy create <br />";
        return false;
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
        echo "<br />Inside Policy update <br />";
        return false;
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
        echo "inside policy delete";
        return false;
    }

//    public function updatepost(User $user, Post $post=null) {
//        echo "<br/>Inside Policy updatepost<br/>";
//        return false;
//    }
//    public function authPost(User $user, Post $post=null) {
//        echo "<br/>Inside Policy authPost<br/>";
//        return false;
//    }

    public function before(...$arg) {
        echo "<br/>Inside Policy Before<br/>";
        \D::dump($arg);
    }
}

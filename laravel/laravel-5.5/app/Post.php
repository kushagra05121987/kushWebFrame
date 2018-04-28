<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = "posts";

    public $guarded = [
        'id', 'password'
    ];

    public function user() {
        return $this -> belongsTo('App\User');
    }
    public function comments() {
        return $this -> hasMany('App\PostComments', 'posts_id');
    }

    public function pvcomments() {
        return $this -> morphMany('App\PostComments', 'commentable');
    }

}

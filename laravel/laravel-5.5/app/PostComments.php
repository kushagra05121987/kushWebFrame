<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComments extends Model
{
    protected $table = "post_comments";
    public $guarded = [
        'id', 'password'
    ];

    public function post() {
        return $this -> belongsTo('App\Post', 'posts_id');
    }

    public function comments() {
        return $this -> belongsTo('App\PostComments', 'parent_id');
    }

    public $touches = ['App\Post'];

}

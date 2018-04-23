<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = "videos";

    protected $guarded = ['id'];

    public function comments() {
        return $this -> morphMany('App\Comments', 'commentable');
    }

}

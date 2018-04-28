<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = "Comments";
    protected $guarded = ['id'];

    public function commentable() {
        return $this -> morphTo();
    }
}

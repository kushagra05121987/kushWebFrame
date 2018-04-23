<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/4/18
 * Time: 9:15 PM
 */

class Posts extends Eloquent {
    protected $table = "posts";

    public $guarded = [
        'id', 'password'
    ];


    public function post_comments() {
        return $this -> hasMany('PostComments');
    }

    public function user() {
        return $this -> belongsTo('User');
    }

}
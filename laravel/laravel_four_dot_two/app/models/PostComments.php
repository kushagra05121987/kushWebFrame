<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/4/18
 * Time: 9:15 PM
 */

class PostComments extends Eloquent {
    protected $table = "post_comments";
    public $guarded = [
        'id', 'password'
    ];

    public function posts() {
        return $this -> belongsTo('Posts');
    }

    public function post_comments() {
        return $this -> belongsTo('PostComments', 'parent_id');
    }

    public $touches = ['Posts'];
}
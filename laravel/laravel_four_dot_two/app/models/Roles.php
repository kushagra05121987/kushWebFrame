<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/4/18
 * Time: 1:44 PM
 */

class Roles extends BaseModel {
    protected $table = "Roles";
    protected $guarded = array('id', 'password');

    public function users() {
        return $this -> belongsToMany('User', 'UserRoles', 'user_id', 'role_id') -> withPivot('options') -> withTimestamps()/* -> using('UserRoles')*/;
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = "Roles";
    protected $guarded = array('id', 'password');

    public function users() {
        return $this -> belongsToMany('App\User', 'UserRoles', 'user_id', 'role_id') -> withPivot('options') -> withTimestamps() -> using('App\UserRole');
    }
}

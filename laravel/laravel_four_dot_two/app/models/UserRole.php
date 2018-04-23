<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/4/18
 * Time: 1:31 PM
 */

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    protected $table = "UserRoless";
    protected $guarded = array('user_id', 'role_id');
    public $casts = ['options' => 'array'];
    public function users() {
        return $this->belongsToMany('User');
    }

    // Note: Adding relationships to a pivot model means
    // you'll probably want a primary key on the pivot table.
    public function roles() {
        return $this->belongsToMany('Roles'); // example relationship on a pivot model
    }
}

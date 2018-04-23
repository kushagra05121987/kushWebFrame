<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/4/18
 * Time: 2:13 PM
 */

use Illuminate\Database\Eloquent\Model as Eloquent;
class BaseModel extends Eloquent
{
    protected $table = "UserRoles";
    protected $guarded = array('user_id', 'role_id');
    public $casts = ['options' => 'array'];
    public function __construct(array $attributes = array()){
        parent::__construct($attributes);
    }

    public function newPivot(Eloquent $parent, array $attributes, $table, $exists)
    {
        return new UserRole($parent, $attributes, $table, $exists);
    }
}
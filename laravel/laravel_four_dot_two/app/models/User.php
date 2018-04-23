<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait, \Illuminate\Database\Eloquent\SoftDeletingTrait, UserModelTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    protected $fillable = array('name', 'email');

    protected $guarded = array('id', 'password');

    protected $primmaryKey = 'id';

    public $timestamps = true;

    public $incrementing = true;

    protected $dates = ['del_at'];
// This function here is only for mutation if we return empty from getDates then this function wont' be called.
    public function getDateFormat()
    {
//        echo $this->getConnection()->getQueryGrammar()->getDateFormat();exit;
        return 'Y-m-d H:i:s';
    }

    public function scopeEmail($query, $id) {
        return $query -> withTrashed() -> whereId($id);
    }
    public function scopeOfType($query, $type)
    {
        return $query->where('id', $type);
    }

//    public function scopeOfType($query, $type)
//    {
//        return $query->whereType($type);
//    }

    public static function boot() {
        User::creating(function($user) {echo "\n Creating \n";});
        User::created(function($user) {echo "\n Created \n";});
        User::updating(function($user) {echo "\n Updating \n";});
        User::updated(function($user) {echo "\n Updated \n";});
        User::saving(function($user) {echo "\n Saving \n";});
        User::saved(function($user) {echo "\n Saved \n";});
        User::deleting(function($user) {echo "\n Deleting \n";});
        User::deleted(function($user) {echo "\n Deleted \n";});
        User::restoring(function($user) {echo "\n Restoring \n";});
        User::restored(function($user) {echo "\n REstored \n";});
    }
    public function getDates() {
//        return [];
        return ['created_at', 'deleted_at', 'updated_at'];

    }

//    public function getNameAttribute($value) {
////        return ucfirst($value);
//    }
//    public function setNameAttribute($value) {
////        $this->attributes['name'] = strtoupper($value);
//    }

    public function posts() {
        return $this -> hasOne('Posts');
    }

//    public function comments() {
//        return $this -> hasManyThrough('PostComments', 'Posts');
//    }

    public function roles() {
        return $this -> belongsToMany('Roles', 'UserRoles', 'user_id', 'role_id') -> withPivot('options') -> withTimestamps()/* -> using('UserRoles')*/;
    }
}

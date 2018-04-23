<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function routeNotificationForNexmo() {
        return $this -> phone;
    }

    protected $casts = [
        "options" => "array"
    ];

    protected $appends = [
        'is_admin',
    ];

//    public function getRouteKey() {
//        return $this -> name;
//    }
//
//    public function getRouteKeyName()
//    {
//        return 'name';
//    }

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

    public function getIsAdminAttribute()
    {
        return $this->attributes['password'] == 'yes';
    }
    public function getIsPropAttribute()
    {
        return $this->attributes['password'] == 'yes';
    }
    public function getIsDropAttribute()
    {
        return $this->attributes['password'] == 'yes';
    }

    public static function boot() {
        self::creating(function($user) {
            \Dumper::dump("creating user.");
        });
        self::created(function($user) {
            \Dumper::dump("created user.");
        });
    }
    public function posts() {
        return $this -> hasMany('App\Post');
    }
    public function roles() {
        return $this -> belongsToMany('App\Roles', 'UserRoles', 'user_id', 'role_id') -> withPivot('options') -> withTimestamps() -> using('App\UserRole');
    }
    public function user_roles() {
        return $this -> hasMany('App\UserRole');
    }
    public function comments() {
        return $this -> hasManyThrough('App\PostComments', 'App\Post', 'user_id', 'posts_id');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20/4/18
 * Time: 8:25 PM
 */

namespace App\Classes;


use Illuminate\Support\Facades\Facade;

class Dump extends Facade
{
    public static function getFacadeAccessor() {
        return 'dump';
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25/4/18
 * Time: 11:19 PM
 */

namespace App\Classes;


class authorizePostGate
{
    public function auth() {
        echo "\n inside gate auth \n";
        return [1,2,3];
    }
}
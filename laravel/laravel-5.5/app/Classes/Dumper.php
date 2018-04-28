<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20/4/18
 * Time: 8:11 PM
 */

namespace App\Classes;


class Dumper extends \Illuminate\Support\Debug\Dumper
{

    public function dump($sql) {
        parent::dump($sql);
    }
}
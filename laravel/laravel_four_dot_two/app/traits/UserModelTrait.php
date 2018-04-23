<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/4/18
 * Time: 5:14 PM
 */

trait UserModelTrait{
    public static function bootUserModelTrait() {
        echo "inside";
        self::observe(new ModelObserver);
    }
}
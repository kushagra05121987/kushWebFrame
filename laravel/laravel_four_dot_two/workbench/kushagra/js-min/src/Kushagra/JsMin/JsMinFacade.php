<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/4/18
 * Time: 7:52 PM
 */
namespace Kushagra\JsMin;
use Illuminate\Support\Facades\Facade;

class JSMINFacades extends Facade {
    protected static function getFacadeAccessor() {
        return 'jmin';
    }
}
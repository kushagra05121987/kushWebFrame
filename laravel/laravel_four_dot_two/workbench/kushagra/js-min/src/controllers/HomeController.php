<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/4/18
 * Time: 8:10 PM
 */
namespace Kushagra\JsMin;
class HomeController extends \BaseController {
    public function start() {
        return \View::make('js-min::home');
    }
}
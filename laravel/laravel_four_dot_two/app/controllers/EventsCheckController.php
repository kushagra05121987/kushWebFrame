<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 15/4/18
 * Time: 2:23 PM
 */

class EventsCheckController extends BaseController
{
    public function executeCallbacks($args) {
        echo "Inside event subscriber callback";
        print_r($args);
    }
}
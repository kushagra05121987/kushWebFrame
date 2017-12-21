<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/11/17
 * Time: 6:25 PM
 */
namespace User\Controllers;

use Core\Constants;
use User\Models\Users as Users;
use Core\BaseController as BaseController;
use Core\Helpers\Functions as Helper;
use Core\Middleware\Acl\ACL as ACL;

class HomeController extends BaseController {
    // show home page to user
    public function index() {
        $constantsSystem = Constants::getConstants("SYSTEM");
        $constantsUser = Constants::getConstants("USER");
        self::make(["title" => "Welcome", "constants" => array("system" => $constantsSystem, "user" => $constantsUser)]);
    }
}
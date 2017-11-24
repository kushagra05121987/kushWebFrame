<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 9/11/17
 * Time: 12:21 PM
 */
namespace Core;

use Core\View as View;
use Core\Constants as Constants;
class BaseController extends View {
    public static $userConstants = array();
    public static $systemConstants = array();
    public function __construct() {
        self::$userConstants = Constants::getConstants("USER");
        self::$systemConstants = Constants::getConstants("SYSTEM");
    }
}
new BaseController();
<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/11/17
 * Time: 9:31 AM
 */

namespace User\Controllers;

use Core\Constants;
use User\Models\Users as Users;
use Core\BaseController as BaseController;
use Core\Helpers\Functions as Helper;
use Core\Middleware\Acl\ACL as ACL;

class LoginController extends BaseController {
    // present login form
    public function index() {
        $constantsSystem = Constants::getConstants("SYSTEM");
        $constantsUser = Constants::getConstants("USER");
        self::make(["title" => "Login Form", "constants" => array("system" => $constantsSystem, "user" => $constantsUser)]);
    }
    // check login
    public function check() {
        $constants = Constants::getConstants("SYSTEM");
        $post = $constants['REQUEST']['REST']['POST'];
        $submit = $post['sbmt'];
        $email = $post['email'];
        $password = $post['password'];
        if($submit) { // if form was submitted

            // verify the data first and then send it for acl verification
            if(Helper::validate($email, 'email') && Helper::validate($password, "required")) {
                if(ACL::verify()) { // if login was successful then redirect to route and transfer the data to it
                    $payload = ["state" => 'true'];
                    // transfer data to route
                    Helper::routePayloadTransfer('home', $payload);
                    Helper::redirect('/home');
                } else {
                    echo "inside false verify";exit;
                    // set error if validation is not successful
                    Constants::__setSystemConstant('session', "error", "Login failed please check the credentials you entered");
                    $payload = ["state" => 'false'];
                    // transfer data to route
                    Helper::routePayloadTransfer('login', $payload);
                    Helper::routePayloadTransfer('home', "test value");
                    Helper::redirect('/login');
                }
            } else {
                // set error if fields validation is not successful
                Constants::__setSystemConstant('session', "error", "Fields validation failed. Please check and enter again.");
                Helper::redirect('/login');
            }
        } else { // else if form was not submitted then redirect to back login
            // set error if validation is not successful
            Constants::__setSystemConstant('session', "error", "Bad input");
            Helper::redirect('/login');
        }
    }
}
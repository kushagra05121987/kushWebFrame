<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/11/17
 * Time: 1:59 PM
 */

namespace User\Controllers;

use Core\Constants;
use User\Models\Users as Users;
use Core\BaseController as BaseController;
use Core\Helpers\Functions as Helper;
use Core\Middleware\Acl\ACL as ACL;

class RegisterController extends BaseController{
    // present the user with registration screen
    public function index() {
        $constantsSystem = Constants::getConstants("SYSTEM");
        $constantsUser = Constants::getConstants("USER");
        self::make(["title" => "Registration Page", "constants" => array("system" => $constantsSystem, "user" => $constantsUser)]);
    }

    // get the registration data validate is and register the user
    public function create() {
        $constants = Constants::getConstants("SYSTEM");
        $post = $constants['REQUEST']['REST']['POST'];
        $submit = $post['register'];
        $email = $post['email'];
        $name = $post['name'];
        $password = $post['password'];
        $confirmPassword = $post['confirm_password'];
        if($submit) {
            if(Helper::validate($email, 'email') && Helper::validate($name, 'alpha') && Helper::validate($password, "required") && Helper::validate($confirmPassword, "required")) {
                if($password == $confirmPassword) {
                    try{
                        $users = new Users();
                        // check if the user is not already registered
                        $numRows = $users -> pcEquals("AND", array('email' => $email)) -> numRows();
                        // if email id is not already registered then only create account otherwise notify user
                        if(!$numRows) {
                            $datetime = new \DateTime("now");
                            $users -> addRow(array(
                                'name' => $name,
                                "email" => $email,
                                "password" => password_hash($password, PASSWORD_DEFAULT),
                                "created_at" => $datetime -> format("Y-m-d H:i:s")
                            )) -> commit();
                            // Notify user that account creation was successful
                            Constants::__setSystemConstant('session', "success", "Account successfully created. Go to login screen and login.");
                            Helper::redirect('/register');
                        } else {
                            // notify user that email id is already registered so login
                            Constants::__setSystemConstant('session', "error", "Email id already registered. Please login from login screen.");
                            Helper::redirect('/register');
                        }
                    } catch(\Throwable $t) {
                        echo PHP_EOL;
                        echo $t -> getMessage();
                        echo PHP_EOL;
                    }
                } else {
                    // set error if fields validation is not successful
                    Constants::__setSystemConstant('session', "error", "Password and confirm password fields do not match.");
                    Helper::redirect('/register');
                }
            } else {
                // set error if fields validation is not successful
                Constants::__setSystemConstant('session', "error", "Fields validation failed. Please check and enter again.");
                Helper::redirect('/register');
            }
        } else {
            // set error if validation is not successful
            Constants::__setSystemConstant('session', "error", "Bad input");
            Helper::redirect('/registers');
        }
    }
}
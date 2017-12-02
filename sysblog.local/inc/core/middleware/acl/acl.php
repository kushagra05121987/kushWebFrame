<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/11/17
 * Time: 11:57 PM
 */
namespace Core\Middleware\Acl;

use Core\Response as Response;
use Core\Constants as Constants;
use Core\Model as Model;
use User\Models\Users as Users;
use Core\Helpers\Functions as Helper;

class ACL {

    // check if session exists and has a valid value , if yes then use that value and redirect to dashboard
    public static function check() {
        // New DB object to interact with Database
        $dbo = new class extends Model {
            // table name for current db processing
            protected static $table = "users";
            // call model __init method for creating DB adapter
            public function __construct(string $type = "PDO") {
                $this -> __init($type);
            }
        };
        // pull data from constants
        $systemConstants = Constants::getConstants("SYSTEM");
        $session = $systemConstants["REQUEST"]["SESSION"];

        // check if session is not empty and value in session exists in DB then redirect to specified url else redirect to login page
        if(!empty($session) && array_key_exists("auth", $session) && array_key_exists("uid", $session['auth'])) {
            // get session data
            $session = $session['auth'];
            $uid = $session['uid'];
            $numberOfRows = $dbo -> pcEquals("AND", array("email" => $uid)) -> numRows();
            if(!$numberOfRows) { // if session does not contains valid data then return data with is_valid false
                return new class {
                    public $is_valid = false;
                };
            } else {
                return new class {
                    public $is_valid = true;
                };
            }
        } else { // if no session then return data with is_valid false
            return new class {
                public $is_valid = false;
            };
        }
    }

    // verify if login information is correct
    public static function verify(): bool {
        try {
            $constants = Constants::getConstants("SYSTEM");
            // get data posted by user on login screen
            $post = $constants['REQUEST']['REST']['POST'];
            $email = $post['email'];
            $upassword = $post['password'];

            // Query DB to check if posted data is correct
            $users = new Users();
            $numRows = $users -> pcEquals("AND", array('email' => $email)) -> numRows();

            // check if email id exists in db then pull other details from db
            if($numRows) {
                $users -> clean();
                $record = $users -> pcEquals("AND", array('email' => $email)) -> fetch(['password']) -> first();
                $password = $record['password'];
                // match password stored in db against email id given with the password entered by user
                if(password_verify($upassword, $password)) { // if password matches then set email id as unique identifier to be used otherwise return falses
                    Constants::__setSystemConstant('session', 'auth', array('uid' => $email));
                    return true;
                } else {
                    Constants::__setSystemConstant('session', "error", "Login failed please check the credentials you entered");
                    return false;
                }
            } else {
                return false;
            }

        } catch(\Throwable $t) {
            echo PHP_EOL;
            echo $t -> getMessage();
            echo PHP_EOL;
            return false;
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 28/10/17
 * Time: 9:30 AM
 */
namespace User\Controllers\Admin;

use Core\Constants as Constants;
use Core\Response as Response;
class LoginController {
    public function create() {
        Response::send("200 OK",[1]);
    }
}
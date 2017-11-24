<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26/10/17
 * Time: 5:51 PM
 */
namespace Core\Register;

use Core\View as View;

// Register Global Error Handler
set_error_handler(array("Core\CoreException", "setErrorHandler"));

// Enable or disable 404 pages
View::$enable404 = false;

// register login success redirect url
putenv("lSUrl=/home");

// register login route to be used with acl
putenv("aclLoginRoute=/login");

// register whitelisted urls
$_ENV['whiteListedAclUrls'] = array(
    'login','register'
);

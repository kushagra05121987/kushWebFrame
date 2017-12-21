<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23/10/17
 * Time: 5:07 PM
 */


// Start and Configure Session
    require "./inc/core/session.php";

// Contains all ini settings
    require "./inc/core/ini_settings.php";

// Registers auto loader for application
    require "./inc/core/autoloader.php";

// Register core settings
    require "./inc/core/register.php";

// Holds all the constants for the application
    require "./inc/core/constants.php";

// Include models
    require "./inc/core/model.php";
//    Check if session exists and has valid data then only allow routes to be executed
    require "./inc/core/aclCheck.php";

//    include routes and request related files only if acl check is true
    if($statusCheck || $whiteListUrlCalledFlag) {
//      Registers routes for application
        require "./inc/user/routes.php";

//      Request parser. Parses request
        require "./inc/core/requestparser.php";
    }

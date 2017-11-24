<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26/10/17
 * Time: 8:28 PM
 */
namespace Core;

use Core\Router as Router;
use \Core\Constants as c;

Router::setPrefix("admin");
Router::registerRoute("GET", "/", null,"index", "index");
Router::registerRoute("GET", "/index/index", null,"index", "index");
Router::registerRoute("GET", "/ll/dd", null,"index", "create");
//Router::registerRoute("GET", "/login/create", null,"login", "create");
Router::registerRoute("GET", "/login/create/{id}/{role}", null,"login", "create");
Router::clearPrefix();

Router::registerRoute("GET", "/this/user", null,"index", "index");
//Router::registerRoute("GET", "/");
Router::registerRoute("GET", "/index/index");
Router::registerRoute("GET", "/default/callback/{table}/{people}/new/updated/url/{one}/{two}/{three}", function() {
    print_r(c::getConstants("SYSTEM"));
    echo "inside this method";
});
Router::registerRoute("GET", "/", function() {
    echo "Now inside this section";
});
// show login form
Router::registerRoute("GET", "/login", null, "login", "index");
// check if information given at login form is correct
Router::registerRoute("POST", "/login", null, "login", "check");

// Show register form
Router::registerRoute("GET", "/register", null, "register", "index");

// gather registration data and create new entry in db
Router::registerRoute("POST", "/register", null, "register", "create");

// home for user
Router::registerRoute("GET", "/home", null, "home", "index");
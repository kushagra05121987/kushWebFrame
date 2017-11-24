<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/9/17
 * Time: 11:20 AM
 */
//ini_set('session.use_strict_mode', 1);
ini_set('session.use_trans_sid', 1); // enable trans sid support now session will behave as if new session id is requested for every
// reload.
ini_set("session.use_cookies", 0);
ini_set('session.use_only_cookies', 0);
ini_set('session.hash_function', 'whirlpool');
echo "<pre>";
function generateSessionId() {
    return "1234abcd";
}
session_id(generateSessionId());
print_r(hash_algos());
session_start();
echo SID;
echo "<br />";
echo session_id();
echo "<br />";
echo session_name();
echo "<br />";
/**
 * Warning
 * Current session_regenerate_id does not handle unstable network well. e.g. Mobile and WiFi network. Therefore, you may experience lost session by calling session_regenerate_id.
 * You should not destroy old session data immediately, but should use destroy time-stamp and control access to old session ID.
 * Otherwise, concurrent access to page may result in inconsistent state, or you may have lost session, or it may cause client(browser) side race
 * condition and may create many session ID needlessly. Immediate session data deletion disables session hijack attack detection and prevention also.
 */
session_regenerate_id(true);
echo "<hr />";
echo SID;
echo "<br />";
echo session_id();
echo "<br />";
/**
 * session_status() is used to return the current session status.
 * PHP_SESSION_DISABLED if sessions are disabled.
 * PHP_SESSION_NONE if sessions are enabled, but none exists.
 * PHP_SESSION_ACTIVE if sessions are enabled, and one exists.
 */
echo session_status();
echo "<br />";
// array_flip flips the keys to values and values to keys
function array_keys_exists($keys, $array) {
    return array_diff_key(array_flip($keys), $array);
}
$array = array("a" => 1, "b" => 2, "c" => 3, "d" => 4, "e" => 5);
print_r(array_keys_exists(array("l", "m"), $array));
echo "<br />";
print_r(array_keys_exists(array("a", "b", "h"), $array));
echo "<br />";
echo "=================== Printing Session Variables =================== ";
echo "<br />";
print_r($_SESSION);
echo "<br />";
print_r(array_keys_exists(array("custom-x-session", "custom-y-session"), $_SESSION));
if(array_keys_exists(array("custom-x-session", "custom-y-session"), $_SESSION)) {
    echo "<br />Setting both session value<br />";
    $_SESSION["custom-x-session"] = "Custom-x-value";
    $_SESSION["custom-y-session"] = "Custom-y-value";
}
if(!array_key_exists("custom-x-session", $_SESSION)) {
    echo "<br />Setting X session <br />";
    $_SESSION["custom-x-session"] = "Custom-x-value";
}
if(!array_key_exists("custom-y-session", $_SESSION)) {
    echo "<br />Setting Y session <br />";
    $_SESSION["custom-y-session"] = "Custom-y-value";
}
print_r($_SESSION);
//session_unregister("$name");  // deprecated and removed. Unregister a global variable from the current session
//session_unset();

echo "<br />";
output_add_rewrite_var('var', 'value');
echo "<br /> ================ LIST ALL HANDLERS ================ <br />";
print_r(ob_list_handlers()); // list all handlers currently active
print_r(ini_get('url_rewriter.tags'));
echo "<br />";
echo "<br /> ================ LIST REWRITE HOSTS ================ <br />";
//print_r($_SERVER);
//ini_set('url_rewriter.hosts', "sysblog.local"); // Multiple hosts can be specified by ",", no space is allowed between hosts. e.g. php.net,wiki.php.net,bugs.php.net
print_r(ini_get('url_rewriter.hosts'));
?>
<a href="sysblog.local/" target="_blank">Click</a>
<a href="sysblog.local/index.php" target="_blank">Click</a>
<a href="index.php" target="_blank">Click</a>
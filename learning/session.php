<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/9/17
 * Time: 1:17 PM
 */
//session_name("kushagraSessionId"); // with no parameter passed gives current session name used. With name passed uses that name and
// changes the session parameter.
// With strict mode on any new session id which is uninitialized that means does not exist PHP will create a new another session id different from the
// one passed by the user and initializes it rather that using the id passed by the user ( PHPSESSID: HI)
ini_set('session.use_strict_mode', 0); // example of usecase is in  sessionCheck.php and sessionResponse.php
session_start();
//session_start([
//    'cookie_lifetime' => 86400, // sets the life time of session cookies
//    'read_and_close'  => true, // reads and closes the session stopping from adding any further data to it.
//]);
echo "<pre>";

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
echo "<br /> First =========== <br />";
print_r($_SESSION);
$_SESSION["kushagra"] = "Mishra";
session_write_close();
session_start();
echo "<br /> SESSION WITH FIRST VALUE ASSIGNMENT =========== <br />";
print_r($_SESSION);
$_SESSION["new kushagra"] = "new mishra";
echo "<br /> SESSION WITH NEXT VALUE ASSIGNMENT =========== <br />";
print_r($_SESSION);
session_reset(); // resets the session to the original value and discards any new changes.
//If you need to rollback the session values after seting new value to session variables use session_reset()
echo "<br /> SESSION AFTER RESET =========== <br />";
print_r($_SESSION);
session_write_close(); // opposite to read_and_close option writes to session and closes the session. Anything written after if would not affect the global session
session_commit(); // alias of session_write_close
session_start();
$_SESSION["ABORT KEY"] = "ABORT VALUE";
echo "<br /> SESSION BEFORE ABORT =========== <br />";
print_r($_SESSION);
session_abort(); // Discard session array changes and finish session
session_start();
echo "<br /> SESSION AFTER ABORT =========== <br />";
print_r($_SESSION);
session_commit();
//session_create_id("MyCustomSessionName-");// Available for php >= 7.1.0 // creates a session id with a specific prefix given. Generates a
// COLLISION Free session id. If session is not active, collision check is omitted. This function Generates session id , if prefix is specified then with
// prefix other wise without prefix the default id is generated. This id is supposed to be used with session_id
/**
 * Example
 * // My session start function support timestamp management
* function my_session_start() {
* session_start();
* // Do not allow to use too old session ID
* if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 180) {
* session_destroy();
* session_start();
* }
* }
*
* // My session regenerate id function
* function my_session_regenerate_id() {
* // Call session_create_id() while session is active to
* // make sure collision free.
* if (session_status() != PHP_SESSION_ACTIVE) {
* session_start();
* }
* // WARNING: Never use confidential strings for prefix!
* $newid = session_create_id('myprefix-');
* // Set deleted timestamp. Session data must not be deleted immediately for reasons.
* $_SESSION['deleted_time'] = time();
* // Finish session
* session_commit();
* // Make sure to accept user defined session ID
* // NOTE: You must enable use_strict_mode for normal operations.
* ini_set('session.use_strict_mode', 0);
* // Set new custome session ID
* session_id($newid);
* // Start with custome session ID
* session_start();
* }
*
* // Make sure use_strict_mode is enabled.
* // use_strict_mode is mandatory for security reasons.
* ini_set('session.use_strict_mode', 1);
* my_session_start();
*
* // Session ID must be regenerated when
* //  - User logged in
* //  - User logged out
* //  - Certain period has passed
* my_session_regenerate_id();
*
* // Write useful codes
 */

session_start();
echo "<br />";
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
//unset($_SESSION);// Unsets $_SESSION variable so that we start getting Undefined variable: _SESSION
echo "<br /> ========== Second ============ <br />";
print_r($_SESSION);
//session_unregister("$name");  // deprecated and removed. Unregister a global variable from the current session
//session_unset(); // unsets all the variables in $_SESSION making it empty but doesn't destroy it from the storage source as in session_destroy.
echo "<br /> ========== Third ============ <br />";
print_r($_SESSION);
//session_destroy(); // deletes the complete session file from storage path of whatever save_handler is used
echo "<br /> ========== Fourth ============ <br />";
print_r($_SESSION);

$_SESSION['login_ok'] = true;
$_SESSION['nome'] = 'sica';
$_SESSION['inteiro'] = 34;
echo "<br /> ========== ENCODED SESSION ============ <br />";
echo session_encode(); // serialises session data
echo "<br /> ========== DECODED SESSION ============ <br />";
$data = 'My-Penis-Is-Big|s:7:"anddark";custom-x-session|s:14:"Custom-x-value";custom-y-session|s:14:"Custom-y-value";kushagra|s:6:"Mishra";login_ok|b:1;nome|s:4:"sica";inteiro|i:34;';
session_decode($data); // unserialises session data and sets global php session variable
print_r($_SESSION);
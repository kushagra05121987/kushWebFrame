<?php
// The following error types cannot be handled with a user defined function:
// E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, and most of E_STRICT
// raised in the file where set_error_handler() is called.
// TO catch Errors apart from above we need set_error_handler and in there we can throw ErrorException which can be caught using try/
// catch block.
// While in PHP 7 Errors are a separate class implementing Throwable implement and hence can and are thrown which can be caught same as Exceptions ( True for Fatal and unrecoverable errors
// for other types of errors we still have to follow the same process.). In try catch we can now use Throwable $t to catch both error and exceptions
// Every error in php 7 is thrown as exception which if not caught bubbles up the try/catch chain ,if no block handles it then it goes to set_error_handler if there also its not handled
// then its treated as a normal Fatal Error.
// PHP classes cannot implement the Throwable implement directly, and must instead extend Exception.
// As of PHP 5 Fatal Errors can be caught with following procedure, they cannot be caught even with set_error_handler.

/**
set_error_handler(function($errno, $errstr, $errfile, $errline ) {
echo "inside error handler";
echo "<br />";
throw new ErrorException($errstr, 0, $errno, $errfile, $errline); /// passes control to catch block
});
register_shutdown_function(function() {
$error = error_get_last();
print_r($error);
echo "<br />";
echo E_ERROR;
});
//restore_error_handler();

set_exception_handler(function() {
echo "inside exception handler";
echo "<br />";
});
$var = 1;
$var->method(); // generates a fatal error and goes to set_exception_handler
try {
// 1/0;
// $var->method(); // Throws an Error object in PHP 7.
} catch(Exception $e) {
echo "Inside Exception";
}
 */
class MyExceptionClass extends Exception {
	public function __construct($message, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
	public function __toString() {
		return __CLASS__. ": [{$this->code}]: {$this->message}\n";
	}
	public function customFunction() {
        echo "A custom function for this type of exception\n";
    }
}

try {
	throw new MyExceptionClass("MyException Occured", 500, null);
} catch(MyExceptionClass $e) {
	echo $e -> getMessage();
	echo "<br />";
	echo $e -> customFunction();
} catch(Exception $e) {
	echo $e -> getMessage();
	echo "<br />";
}
echo "<br />";
set_error_handler(function($errno, $errstr, $errfile, $errline ) {
    echo "inside error handler";
    echo "<br />";
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline); /// passes control to catch block
});
//restore_error_handler();

set_exception_handler(function() {
    echo "inside exception handler";
    echo "<br />";
});
$var = 1;
//$var->method(); // generates a fatal error and goes to set_exception_handler
try {
//    1/0;
    $var->method(); // Throws an Error object in PHP 7.
} catch(Error $e) {
    echo "Inside Error";
} catch(Throwable $t) {
    echo "Inside Throwable";
} catch (ErrorException $e) {
    // Handle error
    echo "Inside Error Exception";
} catch(Exception $e) {
    echo "Inside Exception";
}
exit;
echo "<br /> ======== ========== ========== <br />";
/**
 * Internal PHP functions mainly use Error reporting, only modern Object oriented extensions use exceptions.
 * However, errors can be simply translated to exceptions with ErrorException.
 */
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

function error_handler($errno, $errstr, $errfile, $errline){
    $err = array(
        'errno' => $errno,
        'errstr' => $errstr,
        'errfile' => $errfile,
        'errline' => $errline
    );

    DB::insertAssoc('table_error', $err);
}

set_error_handler("exception_error_handler");

try {
    $q/1;
} catch (ErrorException $e) {
    error_handler(
        $e->getSeverity(),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine()
    );
}
try {
    //$p -> method() // Generates a parse error which will not be caught
    $p -> method();
//        new useTraits();
    } catch(Error $e) {
    echo "Inside Error Of catch ";
//        print_r($e);
} catch(ErrorException $e) {
    echo "\n Inside Error Exception \n ";
} catch(Throwable $t) {
    echo "\n Inside Throwable \n ";
}
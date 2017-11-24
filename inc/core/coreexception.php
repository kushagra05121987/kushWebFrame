<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23/10/17
 * Time: 10:49 PM
 */
namespace Core;

use Throwable;
use Core\Response as Response;

class CoreException extends \Exception {
    //    Handles Errors which cannot be caught in try/catch block and are not parse , core or any such sort of error
    public static function setErrorHandler($errno, $errstr, $errfile, $errline) {
        throw new \ErrorException($errstr, 0, $errno, $errfile, $errline); /// passes control to catch block
    }
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public static function __sendErrorResponse(string $message, string $statusCode = "500 Internal Server Error") {
        Response::setStatusCode($statusCode);
        throw new self($message);
    }
}
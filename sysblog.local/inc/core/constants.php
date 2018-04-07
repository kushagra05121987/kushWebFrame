<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 23/10/17
 * Time: 5:31 PM
 */

/*
 * Global Constants
 * */
namespace Core;
use Core\CoreException as cException;

class Constants {
    private const CORE_CONSTANTS = array(
        "PATH" => array(
            "CORE_INI_FILE_PATH" => "inc".DIRECTORY_SEPARATOR."core".DIRECTORY_SEPARATOR."ini".DIRECTORY_SEPARATOR,
            "USER_INI_FILE_PATH" => "inc".DIRECTORY_SEPARATOR."user".DIRECTORY_SEPARATOR."ini".DIRECTORY_SEPARATOR,
            "USER_CONTROLLER_LOAD_PATH" => "inc".DIRECTORY_SEPARATOR."user".DIRECTORY_SEPARATOR."controller".DIRECTORY_SEPARATOR
        ),
    );
    private static $config_vars = null;

    private static function readUserIni(array $ini_constants): array {
        //      Read all other ini config files written by user.
        $ini_files = glob(self::CORE_CONSTANTS["PATH"]['USER_INI_FILE_PATH']."*.ini");
        foreach($ini_files as $file) {
            if(!strpos($file, "default.ini")) {
                $iniFileName = substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1, strlen($file)-1);
                $fileName = substr($iniFileName, 0, strpos($iniFileName, "."));
                if(!array_key_exists($fileName, $ini_constants)) {
                    // Parse all other ini files
                    $ini_constants[$fileName] = parse_ini_file(self::CORE_CONSTANTS["PATH"]['USER_INI_FILE_PATH'].$iniFileName);
                } else {
                    cException::__sendErrorResponse("Ini config file with name $fileName already exists", "208 Already Reported");
                }
            }
        }

        return $ini_constants;
    }

    // Initialise constants including the ini file and other user defined constants as well as rest constants.
    public static function _init() {
        try {
            // Parse default.ini file
            $ini_constants = array("default" => parse_ini_file(self::CORE_CONSTANTS["PATH"]['CORE_INI_FILE_PATH']."default.ini"));
        } catch (\Throwable $t) {
            cException::__sendErrorResponse("default.ini config not found in ".self::CORE_CONSTANTS["PATH"]['CORE_INI_FILE_PATH'], "404 Not Found");
        }

        // Read user defined ini files
        $ini_constants = self::readUserIni($ini_constants);

        // Set system wide global constants
        self::$config_vars = array(
            "USER" => array(
                "APP_CONFIG" => $ini_constants,
                "CUSTOM" => array()
            ),
            "SYSTEM" => array(
                "REQUEST" => array(
                    "REST" => array(
                        "METHOD" => $_SERVER['REQUEST_METHOD'],
                        "GET" => $_GET,
                        "POST" => $_POST,
                        "URL" => array(),
                        "REQUEST_BODY" => file("php://input"),
                        "REQUEST" => $_REQUEST
                    ),
                    "SERVER" => $_SERVER,
                    "SESSION" => $_SESSION,
                    "COOKIE" => $_COOKIE
                )
            )
        );
    }
    // Set custom constants
    public static function _setUserConstants(string $name = "", $value) {
        if(!$name) {
            cException::__sendErrorResponse("No name given. Please specify name of the constant.", "404 Not Found");
        } else {
            self::$config_vars["USER"]["CUSTOM"][$name] = $value;
        }
    }
    // Return private constants variable
    public static function getConstants(string $name) : array {
        return self::$config_vars[$name];
    }

    // Set automatically available system constants
    public static function setSystemURLConstant(array $urlParams) {
        self::$config_vars['SYSTEM']['REQUEST']['REST']['URL'] = $urlParams;
    }

    // modify constants
    public static function __setSystemConstant(string $catName, string $cKey, $cValue, int $timeout = 3600) {
        if($catName && $cKey && $cValue) {
            $catName = strtolower($catName);
            switch ($catName) {
                case "session":
                    $_SESSION[$cKey] = $cValue;
                    self::$config_vars["SESSION"] = $_SESSION;
                    break;
                case "cookie":
                    setcookie($cKey, $cValue, $timeout);
                    self::$config_vars["COOKIE"] = $_COOKIE;
                    break;
                case "cleansession":
                    $_SESSION = [];
                    self::$config_vars["SESSION"] = $_SESSION;
                    return true;
                    break;
                case "cleancookie":
                    $_COOKIE = [];
                    self::$config_vars["COOKIE"] = $_COOKIE;
                    return true;
                    break;
                case "default":
                    return false;
                    break;
            }
            return true;
        } else {
            return false;
        }
    }
}
Constants::_init();
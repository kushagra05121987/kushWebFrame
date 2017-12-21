<?php
    /**
     * This is a Global Namespace when there are multiple namespaces in same file, the global scope code goes in this global namespace.
     * Namespace declaration statement has to be the very first statement or after any declare call in the script.
     */
	namespace {
        echo strftime("%H:%M:%S", time());
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
		class Package {
            public function __construct() {
                echo "Hi";
            }
        }
        class NestedException extends Exception {
		    public function __construct($message = "", $code = 0, Throwable $previous = null) {
                parent::__construct($message, $code, $previous);
            }
        }
	}
	namespace Package\MyClasses {
	    class MyPublicClass {
	        public function __construct() {
            }
        }
        class MyPrivateClass {
	        protected function __construct() {
            }
            protected static function contained() {

            }
        }
    }

<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30/10/17
 * Time: 3:25 PM
 */
namespace Core\Model\Adapters;

use Core\Response;

trait AdapWrapper {
    // Model load path
    private static $modelClassPath = "Core\\Model\\Adapters\\";
    // current db extension object holder
    protected $dbco = null;

    // current active db library
    protected $activeLib = "";

    // calls extension specific create adapter method
    private function __createAdapter(string $adapterClass, string $table) {
        // Map correct db class based on required lib
        switch($adapterClass) {
            case "PDO":
                $this -> activeLib = "LibPdo";
                break;
            case "MYSQLI":
                $this -> activeLib = "LibMysqli";
                break;
        }
        if($this -> activeLib) {
            $libClass = self::$modelClassPath.$this -> activeLib;

            // call respective library's create adapter method to create adapter
            forward_static_call(array($libClass, "__createAdapter"));

            // create lib specific object
            $this -> dbco = new $libClass($table);
        } else {
            Response::setStatusCode("Cannot find the library requested.");
        }
    }

    // call all methods related to db library
    public function __call(string $name, array $arguments) {
        try {
            return call_user_func_array(array($this -> dbco, $name), $arguments);
        } catch (\Throwable $t) {
            echo $t -> getMessage();
        }
    }
}
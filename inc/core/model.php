<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30/10/17
 * Time: 2:47 PM
 */

namespace Core;

use Core\Model\Adapters\AdapWrapper as AdapWrapper;
class Model {
    use AdapWrapper;
    private static $modelDir = ".".DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."user".DIRECTORY_SEPARATOR."models";
    protected function __init(string $type = "PDO") {
        // Prepare DB adapter on the fly depending on the type of adapter wanted
        $this -> __createAdapter($type, static::$table);
    }
}


<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 31/10/17
 * Time: 5:14 PM
 */
namespace User\Models;

use Core\Model as Model;
class Users extends Model{
    // define table
    protected static $table = "users";
    public function __construct(string $type = "PDO") {
        $this -> __init($type);
    }
}
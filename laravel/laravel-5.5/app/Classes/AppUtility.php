<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/4/18
 * Time: 3:52 PM
 */
namespace App\Classes;

use App\Classes\FireUtility;
use Illuminate\Http\Request;

class AppUtility {
    public function __construct(FireUtility $fu) {
        $this -> fu = $fu;
    }
    public function runSerivces() {
//        var_dump(get_class($request));
        $this -> fu -> getLadder();
        $this -> fu -> sprinkleWater();
        $this -> fu -> savePeople();
    }
}
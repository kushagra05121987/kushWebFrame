<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/10/17
 * Time: 3:33 PM
 */
namespace User\Controllers\Admin;
use User\Models\Users as Users;
use Core\BaseController as BaseController;
class IndexController extends BaseController {
    public function index() {
        $users = new Users("MYSQLI");

//        $result = $users -> orderBY("id DESC") -> IN("AND", "id", array(1,2,3,4,5,6)) -> pcEquals("OR", array('id'=> 8))-> bindTypes('iiiiiii') -> fetch(['id']) -> all();
        $result = $users -> addRow(array(
            "name" => "My new Kushagra name",
            "is_active" => 1,
            "uniqueEntry" => 12
        )) -> bindTypes("sii") -> commit();

        self::make(["result" => $result, "userC" => self::$userConstants, "systemC" => self::$systemConstants]);
    }
}
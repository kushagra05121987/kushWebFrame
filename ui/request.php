<?php
    // print_r(file_get_contents("php://input"));
    // print_r($_POST);
    // print_r($_GET);
    // print_r($requestPayload);
    // file_put_contents("request.json", json_encode($requestPayload));
    $server = $_SERVER;
    if(strtolower($server['REQUEST_METHOD']) == 'post') {
        if(!empty($_POST)) {
            $request = (object) $_POST;
        } else {
            $request = file_get_contents("php://input");
            $request = (array) json_decode($request);
            $request['details'] = "defaults";
            $request = json_encode($request);            
        }        
        print_r($request);
    } else if(strtolower($server['REQUEST_METHOD']) == 'get') {
        $class = new class {
            public $name = "Kushagra", $sex = "male", $_did = 12;
            private $worker = true;
            public function tries() {
                return ["name" => $this -> name, "sex" => $this -> sex];
            }
        };
        if($_GET && array_key_exists("under", $_GET)) {
            $ar = array();
            array_push($ar, $class);
            echo "inside hree";
            print_r($ar);
        } else {
            echo json_encode($class);
        }
    }
   
    // echo (string) new class {
    //     public $name = "Kushagra", $sex = "male";
    //     private $worker = true;
    //     public function tries() {
    //         return ["name" => $this -> name, "sex" => $this -> sex];
    //     }
    //     public function __toString() {
    //         return json_encode(["name" => $this -> name, "sex" => $this -> sex]);
    //     }
    // };

    // $arr = (array) new class {
    //     public $name = "Kushagra", $sex = "male";
    //     private $worker = true;
    //     public function tries() {
    //         return ["name" => $this -> name, "sex" => $this -> sex];
    //     }
    //     public function __toString() {
    //         return json_encode(["name" => $this -> name, "sex" => $this -> sex]);
    //     }
    // };

    // print_r($arr);

    // $obj = new class {
    //     public $name = "Kushagra", $sex = "male";
    //     private $worker = true;
    //     public function tries() {
    //         return ["name" => $this -> name, "sex" => $this -> sex];
    //     }
    //     public function __toString() {
    //         return json_encode(["name" => $this -> name, "sex" => $this -> sex]);
    //     }
    // };
    // print_r(get_object_vars($obj));
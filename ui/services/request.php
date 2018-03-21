<?php
    // print_r(file_get_contents("php://input"));
    // print_r($_POST);
    // print_r($_GET);
    // print_r($requestPayload);
    // file_put_contents("request.json", json_encode($requestPayload));
    echo json_encode(new class {
        public $name = "Kushagra", $sex = "male";
        private $worker = true;
        public function tries() {
            return ["name" => $this -> name, "sex" => $this -> sex];
        }
    });
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
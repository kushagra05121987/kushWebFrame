<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17/10/17
 * Time: 10:50 AM
 */

/**
 * If two Traits insert a method with the same name, a fatal error is produced, if the conflict is not explicitly resolved.

To resolve naming conflicts between Traits used in the same class, the insteadof operator needs to be used to choose exactly one of the conflicting methods.

Since this only allows one to exclude methods, the as operator can be used to add an alias to one of the methods. Note the as operator does not rename the method and it does not affect any other method either.
 * 'use' can be used to change the visibility of the methods as well
 * Abstract keyword can also be used with traits and not only abstract classes. The classes using abstract method need to define the methods body.
 * Properties can be defined in traits with visibility. Without public , protected or private visibility properties will not work
 */

namespace PrivateTraits {
    echo "<pre>";

    trait traitA
    {
        private function method1()
        {
            echo "\n Inside Method 1 of trait A \n";
        }

        private function method2()
        {
            echo "\n Inside Method 2 of trait A \n";
        }
    }

    trait traitB
    {
        public function method1()
        {
            echo "\n Inside Method 1 of trait B \n";
        }

        protected function method2()
        {
            echo "\n Inside Method 2 of trait B \n";
        }
    }
}
/*
Traits cannot extend or implement other traits
*/
//trait traitC extends traitB {}
//trait traitC implement traitB {}

namespace GlobalTraits{
    use PrivateTraits as t;
    trait traitC
    {
        /*
        The code below generates fatal error because we cannot use traits having same method names which will result in collision
        Try catch cannot be openly put in traits as traits are also similar to classes so we need a method to use them
        So in order to resolve this conflict we need insteadof operator and also the 'as' operator can be  used to give alias name to methods in traits.
        */
        //use t\traitA;
        //use t\traitB;
        public $x = 1;
        use t\traitA, t\traitB {
            t\traitA::method1 insteadof t\traitB;
            t\traitB::method2 insteadof t\traitA;
            t\traitA::method1 as mA1;
            t\traitA::method2 as mA2;
            t\traitB::method1 as mB1;
            t\traitB::method2 as mB2;
        }


        protected function useTryCatch() {
            try {
                //        use PrivateTraits\traitB; // if inside a global namespace then we can use direct namespace name for reference like in this case PrivateTraits can be directly used if using namespace{} but will have to use 'use' keyword if inside another namespace like in this case GlobalTraits{}
            } catch(Exception $e) {

            }
        }

    }
}

namespace {
    class useTraits {
        use GlobalTraits\traitC;
        public function __construct() {
            $this -> mA1();
            $this -> mB1();
            $this -> method1();
            $this -> method2();
            $this -> useTryCatch(); // This will not call traits method but will call class's method instead .
        }
        public function useTryCatch() {
            echo "\n Inside Class useTryCatch \n ";
        }
    }
    new useTraits();
    // Changing Method Visibility of trait methods
    trait HelloWorld {
        public function sayHello() {
            echo "\n Hello World! \n";
        }
    }

// Change visibility of sayHello
    class MyClass1 {
        use HelloWorld { sayHello as protected; }
    }

// Alias method with changed visibility
// sayHello visibility not changed
    class MyClass2 {
        use HelloWorld { sayHello as private myPrivateHello; }
    }
    // Abstract trait members
    trait Hello {
        public function sayHelloWorld() {
            echo "\n Echoing from inside trait \n ";
            echo "Class: " . __CLASS__ . PHP_EOL;
            echo "Trait: " . __TRAIT__ . PHP_EOL;
            echo 'Hello'.$this->getWorld().PHP_EOL;
        }
        abstract public function getWorld();
    }

    class MyHelloWorld {
        private $world;
        use Hello;
        public function __construct() {
            $this -> sayHelloWorld();
            echo "\n ============== \n";
            $this -> callMe();
        }

        public function getWorld() {
            echo "\n Echoing from inside class Get World \n";
            echo "Class: " . __CLASS__ . PHP_EOL;
            echo "Trait: " . __TRAIT__ . PHP_EOL;
            return $this->world;
        }
        public function setWorld($val) {
            $this->world = $val;
        }
        public function callMe() {
            echo "\n Echoing from inside class \n ";
            echo "Class: " . __CLASS__ . PHP_EOL;
            echo "Trait: " . __TRAIT__ . PHP_EOL;
        }
    }
    $mw = new MyHelloWorld();
    $mw -> setWorld(" Kushagra ");
    echo $mw -> getWorld();

    // Static trait members
    trait Counter {
        public function inc() {
            static $c = 0;
            $c = $c + 1;
            echo "$c\n";
        }
    }

    class C1 {
        use Counter;
    }

    class C2 {
        use Counter;
    }

    $o = new C1(); $o->inc(); // echo 1
    $p = new C2(); $p->inc(); // echo 1

    // Static methods
    trait StaticExample {
        public static function doSomething() {
            return 'Doing something';
        }
    }

    class Example {
        use StaticExample;
    }

    Example::doSomething();

    // Traits properties
    trait PropertiesTrait {
        public $x = 1;
    }

    class PropertiesExample {
        use PropertiesTrait;
    }

    $example = new PropertiesExample;
    $example->x;
}
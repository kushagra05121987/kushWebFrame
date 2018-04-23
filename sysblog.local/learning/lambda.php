<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19/10/17
 * Time: 9:48 AM
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<pre>";
/*
 * We cannot create a static method outside class unless it is lambda.
 * */
echo "\n=================== Lambda Functions =================== \n";
// Lambda functions are implemented using Closure class.
// Lambda functions can be static as well
$i = 20;
$f = function() use ($i) { // creates a copy and modifies that copy not the actual variable
    ++$i;
    var_dump($i);
};
$f();
echo "\n Printing Lambda Values out of the method. \n ";
var_dump($i);
echo "\n Automatic binding of \$this \n";
// $this is also a variable not declared inside lambda so it should also be injected to the lambda function using 'use' till php 5.3 but
// As of PHP 5.4.0, when declared in the context of a class, the current class is automatically bound to it, making $this available inside of the function's scope. If this automatic binding of the current class is not wanted, then static anonymous functions may be used instead.
class Test
{
    public function testing()
    {
        return function() {
            var_dump($this);
        };
    }
}

$object = new Test;
$function = $object->testing();
$function();
// using static binding on anonymous function to stop auto binding of $this to lambda method
class Foo
{
    function __construct()
    {
        $func = static function() {
            var_dump($this); // Generates notice of $this undefined
        };
        $func();
    }
};
new Foo();
echo "\n Executing Static Method \n";
static $i = 0;
$count = 0;
$f1 = function() use ($i) {
    ++$i;
    echo "\n F1 value of i = $i \n";
};
$f2 = static function() use ($i) {
    ++$i;
    echo "\n F2 value of i = $i \n";
};
echo "\n Printing Value Of i START \n";
$fu = static function($count) use (&$fu, $i, $f1, $f2) {
    echo "$i \n";
    while($count < 10) {
        ++$count;
        $f1();
        $f2();
        $fu($count);
    }
};
$fu($count);
echo "\n Printing Value Of i END \n";
function calculate($tax) {
    $total = 100;
    $callback = function($q, $p) use ($tax, $total) {
        echo "Quantity = ".$q."\n";
        echo "Product = ".$p."\n";
        echo "Tax = ".$tax."\n";
    };
    return $callback;
}
(calculate(100))(10,20);
global $calculate;
echo "calculate = ".$calculate;
$a = 10;
echo "\n";
echo " ========== Calling globalVariableCheck ========= ";
echo "\n";
globalVariableCheck();
function globalVariableCheck() {
    echo $a; // cannot use variable $a defined outside because inside the function its used in local scope
    echo "\n";
    global $a;f
    echo $a;
}
echo "\n";
(function() {
    echo "Nice";
//		echo $a; Notice of undefined variable $a unless we use 'use' keyword as in above calculate method
})();

echo "\n Attempting to bind an object to a static anonymous function \n";
$func = static function() {
    // function body
};
// Closure::bind is the static version of bindTo
// Closure::fromCallable will return an anonymous function from callable or normal php function. It can now be used with bindTo or ::bind to invoke it in a different scope and with different object.
$func = $func->bindTo(new StdClass); // Generates warning Cannot bind an instance to a static closure
//$func();

echo "\n Closure::Bind \n";
class A {
    private static $sfoo = 1;
    private $ifoo = 2;
}
class B {
    private static $sfoo = 1;
    private $ifoo = 2;
}
$cl1 = static function() {
    return A::$sfoo; // here A is not required to be passed inside 'use' its still automatically available inside functions(lambda)
};
$cl2 = function() {
    return $this->ifoo;
};

/*
 * Bind is static version of bindTo
 * */
// 7.0.0	newscope( Second Argument ) can not be (an object of) an internal class anymore, what was possible prior to this version.
$bcl1 = Closure::bind($cl1, null, 'A');
$bcl12 = Closure::bind($cl1, new A, 'A'); // Generates waring Cannot bind an instance to a static closure
$bcl13 = Closure::bind($cl1, new A, 'B'); // Generates waring Cannot bind an instance to a static closure
$bcl14 = Closure::bind($cl1, null, 'stdClass'); // Warning:  Cannot bind closure to scope of internal class stdClass

$bcl2 = Closure::bind($cl2, new A(), 'A');
$bcl22 = Closure::bind($cl2, new A(), 'B'); // generates warning that accessing $ifoo which is a private member of A is not allowed . This happens because we have bind $cl2 to new A() but scope is B so accessing anything private to A from outside A will generate error. Here $this is new A()
// Following line generates error because we have not bind $cl2 to any object but its scope is defined as B . If object is specified then its scope is automatically defined as its class but if only class is specified then its object is not automatically bound.
$bcl23 = Closure::bind($cl2, null, 'B');
$bcl24 = Closure::bind($cl2, new stdClass(), 'stdClass'); // Warning:  Cannot bind closure to scope of internal class stdClass
echo "\n BCL1 \n";
echo $bcl1(). "\n";
//echo $bcl12(). "\n";
//echo $bcl13(). "\n";
//echo $bcl14(). "\n";

echo "\n BCL2 \n";
echo $bcl2(). "\n";
//echo $bcl22(). "\n";
//echo $bcl23(). "\n";
//echo $bcl24(). "\n";

/*
 * Bindto is same as closure::bind . Bindto is an object oriented way of binding whereas closure is static way
 * */

echo "\n Bind TO \n";
$bcl1 = $cl1 -> bindTo(null, 'A');
$bcl12 = $cl1 -> bindTo(new A, 'A'); // Generates waring Cannot bind an instance to a static closure
$bcl13 = $cl1 -> bindTo(new A, 'B'); // Generates waring Cannot bind an instance to a static closure
$bcl14 = $cl1 -> bindTo(null, 'stdClass'); // Warning:  Cannot bind closure to scope of internal class stdClass

$bcl2 = $cl2 -> bindTo(new A(), 'A');
$bcl22 = $cl2 -> bindTo(new A(), 'B'); // generates warning that accessing $ifoo which is a private member of A is not allowed . This happens because we have bind $cl2 to new A() but scope is B so accessing anything private to A from outside A will generate error. Here $this is new A()
// Following line generates error because we have not bind $cl2 to any object but its scope is defined as B . If object is specified then its scope is automatically defined as its class but if only class is specified then its object is not automatically bound.
$bcl23 = $cl2 -> bindTo(null, 'B');
$bcl24 = $cl2 -> bindTo(new stdClass(), 'stdClass'); // Warning:  Cannot bind closure to scope of internal class stdClass
echo "\n BCL1 \n";
echo $bcl1(). "\n";
//echo $bcl12(). "\n";
//echo $bcl13(). "\n";
//echo $bcl14(). "\n";

echo "\n BCL2 \n";
echo $bcl2(). "\n";
//echo $bcl22(). "\n";
//echo $bcl23(). "\n";
//echo $bcl24(). "\n";
echo "\n Closure::fromCallable() \n";
// All the above methods work only on lambda functions and not on normal function(Callable) so in order to convert normal functions to lambda functions we use Closure::fromCallable()
// ONLY AVAILABLE FOR PHP VERSIONS >= 7.1.0
class callableClass {
    private $v = 30;
}
function convertMeToLambda() {
    return $this -> v;
}
//$closure = Closure::fromCallable("convertMeToLambda");
//echo "\n";
//echo ($closure -> bindTo(new callableClass))();
echo "\n Closure Call \n ";
// this will not store the call reference to the object but will directly call it on the new object.
// We cannot pass the class scope as in bind and bindto
class closureCall {
    public $c = 30;
}
$c = function($arg) {
    return $arg + $this -> c;
};

echo $c -> call(new closureCall(), 40);


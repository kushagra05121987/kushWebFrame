<?php
/**
 * Strict types can be specified in declare. In PHP 7, a new feature, Scalar type declarations, has been introduced. Scalar type declaration has two options −
coercive - coercive is default mode and need not to be specified.
strict - strict mode has to explicitly hinted.

 */
/**
 * Scalar type declarations.
 * Scalar type declarations come in two flavours: coercive (default) and strict. The following types for parameters can now be enforced (either coercively or strictly): strings (string), integers (int), floating-point numbers (float), and booleans (bool). They augment the other types introduced in PHP 5: class names, interfaces, array and callable.
 *
 * Type declarations allow functions to require that parameters are of a certain type at call time. If the given value is of the incorrect type, then an error is generated: in PHP 5, this will be a recoverable fatal error, while PHP 7 will throw a TypeError exception.
 * '...' can be used to pass multiple number of arguments
 * Scalar Declaration can be done in two modes Coercive and Strict as follows:
 */
// declare(strict_types=1);
// // you can use this:
//declare(ticks=1) {
    // entire script here
//}

// or you can use this:
//declare(ticks=1);
// entire script here

// Scalar types as of php 5
// Array, callable, class, implement
namespace CoerciveStrictBlock {
    echo "<pre>";
    function f1(int ...$arg) {
        print_r($arg);
    }
    f1(20, '30', 20); // with coercive mode 2nd argument is auto casted to integer but with strict mode it generates a php fatal error.
}
namespace {
    include_once "strict_mode_include.php"; // this will not work because declare statement works on per file basis which in this case is strict_mode_include.php so the constraint works only in that file even if its included in this file.
    function f3() {
        echo "\n Inside F3 \n";
    }
    function f4(callable $arg) {
        echo $arg();
        echo "\n Inside F4 \n";
    }
    function f2(int ...$arg) {
        print_r($arg);
        f4('f3');
//        f4('f10'); // Generates error as f4 is expecting a callable argument and not a string or any other thing
//        f4(20); // Generates same error as above because argument passed is integer and expected is callable
    }
    f2(20, '30', 20); // with coercive mode 2nd argument is auto casted to integer but with strict mode it generates a php fatal error.
    // Array
    echo "\n === Normal Array === \n";
    function arrayMethod($array) {
        print_r($array);
    }
    arrayMethod([1,2,3,4]);
    echo "\n === Array method with multiple arguments === \n";
    // Array Method with multiple arguments.
    function arrayMethod2(... $array) {
        print_r($array);
    }
    // Array method with single argument but multiple parameters
    arrayMethod2(1,2,3,4,5);
    function arrayMethod3($array) {
        print_r($array);
    }
    arrayMethod3(1,2,3,4,5);

    echo "\n === Array Scalar type declaration with only single argument === \n";
    function arrayDec(array $array) {
        print_r($array);
    }
    arrayDec([1,2,3,4]);
//    arrayDec(12);// Generates error as expected type in method declaration is array
    echo "\n === Array Scalar type declaration with only multiple arguments === \n";
    function arrayDec2(array ...$array) { // function expects multiple inputs here and every input should be an array
        print_r($array);
    }
    arrayDec2([1,2,3,4], array(20,12,30,23,34));
//    arrayDec(1,2); // Generates error as expected type is array
    echo "\n === Integer Scalar type declaration with only single argument === \n";
    function IntegerDec(int $args) { // function expects multiple inputs here and every input should be an integer
        print_r($args);
        echo "\n";
    }
//    IntegerDec([1,2,3,4], array(20,12,30,23,34)); // Generates Error as expected argument is integer but given array
    IntegerDec(1);
    IntegerDec(10,20);
    echo "\n === Integer Scalar type declaration with multiple arguments === \n";
    function IntegerDec2(int ... $args) { // function expects multiple inputs here and every input should be an array
        print_r($args);
        echo "\n";
    }
    IntegerDec2(1,2,3,4,5);
//    IntegerDec2([1,2,3,4,5], [20,30,40]); // Generates error as expected type is integer and given array
    // Class Names
    echo "\n === Class Name argument with no type === \n";
    Class Passable {}
    function classDec($obj) {
        print_r(get_class($obj));
        echo "\n";
    }
    classDec(new Passable);
//    classDec(new Anchor()); // Generates error as class not found
    classDec(new stdClass);

    echo "\n === Class Name Scalar type argument with only one argument === \n";
    function classDec2(Passable $obj) {
        echo " \n Inside Class Declaration Of Passable \n ";
        print_r(get_class($obj));
        echo "\n";
    }
    classDec2(new Passable);
//    classDec2(new stdClass); // Generates error as expected class is Passable
    echo "\n === Class Name Scalar type argument with only one argument and no type declaration === \n";
    function classDec3(... $obj) {
        echo " \n Inside Class Declaration Of Passable \n ";
        print_r(get_class($obj));
        echo "\n";
    }
    classDec3(new Passable);
    classDec3(new stdClass);

    echo "\n === Class Name Scalar type argument with only one argument and no type declaration === \n";
    function classDec4(... $obj) {
        echo " \n Inside Class Declaration Of Passable \n ";
        print_r(get_class($obj));
        echo "\n";
    }
    classDec4(new Passable);
    classDec4(new stdClass);

    echo "\n === Class Name Scalar type argument with multiple arguments === \n";
    function classDec5(Passable ... $obj) {
        echo " \n Inside Class Declaration Of Passable \n ";
        array_map(function($value) {
            print_r(get_class($value));
            echo "\n";
        }, $obj);
        echo "\n";
    }
    classDec5(new Passable, new Passable);
//    classDec5(new stdClass); // Generates error because the expected type is passable

    // Interfaces
    interface passMeInterface {}

    function interDec($i) {
        echo "Class Implements";
        // class_implements gives the interfaces which are implemented by the given class object or interface
        // also can be used to autoload the class using __autoload method if the class is not found by passing second argument as true.
        /**
         * interface foo { }
        class bar implements foo {}

        print_r(class_implements(new bar));

        // since PHP 5.1.0 you may also specify the parameter as a string
        print_r(class_implements('bar'));


        function __autoload($class_name) {
        require_once $class_name . '.php';
        }

        // use __autoload to load the 'not_loaded' class
        print_r(class_implements('not_loaded', true));
         */
        print_r(class_implements($i));
        echo "\n";
    }
    interDec(new stdClass());

    function interDec2(passMeInterface $i) {
        print_r(class_implements($i));
        echo "\n";
    }
//    interDec2(new stdClass()); // Generates error because method is expecting object of class implementing passMeInterface

    class useInterface implements passMeInterface {}
    interDec2(new useInterface());

    class anotherClass implements passMeInterface {}
    interDec2(new anotherClass());
    echo "\n Multiple Interfaces With type passMeInterface \n";
    function interDec3(passMeInterface ... $i) {
        array_map(function($value) {
            print_r(class_implements($value));
            echo "\n";
        }, $i);
        echo "\n";
    }
    interDec3(new useInterface(), new anotherClass());

    // New scalar types in php7 are strings (string), integers (int), floating-point numbers (float), and booleans (bool)
    echo "\n === Method expecting string but with no type declaration === \n";
    function stringDec($str) {
        echo "$str";
        echo "\n";
    }
    stringDec(10);
    stringDec('20');
    stringDec(true); // this one first gets converted to integer and the casted to string

    echo "\n String with multiple arguments \n";
    function stringDec2(... $str) {
        print_r($str);
        echo "\n";
    }
    stringDec2(10,'20');

    echo "\n Scalar type as string with single argument \n";
    function stringDec3(string $str) {
        print_r($str);
        echo "\n";
    }
    stringDec3(10,'20');
    stringDec3(40);

    echo "\n Scalar type as string with single arguments \n";
    function stringDec4(string $str) {
        print_r($str);
        echo "\n";
    }
    stringDec4(10,'20');
    stringDec4('40');

    echo "\n Scalar type as string with multiple arguments \n";
    function stringDec5(string ... $str) {
        print_r($str);
        echo "\n";
    }
    stringDec5(10,'20'); // Generate Error as expected type is string
    stringDec5('40');


    // Boolean
    echo "\n === Method expecting boolean but with no type declaration === \n";
    function booleanDec($bool) {
        echo "$bool";
        echo "\n";
    }
    booleanDec(10);
    booleanDec('20');
    booleanDec(true);

    echo "\n boolean with multiple arguments \n";
    function booleanDec2(... $bool) {
        print_r($bool);
        echo "\n";
    }
    booleanDec2(10,'20', true);

    echo "\n Scalar type as boolean with single argument \n";
    function booleanDec3(bool $bool) {
        print_r($bool);
        echo "\n";
    }

    // calling a method with more than the declared arguments is possible . In this case the extra arguments are ignored.
    booleanDec3(10,'20');// Generates error as expected type is boolean and integer given
    booleanDec3(40); // Generates error as expected type is boolean and integer given
    booleanDec3(true);

    echo "\n Scalar type as boolean with multiple arguments \n";
    function booleanDec5(bool ... $bool) {
        print_r($bool);
        echo "\n";
    }
//    booleanDec5(10,'20'); // Generates error as expected type is boolean and integer given
    booleanDec5('40', 20, true, "40.4646");

    // Float
    echo "\n === Method expecting Float but with no type declaration === \n";
    function floatDec($float) {
        echo "$float";
        echo "\n";
    }
    floatDec(10.3459);
    floatDec('20');
    floatDec(true);

    echo "\n float with multiple arguments \n";
    function floatDec2(... $float) {
        print_r($float);
        echo "\n";
    }
    floatDec2(10,'20.4949', true);

    echo "\n Scalar type as float with single argument \n";
    function floatDec3(float $float) {
        print_r($float);
        echo "\n";
    }
    floatDec3(10.64646);
    floatDec3(10.64646, 30.33);
    floatDec3(10,'20');
    floatDec3('40');
    floatDec3(40);
    floatDec3(false);

    echo "\n Scalar type as float with multiple arguments \n";
    function floatDec5(float ... $float) {
        print_r($float);
        echo "\n";
    }
    floatDec5(10,'20.466', 20.333);
    floatDec5('40');
    floatDec5(true);

    /*
     * Return type declarations. The same types are available for return type declarations as are available for argument type declarations i.e. Integer(int), Strings(string), Booleans(bool), Array(array), Class Name(classname object), Interface(class object implementing implement), Float(float), callables (for functions)
     */
    echo "\n ====== Return Type ======= \n";
    // Integer
    echo "\n Integer \n";
//    function returnInt() : int {
//       return "string"; // Generates Error as return type is int and given string. In this case string is not type casted to integer because there is no numeric content in the string.
//    }
    function returnInt5() : int {
        return "30string"; // Generates a warning of A Non well formed numeric value found.
    }
    function returnInt2() : int {
        return "20";
    }
    function returnInt3() : int {
        return 20.444;
    }
    function returnInt4() : int {
        return true;
    }
//    var_dump(returnInt());
    var_dump(returnInt2());
    var_dump(returnInt3());
    var_dump(returnInt4());
    var_dump(returnInt5());

    // Strings
    echo "\n Strings \n";
    function returnString() : string {
        return "20";
    }
    function returnString2() : string {
        return 20; // Automatically type converted to string but the reverse was not true in which string was not auto converted to int
    }

    var_dump(returnString());
    var_dump(returnString2());
    // Float
    echo "\n Float \n";
    function returnFloat() : float {
        return "20";
    }
    function returnFloat2() : float {
        return 20;
    }
    function returnFloat3() : float {
        return 20.45;
    }
    function returnFloat4() : float {
        return true;
    }
    var_dump(returnFloat());
    var_dump(returnFloat2());
    var_dump(returnFloat3());
    var_dump(returnFloat4());

    // Boolean
    echo "\n Boolean \n";
    function returnBoolean() : bool {
        return "20";
    }
    function returnBoolean2() : bool {
        return 20;
    }
    function returnBoolean3() : bool {
        return 20.45;
    }
    function returnBoolean4() : bool {
        return true;
    }
    var_dump(returnBoolean());
    var_dump(returnBoolean2());
    var_dump(returnBoolean3());
    var_dump(returnBoolean4());

    // Array
    echo "\n Array \n";
    function returnArray() : array {
        return [1,2,3,4];
    }

//    function returnArray2() : array {
//        return 12; // Generates error because the expected type is array and returned is integer
//    }
    var_dump(returnArray());
//    var_dump(returnArray2());
    // Class
    echo "\n Class \n";
    function returnClass() : stdClass {
        return new stdClass();
    }
    echo PHP_EOL;
    echo "Return with extended class";
    echo PHP_EOL;
    declare(strict_type=1) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        class a {}; class b extends a {};
        function returnClass2() : a {
            return new b();
        }
        var_dump(returnClass());
        var_dump(returnClass2());
    };

    echo "<hr />";

    // Interface
    echo "\n Interface \n";
    interface interc {}; class c extends a implements interc {};
    function returnInterface() : interc {
        return new c;
    }
    class d extends c {}
    function returnInterface2() : interc {
        return new d;
    }
    var_dump(returnInterface());
    var_dump(returnInterface2());

    echo "\n Accept type of Extending Class \n";
    class xs {}; class xd extends xs {};
    class df {public function __construct(xs $instance){echo get_class($instance);}}
    new df(new xd);
    // Callable
    echo "\n Callable \n";
    function callableFunction() { echo "\n Printing inside callable function \n "; return 0;}
    function callIt() : callable {
        return 'callableFunction';
    }
//    function callIt2() : callable {
//        return 'callableFunction2'; // Gives error because the function does not exist
//    }
    function callIt3() : callable {
        return "array_map";
    }
    var_dump(callIt());
    var_dump(callIt3());
//    var_dump(callIt2());
    /*
 * PHP has support for variable-length argument lists in user-defined functions. This is implemented using the ... token in PHP 5.6 and later, and using the func_num_args(), func_get_arg(), and func_get_args() functions in PHP 5.5 and earlier.
 * The '...' is not only used for accepting multiple number of arguments but also for sending multiple number of arguments to a function which is accepting different number of arguments.
 */
    echo "\n Another use of ...\n";
    function add($a, $b) : float {
        return $a + $b;
    }
    var_dump(add(20,12));
    var_dump(add(...[20,12]));
    var_dump(add(...[20,12, 30]));

    // Null coalescing operator
    echo "\n ======= Null coalescing operator ========= \n ";
    // This operator ?? makes use of the method isset() internally to return the value that is not null.
    // This works by making a check on first argument that if it is null similar to isset($x) ? $x:$y; . So isset($x) ? $x is replaced only by $x ??
    // similar to ?? we had ?: operator which checks for the truthiness of the left expression instead of it being isset. So
    // ?? is equivalent to isset($_GET['username']) ? $_GET['username'] : 'default';
    // and ?: is equivalent to $_GET['username'] ? $_GET['username'] : 'default';
    echo $fit ?? "nothing";
    // or we can store it also
    $return = $fit ?? "nothing";

    // Coalescing can be chained: this will return the first
    // defined value out of $_GET['user'], $_POST['user'], and
    // 'nobody'.
    echo $_GET['user'] ?? $_POST['user'] ?? 'nobody';

    // Spaceship operator
    echo "\n ============ Spaceship operator ============ \n";
    //The spaceship operator is used for comparing two expressions. It returns -1, 0 or 1 when $a is respectively less than, equal to, or greater than $b. This combines three conditions into one
    $a = 30;
    $b = -20;
    var_dump($a <=> $b);

    echo "\n =========== Constant arrays using define() ========= \n";
    // Constants can have array in them .
    define("constant", array(1,2,3,4,5,6));
    const c = array("one" => 2);
    define("constants", array()); // define constants cannot have arrays . This only works in php 7
    const ca = array(); // cons can have arrays in them  from start
    // constant names cannot have expression in them but define names can have
    print_r(c);

    echo "\n Anonymous classes \n";
    interface Logger {
        public function log(string $msg);
    }

    class Application {
        private $logger;

        public function getLogger(): Logger {
            return $this->logger;
        }

        public function setLogger(Logger $logger) {
            $this->logger = $logger;
        }
    }

    $app = new Application;
    $app->setLogger(new class implements Logger {
        public function log(string $msg) {
            echo $msg;
        }
    });

    var_dump($app->getLogger());

    echo "\n Filtered unserialize() \n";
    class fooBar {
        public $v = 10;
        public static $s = 2;
        public function f() {}
    }
    class barFoo {
        public $x = 10;
        public static $g = 2;
        public function h() {}
    }
    $obj = new fooBar();
    function createSerialization($obj) {
        return [
            // by this we control which classes are allowed to be unserialized
            unserialize($obj),
            unserialize($obj, array("allowed_classes" => false)),
            unserialize($obj, array("allowed_classes" => array("barFoo", "parry")))
        ];
    }
    $serialize = serialize($obj);
    echo "\n $serialize\n";
    print_r(createSerialization($serialize));
}


namespace functionSpace {
    function f1() {echo "\n F1 \n";}
    function f2() {echo "\n F2 \n";}
    function f3() {echo "\n F3 \n";}
}
namespace constantSpace {
    /*
     * Two namespaces can have same function name even in same file
     * */
    function f1() {echo "\n F1 \n";}
    function f2() {echo "\n F2 \n";}
    function f3() {echo "\n F3 \n";}
    const c1 = 1;
    const c2 = 2;
    const c3 = 3;
}
namespace classSpace {
    class A {}
    class B {}
    class C {}
}

namespace {
    echo "\n Group use declarations \n";
    use function functionSpace\f1;
    use function functionSpace\f2 as f2G;
    use function functionSpace\f3 as f3G;
    f1();
    f2G();
    f3G();

    use const constantSpace\c1;
    use const constantSpace\c2;
    use const constantSpace\c3;
    echo "\n".c1."\n";
    echo "\n".c2."\n";
    echo "\n".c3."\n";

    use classSpace\A as aG;
    use classSpace\B as bG;
    use classSpace\C as cG;
    new aG;
    new bG;
    new cG;

    // Above is the individual picking of functions, constants and classes. As of php7 we can use group use statement as follows
    use function functionSpace\{f1 as f1G2,f2 as f2G2,f3 as f3G2};
    f1G2();
    f2G2();
    f3G2();

    use const constantSpace\{c1 as c1G, c2 as c2G, c3 as c3G};
    echo "\n".c1G."\n";
    echo "\n".c2G."\n";
    echo "\n".c3G."\n";

    use classSpace\{A as Ag2, B as Bg2, C as Cg2};
    new Ag2;
    new Bg2;
    new Cg2;
    echo "\nInteger division with intdiv() \n";
    // function for dividing operands. Gives Whole number quotient.
    var_dump(intdiv(10, 3));
    var_dump(intdiv(8, 3));

    echo "\n Session options \n";
    /*
     * session_start() now accepts an array of options that override the session configuration directives normally set in php.ini.

These options have also been expanded to support session.lazy_write, which is on by default and causes PHP to only overwrite any session file if the session data has changed, and read_and_close, which is an option that can only be passed to session_start() to indicate that the session data should be read and then the session should immediately be closed unchanged.

For example, to set session.cache_limiter to private and immediately close the session after reading it:

<?php
session_start([
    'cache_limiter' => 'private',
    'read_and_close' => true,
    'cookie_lifetime' => 86400,
]);
?>
     * */
    echo "\n preg_replace_callback_array \n ";
    // Perform a regular expression search and replace using callbacks
    // Now we can use this to create a form validator instead of writing our own if and else statements
    /*
     * patterns_and_callbacks
An associative array mapping patterns (keys) to callbacks (values).

subject
The string or an array with strings to search and replace.

limit
The maximum possible replacements for each pattern in each subject string. Defaults to -1 (no limit).

count
If specified, this variable will be filled with the number of replacements done.
     * */
 /*
  * Return Values ¶

preg_replace_callback_array() returns an array if the subject parameter is an array, or a string otherwise. On errors the return value is NULL

If matches are found, the new subject will be returned, otherwise subject will be returned unchanged.
  * */
    $subject = 'Aaaaaa Bbba'; // Function will first match all continuous characters matching as defined by first regex , then will match the second continuous pattern as defined by regex then again if any on the defined patterns are found it will match them and make a call to callback defined. So the output will be as follows
    /*
Array
(
    [0] => Aaaaaa
)
6 matches for "a" found
Array
(
    [0] => a
)
1 matches for "a" found
Array
(
    [0] => Bbb
)
3 matches for "b" found
     * */
    // This function can also be used to match the values inside array
    // as the callbacks return the value the original string is replaced.
    echo "\n Replacement using string \n";
    echo "\n Preg Replace Callback\n";
    // if it will not match the expression then also the callback will be executed and the string returned will be prepended.
    var_dump(preg_replace_callback('~[A-Za]+~', function($matches) {
        return '%';
    }, $subject, 4, $replaced));
    echo "\n replaced => $replaced \n";
    echo "\n Preg Replace Callback Array \n";
    var_dump(preg_replace_callback_array(
        [
            '~[A]+~' => function ($match) { // This keeps on matching till it is able to find matches as defined by regex
            print_r($match);
                echo strlen($match[0]), ' matches for "a" found inside first', PHP_EOL;
                return "$";
            },
            '~[a]+~i' => function ($match) { // This keeps on matching till it is able to find matches as defined by regex
                print_r($match);
                echo strlen($match[0]), ' matches for "a" found inside second', PHP_EOL;
                return "^";
            },
            '~[b]+~i' => function ($match) { // This keeps on matching till it is able to find matches as defined by regexs
                print_r($match);
                echo strlen($match[0]), ' matches for "b" found', PHP_EOL;
                return "#";
            }
        ],
        $subject, 5, $c
    ));
    echo "\nCount $c\n";
    echo "\n Replacement using array \n";
    $subject = array(
        'Aaaaaa', 'Bbbaab'
    );
    var_dump(preg_replace_callback_array(
        [
            '~[a]+~i' => function ($match) { // This keeps on matching till it is able to find matches as defined by regex
                print_r($match);
                echo strlen($match[0]), ' matches for "a" found first', PHP_EOL;
                return "$";
            },
            '~[a]+~i' => function ($match) { // This keeps on matching till it is able to find matches as defined by regex
                print_r($match);
                echo strlen($match[0]), ' matches for "a" found second ', PHP_EOL;
                return "^";
            },
            '~[b]+~i' => function ($match) { // This keeps on matching till it is able to find matches as defined by regexs
                print_r($match);
                echo strlen($match[0]), ' matches for "b" found', PHP_EOL;
                return "#";
            }
        ],
        $subject, 1, $c
    ));
    echo "\nCount $c\n";
    // Limit argument limits the replacement per string to the value given. So if limit is one then if pattern occurs twice in or more in a string then it will be replaced only once. For arrays every element denotes a single string.
    echo "\n CSPRNG Functions ---  random_bytes() and random_int() \n";
    var_dump(rand(10, 20));
    // Generates an arbitrary length string of cryptographic random bytes that are suitable for cryptographic use, such as when generating salts, keys or initialization vectors.
    var_dump(random_bytes(10));
    // Generates cryptographic random integers that are suitable for use where unbiased results are critical, such as when shuffling a deck of cards for a poker game.
    var_dump(random_int(100, 999));
    var_dump(random_int(-1000, 0));

    echo "\n Previously, list() was not guaranteed to operate correctly with objects implementing ArrayAccess. This has been fixed. \n";
    echo "\n The ArrayAccess implement \n";
    /*
     * Interface to provide accessing objects as arrays.
     * ArrayAccess {
        # Methods
        abstract public boolean offsetExists ( mixed $offset )
        abstract public mixed offsetGet ( mixed $offset )
        abstract public void offsetSet ( mixed $offset , mixed $value )
        abstract public void offsetUnset ( mixed $offset )
    }
     * */
    class obj implements ArrayAccess {
        private $container = array();

        public function __construct() {
            $this->container = array(
                "one"   => 1,
                "two"   => 2,
                "three" => 3,
            );
        }

        public function offsetSet($offset, $value) {
            if (is_null($offset)) {
                $this->container[] = $value;
            } else {
                $this->container[$offset] = $value;
            }
        }

        public function offsetExists($offset) {
            return isset($this->container[$offset]);
        }

        public function offsetUnset($offset) {
            unset($this->container[$offset]);
        }

        public function offsetGet($offset) {
            return isset($this->container[$offset]) ? $this->container[$offset] : null;
        }
    }

    $obj = new obj;

    var_dump(isset($obj["two"]));
    var_dump($obj["two"]);
    unset($obj["two"]);
    var_dump(isset($obj["two"]));
    $obj["two"] = "A value";
    var_dump($obj["two"]);
    $obj[] = 'Append 1';
    $obj[] = 'Append 2';
    $obj[] = 'Append 3';
    $obj['path'] = array("path1" => "first path", "path 2" => "second path");
    print_r($obj);
    echo "\n PAth \n";
    print_r($obj['path.path1']);
    print_r($obj['path']['path1']);

    // ArrayObject is builtin class that uses ArrayAccess. Which has more methods to use objects as arrays.

    echo "\n =========== Generator Return Expressions ========== \n";
    /*
		This feature builds upon the generator functionality introduced into PHP 5.5. It enables for a return statement to be used within a generator to enable for a final expression to be returned (return by reference is not allowed). This value can be fetched using the new Generator::getReturn() method, which may only be used once the generator has finished yielding values.
    */
    $gen = (function() {
	    yield 1;
	    yield 2;

	    return 3;
	})();
	$gen1 = (function() {
	    yield 1;
	    yield 2;

	    return 3;
	})();
	$genWhile = (function() {
	    $count = 0;
	    while($count < 10) {
	    	yield $count;
	    	++$count;
	    }
	    // return $count;
	})();
	echo PHP_EOL;
	echo "======= GEN ==========";
	echo PHP_EOL;
	// $gen;
	// $gen;
	// $gen;
	// $gen -> getReturn(); //Uncaught Exception: Cannot get return value of a generator that hasn't returned. If called before actually using the function.
	foreach ($gen as $val) {
	    echo $val, PHP_EOL;
	}
	echo "Get Return => ".$gen->getReturn(), PHP_EOL; // gets the value returned by return statement after `yeilding` is complete
	echo PHP_EOL;
	echo "======= GEN2 ==========";
	echo PHP_EOL;
	foreach ($gen1 as $val) {
	    echo $val, PHP_EOL;
	}
	echo "Get Return => ".$gen1->getReturn(), PHP_EOL; // gets the value returned by return statement after `yeilding` is complete
	echo PHP_EOL;
	echo "======= GEN While ==========";
	echo PHP_EOL;
	foreach ($genWhile as $val) {
	    echo $val, PHP_EOL;
	}
	echo "Get Return => ".$genWhile->getReturn(), PHP_EOL; 

	echo "\n =========== Generator delegation =========== \n";
	function gen() {
	    yield 1;
	    yield 2;
	    yield from gen2();
	}

	function gen2() {
	    yield 3;
	    yield 4;
	}

	foreach (gen() as $val) {
	    echo $val, PHP_EOL;
	}


	echo "\n AS Of PHP 7.1 we can have visibilty modifiers even on class constants defined using const";
}
<?php
/*
	PHP Reflection class can give a good amount of information regarding a class or an object. This class is seldomly used when we need some very high processing of a class information. Most of the issues are resolved by most of the following function
*/
declare(strict_types=1);

class a {}
class b extends a {}
interface ain {}
interface bin {}
class testClass extends b implements ain,bin{
	const contantVar = 300;
	public static $statVar = 10;
	private static $statVarPri = 20;
	public $norVar = 30;
	private $noVarPri = 40;
	private static $br = null;
	private static $hr = null;
	public function __construct() {
		self::$br = $this -> br();
		self::$hr = $this -> hr();
		$this -> methodCall();
	}
	public static function statMeth() {
		echo "Static Method";
	}
	private static function statMethPri() {
		echo "Static method Private";
	}
	public function method() {
		echo "Method public";
	}
	private function methodPri() {
		echo "Method Private";
	}
	private static function br() {
		echo "<br />";
	}
	private static function hr() {
		echo "<hr />";
	}
	private function methodCall() {
		echo "<pre>";
		echo ini_get('disable_functions');
		self::hr();
		print_r(get_defined_functions());
		self::hr();
		print_r(get_class_methods($this));
		self::hr();
		print_r(get_class_methods('self'));
		self::hr();
		print_r(get_class_methods('testClass'));
		self::hr();
		print_r(get_object_vars($this)); // returns private variables aswell but no static
		// self::$hr;
		// print_r(get_class_vars($this)); // takes only string no object
		self::hr();
		print_r(get_class_vars("testClass")); // returns private and public variables with static variables
		self::hr();
		echo "==== PARENT CLASS =====";
		var_dump(get_parent_class()); // returns empty when no parent class is extended
		self::hr();
		echo " ===== IS A ===== ";
		self::br();
		var_dump(is_a($this, "testClass")); // is_a check if this particular object is of the class passed in argument or of any of its parent class
		self::br();
		var_dump(is_a($this, "b"));
		self::br();
		var_dump(is_a($this, "a"));
		self::br();
		echo " ===== INSTANCE OF ===== ";
		self::br();
		var_dump($this instanceof $this);
		self::br();
		$className = "testClass";
		var_dump($this instanceof $className);
		// instanceof wont work with interfaces but is_a does

		// self::br();
		// $interObj = new ain();
		// var_dump($this instanceof $interObj);

		self::br();
		$className = "b";
		var_dump($this instanceof $className);
		self::br();
		$className = "a";
		var_dump($this instanceof $className);
		self::br();
		echo " ===== IS SUBCLASS ==== ";
		self::br();
		var_dump(is_subclass_of($this, "b"));
		self::br();
		var_dump(is_subclass_of($this, "a"));
		self::br();
		var_dump(is_subclass_of($this, "ain"));
		self::br();
		var_dump(is_subclass_of($this, "bin"));
		self::br();
		echo " ==== PROPERTY EXISTS ==== ";
		self::br();
		var_dump(property_exists($this, "norVar"));
		self::br();
		var_dump(property_exists("testClass", "norVar"));
		self::br();
		echo " ==== Class Implements ==== ";
		self::br();
		var_dump(class_implements("testClass"));
		self::br();
		echo " ===== Object Hash =====";
		self::br();
		var_dump(spl_object_hash($this));
		$id = spl_object_hash($this);
		$storage[$id] = $this;
		self::br();
		echo " ===== IS OBJECT =====";
		self::br();
		var_dump(is_object($this)); // is_object has other forms for other data type example -> is_array, is_int, is_float, is_bool,
		// ,is_string, is_scalar, is_resource, etc, which in turn gets generalized to is_a for object matching
		self::br();
		echo " ===== IS CALLABLE =====";
		self::br();
		var_dump(is_callable(array($this, "methodCall"), true, $callable));
		self::br();
		var_dump(is_callable("methodCall", true, $callable));
		self::br();
		var_dump(is_callable(array($this, "methodCall"), false, $callable));
		self::br();
		var_dump(is_callable("methodCall", false, $callable));
		self::br();
		echo "</pre>";
	}
}

$tc = new testClass;
$br = function() {
	echo "<br />";
};
$br();
echo " ====== IS A OUTSIDE ===== ";
$br();
var_dump(is_a($tc, "testClass"));
$br();
print_r(get_object_vars($tc)); // returns only public variables but no static
$br();
print_r(get_class_vars("testClass")); // returns only public variables and static variables
$br();
function useDef() {
	echo 'Inside user Def function';
}
function argCheck() {

}
// executed when script ends or exit or die is called
register_shutdown_function(function() {
	echo "Script Ending";
});
// die("Dying");
// exit("Exiting");
echo "<hr />";
echo "<hr />";
echo "<pre>";
$br();

// Following functions work the same inside a class also
echo "====== Declared Stuff ======";
$br();
echo " ==== Declared Classes ==== ";
$br();
print_r(get_declared_classes());
$br();
echo " ==== Declared Interfaces ==== ";
$br();
print_r(get_declared_interfaces());
$br();
echo " ==== Declared Functions ==== ";
$br();
print_r(get_defined_functions()); 
$br();
echo " ==== Declared Constants ==== ";
$br();
var_dump(get_defined_constants());
$br();
echo " ==== Interface Exists ==== ";
$br();
var_dump(interface_exists("ain"));
$br();
echo " ==== Class Exists ==== ";
$br();
var_dump(class_exists("testClass"));

$br();
echo "==== PROPERTY EXISTS OUTSIDE ===== ";
$br();
var_dump(property_exists($tc, "noVarPri"));
$br();
var_dump(property_exists("testClass", "noVarPri"));

$br();
/*
*A tick is an event that occurs for every N low-level tickable statements executed by the parser within the declare block. The value for N is specified using ticks=N within the declare block's directive section.
*/
// The declare construct is used to set execution directives for a block of code
// declare(ticks=1);

// A function called on each tick event
function tick_handler()
{	echo "<br />";
    echo "tick_handler() called\n";
    echo "<br />";
}
// Every statement below fires a new tick
register_tick_function('tick_handler');

$a = 1;

if ($a > 0) {
	new StdClass(); // creates a new tick as well
    $a += 2;
    print($a);
}
// tells that code after this declare block will use ISO-8859-1 encoding
// declare(encoding='ISO-8859-1');
// echo "Script is encoded using ISO-8859-1";

/**
*
Strict typing ¶

By default, PHP will coerce values of the wrong type into the expected scalar type if possible. For example, a function that is given an integer for a parameter that expects a string will get a variable of type string.

It is possible to enable strict mode on a per-file basis. In strict mode, only a variable of exact type of the type declaration will be accepted, or a TypeError will be thrown. The only exception to this rule is that an integer may be given to a function expecting a float. Function calls from within internal functions will not be affected by the strict_types declaration.

To enable strict mode, the declare statement is used with the strict_types declaration:

Caution
Enabling strict mode will also affect return type declarations.
Note:
Strict typing applies to function calls made from within the file with strict typing enabled, not to the functions declared within that file. If a file without strict typing enabled makes a call to a function that was defined in a file with strict typing, the caller's preference (weak typing) will be respected, and the value will be coerced.
Note:
Strict typing is only defined for scalar type declarations, and as such, requires PHP 7.0.0 or later, as scalar type declarations were added in that version.
*/

// generates error with strict mode on with declare because function expects integer but given float which can't be type casted 
// function sum(int  $a, int $b) {
//     return $a + $b;
// }
// var_dump(sum(1, 2));
// var_dump(sum(1.5, 2.5));

// doesnt generate error because int can be type casted to float
function sum(float  $a, float $b) {
    return $a + $b;
}
// function sum(float  $a, float $b, float $c) {
//     return $a + $b + $c;
// }
var_dump(sum(1, 2));
var_dump(sum(1.5, 2.5));
// var_dump(sum(1, 2, 3));

$br();
echo " ===== Count Function ==== ";
$br();
function counter($a, $b) {
	return $a + $b;
}

echo "<br />==== Count 1===== <br />".count(counter(10,20))."<br />";

echo "<br />==== Count 2===== <br />".sizeof(counter(10,20))."<br />";

$br();
echo " ============ REFLECTION ============ ";
$br();
class reflectClass {
	const constants = 300;
	private $refObj = null;
	public function __construct() {
		$this -> refObj = new ReflectionClass(__CLASS__);
	}
	public function getReflection() {
		return $this -> refObj;
	}
}
$reflection = new reflectClass();
var_dump($reflection);
$coreReflectionClass = $reflection -> getReflection();
$br();
var_dump($coreReflectionClass);
$br();
var_dump($coreReflectionClass -> getConstants());
$br();
var_dump(__CLASS__);
$br();
var_dump(__FILE__);
$br();
var_dump(__LINE__);

$br();
echo " ====== CLASS ALIAS ====== ";
// returns the same class object and creats another alias for that
/**
the obvious reason why one would do this: the use keyword can only be used in the outmost scope, and is processed at compile-time, so you can't use Some\Class based on some condition, nor can it be block-scoped:

namespace Foo;
if (!extension_loaded('gd'))
{
    use Images\MagicImage as Image;
}
else
{
    use Images\GdImage as Image;
}
class ImageRenderer
{
    public function __construct(Image $img)
    {}
}
This won't work: though the use statements are in the outmost scope, these imports are, as I said before, performed at compile-time, not run-time. As an upshot, this code behaves as though it was written like so:

namespace Foo;
use Images\GdImage as Image;
use Images\MagicImage as Image;
Which will produce an error (2 class with the same alias...)
class_alias however, being a function that is called at run-time, so it can be block scoped, and can be used for conditional imports:

namespace Foo;
if (!extension_loaded('gd'))
{
    class_alias('Images\\MagicImage', 'Image');
}
else
{
    class_alias('Images\\GdImage','Image');
}
class ImageRenderer
{
    public function __construct(Image $img)
    {}
}
*/
$br();
class foo {public $var = 20;public function func() {}}
class_alias('foo', 'bar');
var_dump(new foo());
$br();
var_dump(new bar);
class_alias('bar', 'c');
var_dump(new c);
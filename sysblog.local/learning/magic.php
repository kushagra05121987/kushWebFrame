<?php
echo "<pre>";
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/4/18
 * Time: 12:18 AM
 */

//serialize() checks if your class has a function with the magic name __sleep(). If so, that function is executed prior to any serialization.
//__sleep();

///Conversely, unserialize() checks for the presence of a function with the magic name __wakeup(). If present, this function can reconstruct any resources that the object may have.

//The intended use of __wakeup() is to reestablish any database connections that may have been lost during serialization and perform other reinitialization tasks.

class Connection
{
    public $threshold = 300;
    protected $link;
    private $dsn, $username, $password;

    public function __construct($dsn, $username, $password)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    private function connect()
    {
//        $this->link = new PDO($this->dsn, $this->username, $this->password);
        $this->link = "connected";
    }

    public function __sleep()
    {
//         if the returned array contains instance properties then in the serialized string we get ClassNamePropertyName construct but if they are not instance properties then the elements returned will be Directly used.
//        O:10:"Connection":3:{s:15:"Connectiondsn";s:3:"dsn";s:20:"Connectionusername";s:4:"root";s:20:"Connectionpassword";s:4:"pass";}
//        return array('dsn', 'username', 'password');
         return array('dsnss', 'uuname');
//         above on serialization gives O:10:"Connection":2:{s:5:"dsnss";N;s:6:"uuname";N;}s:4:"pass";}
    }

    public function __wakeup()
    {
        $this->connect();
        return [1,3,4];
    }
}
// serialize gives both public and private properties but json_encode gives only public properties.
ini_set('unserialize_callback_func', function(...$args) {
    echo "\ninside unserialize callback\n";
    print_r($args);
}); // set your callback_function

echo "\n ==== serialized ====  \n";
$serialized = serialize(new Connection("dsn", "root", "pass"));
echo $serialized;
echo PHP_EOL;
echo "<br />";
// what ever is serialized will also unserialize and unserialize will never take into consideration what is returned from wake.
$unserialized = unserialize($serialized);
echo "\n un ---- serialized \n";
var_dump($unserialized);
echo "unserialized type";
var_dump(is_object($unserialized));
var_dump(get_object_vars($unserialized));
echo $unserialized -> threshold;

/// __toString() ¶
//public string __toString ( void )
//The __toString() method allows a class to decide how it will react when it is treated like a string. For example, what echo $obj; will print. This method must return a string, as otherwise a fatal E_RECOVERABLE_ERROR level error is emitted.

/**
 * __set() is run when writing data to inaccessible properties.

__get() is utilized for reading data from inaccessible properties.

__isset() is triggered by calling isset() or empty() on inaccessible properties.

__unset() is invoked when unset() is used on inaccessible properties.

 */

class PropertyTest
{
    /**  Location for overloaded data.  */
    private $data = array();

    /**  Overloading not used on declared properties.  */
    public $declared = 1;

    /**  Overloading only used on this when accessed outside the class.  */
    private $hidden = 2;

    public function __set($name, $value)
    {
        echo "Setting '$name' to '$value'\n";
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        echo "Getting '$name'\n";
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /**  As of PHP 5.1.0  */
    public function __isset($name)
    {
        echo "Is '$name' set?\n";
        return isset($this->data[$name]);
    }

    /**  As of PHP 5.1.0  */
    public function __unset($name)
    {
        echo "Unsetting '$name'\n";
        unset($this->data[$name]);
    }

    /**  Not a magic method, just here for example.  */
    public function getHidden()
    {
        return $this->hidden;
    }
}


echo "<pre>\n";

$obj = new PropertyTest;

$obj->a = 1;
echo $obj->a . "\n\n";

var_dump(isset($obj->a));
unset($obj->a);
var_dump(isset($obj->a));
echo "\n";

echo $obj->declared . "\n\n";

echo "Let's experiment with the private property named 'hidden':\n";
echo "Privates are visible inside the class, so __get() not used...\n";
echo $obj->getHidden() . "\n";
echo "Privates not visible outside of class, so __get() is used...\n";
echo $obj->hidden . "\n";

//void __clone ( void )
//Once the cloning is complete, if a __clone() method is defined, then the newly created object's __clone() method will be called, to allow any necessary properties that need to be changed.

class SubObject
{
    static $instances = 0;
    public $instance;

    public function __construct() {
        $this->instance = ++self::$instances;
    }

    public function __clone() {
        $this->instance = ++self::$instances;
    }
}

class MyCloneable
{
    public $object1;
    public $object2;

    function __clone()
    {
        echo "inside clone\n";
        // Force a copy of this->object, otherwise
        // it will point to same object.
        $this->object1 = clone $this->object1;
    }
}

$obj = new MyCloneable();

$obj->object1 = new SubObject();
$obj->object2 = new SubObject();

$obj2 = clone $obj;


print("Original Object:\n");
print_r($obj);

print("Cloned Object:\n");
print_r($obj2);
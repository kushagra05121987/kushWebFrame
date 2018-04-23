<?php
require 'vendor/predis/predis/autoload.php';
echo strftime("%H:%M:%S", time());
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Memcached Session
// ----- Memcache Session Handler
ini_set("session.save_handler", "memcache");
ini_set("session.save_path", "tcp://localhost:11211");
// ----- Memcached Session Handler
ini_set("session.save_handler", "memcached");
ini_set("session.save_path", "localhost:11211");
// ----- Redis Session Handler
ini_set("session.save_handler", "redis");
ini_set("session.save_path", "tcp://localhost:6379");
echo "this is echoed.";
// ob_flush();
// flush();
// $i = 0;
// while($i <= 10000000000000000) {
// 	echo "Pi <br />";
// 	++$i;
// }
function br() {
    echo "<br />";
}
function p($arg) {
    print_r($arg);
}
class MemcachedSessionHandler extends SessionHandler {
    public function read($session_id) {
        return (string)parent::read($session_id);
    }
}
$memcachedRegenId = new MemcachedSessionHandler();
session_set_save_handler($memcachedRegenId, true);
session_start();
print_r($_COOKIE);
if(!$_COOKIE['Custom-Cookie']) {
    setcookie("Custom-Cookie", "Custom-Value", time()+3600);
}
echo "SESSION ID = ".session_id();
// session_regenerate_id();
echo "<pre>";
p($_SERVER);
print("=================== Memcache ==================");
if(extension_loaded("memcache")) {
    echo "true";
}
$memcache = new Memcache();
$memcache -> addServer("tcp://localhost:11211");
$memcache -> flush();
// add will add the key only when it is not already present on the server.
//“Memcached::replace() is similar to Memcached::set(), but the operation fails if the key does not exist on the server.”
$memcache -> set("memkey", "memvalue");
$memcache -> add("memkey", "memval2");
echo "Memcache value => {$memcache -> get('memkey')}";
br();
echo " ================= Memcached ================== ";
br();
if(extension_loaded("memcached")) {
    echo "true";
}

/**
 * To check if key exists there is no method like has or exists
 * Use append.

If the item does not exist, you will get an error telling you that it didn't exist.
 */
$memcached = new Memcached();
$memcached -> addServer("localhost", "11211");
$memcached -> flush();
$memcached -> set("memkey2", "memvalue");
$memcached -> add("memkey2", "memval2");
echo "Memcache value => {$memcache -> get('memkey2')}";
p($memcache->getStats());
br();
echo $memcached->getResultCode();
br();
echo $memcached->getResultMessage();
br();
echo "============ APCU =========== ";
br();
if(extension_loaded("apcu")) {
    apcu_store("array_store", [1,2,3]);
    apcu_store("object_store", new stdClass());
    if(!apcu_exists("key_apcu")) {
        echo "No such key found. Adding new .... ";
        apcu_add("key_apcu", "value_apcu");
    } else {
        echo "Key already exists with value ". apcu_fetch('key_apcu') . " .Updating .... ";
        apcu_store("key_apcu", "value_apcu_update");
    }
}
br();
echo " ================= Redis =================== ";
br();
$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => '10.0.0.1',
    'port'   => 6379,
]);

/***
 * Keys * will give all the keys in redis cache or keys *name* will give all the keys with having name in them
 * del will delete all the keys in argument
 * exists will check if key exists
 * Expire Set a timeout on key. After the timeout has expired, the key will automatically be deleted. A key with an associated timeout is often said to be volatile in Redis terminology.

The timeout will only be cleared by commands that delete or overwrite the contents of the key, including DEL, SET, GETSET and all the *STORE commands. This means that all the operations that conceptually alter the value stored at the key without replacing it with a new one will leave the timeout untouched. For instance, incrementing the value of a key with INCR, pushing a new value into a list with LPUSH, or altering the field value of a hash with HSET are all operations that will leave the timeout untouched.

The timeout can also be cleared, turning the key back into a persistent key, using the PERSIST command.
 * EXPIREAT has the same effect and semantic as EXPIRE, but instead of specifying the number of seconds representing the TTL (time to live), it takes an absolute Unix timestamp (seconds since January 1, 1970). A timestamp in the past will delete the key immediately.
 * Remove the existing timeout on key, turning the key from volatile (a key with an expire set) to persistent (a key that will never expire as no timeout is associated).
 * TTL Returns the remaining time to live of a key that has a timeout.
 */

echo "<hr />";
echo "============ REDIS ============== ";
br();
$redis = new Predis\Client();
echo "============== Normal Key Store and access ========= <br />";
$redis -> set("redis_cache_key", "redis_cache_value");
br();
p($redis -> get("redis_cache_key"));
br();
$redis -> set("redis_inc", 1);
p($redis -> getset("redis_inc", 2));
// -------- increment
$redis -> incr('redis_inc');
$redis -> incrby('redis_inc', 2);
br();
p($redis->get('redis_inc'));
//	$redis -> del('redis_inc');
echo "============== List Key Store and access ========= ";
br();
// -------------- List -------------
// 1). List add, update, delete, show all, find one
//------ Adding
$redis -> lpush('redis_list', 20,30,40);
$redis -> lpushx('redis_list', "redis_value_by_pushx");
$redis -> lpushx('redis_list_doesnt_exist', "redis_value_by_pushx"); // adds only if key exists
$redis -> rpush('redis_list', 40,60,80);
$redis -> linsert('redis_list', "before", 80, 90); // inserts after/before a value
$redis -> linsert('redis_list', "after", 90, 100);
$redis -> rpush('redis_list', 110,111,112,113,114,115,116,117,118,119,120);
// brpop,blpop,brpoplpush (list1,list2,list3....listn) ---- Blocking list behaviour in which any list with non empty content will be removed
// first if all the lists are empty then it will block all the requests for pop and as soon as any list gets values it will be a candidate for
// removal and the list that comes first in order will be removed

$redis -> lset('redis_list', 0, "index_list_value_0"); // lset sets list element in index to value
$redis -> lset("redis_list", 2, "index_list_value_2"); // works only when list key already exists
br();
//	p($redis->get('redis_list'));// wont work because this is a list not a direct key value store
p($redis -> lrange('redis_list', 0, -1));
br();
// ------- Limiting
$redis -> ltrim('redis_list', 0, 100);
$redis -> ltrim('redis_list', -1, -2);
$redis -> ltrim('redis_list', 20, 1);
$redis -> ltrim('redis_list', -1, 0);

// ------- Fetching
p($redis -> lrange('redis_list', 0, -1));
br();
p($redis -> lpop('redis_list'));
br();
p($redis -> rpop('redis_list'));
br();
p($redis -> lindex('redis_list', 2));

// ------- Length
p($redis -> llen('redis_list'));

// ------- Remove
$redis -> lpush('redis_list', 20,20,20,20);
$redis -> rpush('redis_list', 200,200,200,200);
// Removes the number(count) of occurances of the value given from head to tail or from tail to head based on the count if -be or +ve
p($redis -> lrem('redis_list', "2", 20));
br();
p($redis -> lrem('redis_list', "-2", 200));
br();
p($redis -> lrem('redis_list', "0", 20));
br();
p($redis -> lrange('redis_list', 0, -1));

// Neither of these will work because list will only allow string no object or arrays
//	$redis -> set("redis_obj", new stdClass());
//	$redis -> lpush('redis_obj', new stdClass());
//	$redis -> lpush('redis_obj', [new stdClass()]);
//	$redis -> set('redis_arr', array(1,2,3,4));
//	$redis -> lpush('redis_arr', array(1,2,3,4));


echo "<hr />";
echo "=========== HASHES ============";
// ---------- Hashes -------------
// ----- Adding
$redis -> hset('hash', 'hash_key_one','key_value_1');
$redis -> hset('hash', 'hash_key_two','key_value_2');
br();
p($redis -> hget('hash', 'hash_key'));
br();
$redis -> hmset('hash', 'hash_key', 20, 'hash_key2', 30, 'hash_key4', 40);
$redis -> hset('hash', 'hash_incr', 1);
$redis -> hincrby('hash', 'hash_incr', 2);

// ------ Getting
p($redis -> hget('hash', 'hash_key'));
br();
p($redis -> hgetall('hash'));
br();
p($redis -> hmget('hash', 'hash_key', 'hash_incr', 'hc'));
br();

// ------ Checking if exists
/**
 * The SCAN command and the closely related commands SSCAN, HSCAN and ZSCAN are used in order to incrementally iterate over a collection of elements.

SCAN iterates the set of keys in the currently selected Redis database.
SSCAN iterates elements of Sets types.
HSCAN iterates fields of Hash types and their associated values.
ZSCAN iterates elements of Sorted Set types and their associated scores.
 */
br();
p($redis -> hexists('hash', 'hash_key'));
br();
p($redis -> hexists('hash', 'hc'));
br();
p($redis -> hlen('hash')); // return length of full hash
br();
$redis -> hset('hash','new_key', 'new_key_value');
//	p($redis -> hstrlen('hash', 'new_key')); // returns length of only key in hash but only if key is holding string value
br();
echo "HSCAN Results";
br();
p($redis -> hscan('hash', 0));
br();
p($scan_return = $redis -> scan(0));
br();
p($redis -> scan($scan_return[0]));
br();
p($redis -> hgetall('hash'));
br();
$redis -> hdel('hash', 'new_key');
echo "<hr />";
br();
echo "============= SETS =============";
br();
$redis -> sadd('sets', 'value1', 'value2', 'value3', 'value4', 'value5');
$redis -> sadd('sets', 'value5', 'value6');
br();
p($redis -> scard("sets")); // return the number of elements (cardinality) in set
br();
$redis -> sadd("sets2", 'value1', 'value2', "value3");
$redis -> sadd("sets3", 'value1', 'value2', "value3", 'value4', "value10");
p($redis -> sdiff('sets', 'sets2', 'sets3')); // gets difference of first key from all other keys
$redis -> sdiffstore('setsdiff', 'sets', 'sets2', 'sets3');
br();
p($redis -> smembers('setsdiff'));
br();
p($redis -> sunion('sets', 'sets2', 'sets3'));
br();
$redis -> sunionstore('setsunion', 'sets', 'sets2', 'sets3');
p($redis -> smembers('setsunion'));
br();
p($redis -> sinter('sets', 'sets2', 'sets3'));
br();
$redis -> sinterstore('setsinter', 'sets', 'sets2', 'sets3');
br();
p($redis -> smembers('setsinter'));
br();
p($redis -> sismember('sets', 'value3'));
br();
p($redis -> sismember('sets', 'value10'));
br();
//	p($redis -> spop('sets', 1)); option is there but not supported in currently installed redis version
br();
p($redis -> spop('sets2'));
br();
p($redis -> srandmember('sets3'));
br();
p($redis -> srandmember('sets3', '2'));
br();
p($redis -> srandmember('sets3', '-2'));
$redis -> srem('sets3', 'value4');
br();
p($redis -> smembers('sets3'));
$redis -> smove('sets3', 'sets', 'value10');
br();
p($redis -> smembers('sets3'));
br();
p($redis -> smembers('sets'));
br();
echo "================== Sorted Sets ===================";
/**
 * XX: Only update elements that already exist. Never add elements.
NX: Don't update already existing elements. Always add new elements.
CH: Modify the return value from the number of new elements added, to the total number of elements changed (CH is an abbreviation of changed). Changed elements are new elements added and elements already existing for which the score was updated. So elements specified in the command line having the same score as they had in the past are not counted. Note: normally the return value of ZADD only counts the number of new elements added.
INCR: When this option is specified ZADD acts like ZINCRBY. Only one score-element pair can be specified in this mode.
 * Using the WEIGHTS option, it is possible to specify a multiplication factor for each input sorted set. This means that the score of every element in every input sorted set is multiplied by this factor before being passed to the aggregation function. When WEIGHTS is not given, the multiplication factors default to 1.

With the AGGREGATE option, it is possible to specify how the results of the union are aggregated. This option defaults to SUM, where the score of an element is summed across the inputs where it exists. When this option is set to either MIN or MAX, the resulting set will contain the minimum or maximum score of an element across the inputs where it exists.
 */
$redis -> zadd('sortedSets', 1, 'one', 2, 'two', 3, 'three');
$redis -> zadd('sortedSets', 4, 'four', 5, 'five', 6, 'six');
$redis -> zadd('sortedSets', 7, 'seven', 8, 'eight', 9, 'nine', 10, 'ten');
$redis -> zadd('sortedSets', 'xx', 11, 'eleven', 12, 'twelve', 13, 'thirteen', 14, 'fourteen');
$redis -> zadd('sortedSets', 'nx', 11, 'eleven', 12, 'twelve', 13, 'thirteen', 14, 'fourteen', 100, 'ten');
$redis -> zadd('sortedSets', 'ch', 11, 'eleven', 12, 'twelve', 13, 'thirteen', 14, 'fourteen', 100, 'ten');
$redis -> zadd('sortedSets', 'incr', 16, 'sixteen'); // this adds new element because 16 is not there
$redis -> zadd('sortedSets', 'incr', 20, 'eleven'); // this updates eleven's score by adding it with 20
$redis -> zadd('sset', 1, '1', 2, 'two', 3, 'three', 4, '4');
$redis -> zadd('set1', 1, 'value1', 2, 'value2', 3, 'value3');
$redis -> zadd('set2', 4, 'value1', 5, 'value2', 6, 'value3');
$redis -> zadd('set3', 7, 'value1', 8, 'value2', 9, 'value3', 10, 'value 4');
br();
echo "AGGREGATES AND WEIGHT TOGETHER => ";
br();
// number of elements in weights array is proportional to number of elements in intersection.
$redis -> zinterstore('outset', array('set1', 'set2', 'set3'), array('WEIGHTS' => array(2, 4, 5), "AGGREGATE" => "SUM"));
// 2, 4, 15 + 16, 20, 24 + 35, 40, 45, 50 => 2 + 16 + 35 = 53, 4 + 20 + 40 = 64, 15 + 24 + 45 = 75
br();
p($redis -> zrange('outset', 0 , -1, 'WITHSCORES'));
br();
$redis -> zincrby('sortedSets', '2', 'sixteen');
$redis -> zinterstore('inter_sset', array('sset','sortedSets'), array('WEIGHTS' => array(2,3)));
br();
$redis -> zrem('lexKey', 'value  8');
$redis -> zadd('lexKey', 0, 'value 0', 1, 'value 1', 2, 'value 2', 3, 'value 3', 0, 'value 4', 0, 'value 5', 6, 'value 6', 7, 'value 7', 0, 'value 8', 0, 'value 9');
br();
echo " ================ LEx =================";
/**
 * Valid start and stop must start with ( or [, in order to specify if the range item is respectively exclusive or inclusive. The special values of + or - for start and stop have the special meaning or positively infinite and negatively infinite strings, so for instance the command ZRANGEBYLEX myzset - + is guaranteed to return all the elements in the sorted set, if all the elements have the same score.
 */
br();
p($redis -> zlexcount('lexKey', '-', '+'));
br();
p($redis -> zlexcount('lexKey', '[-', '+'));
br();
p($redis -> zlexcount('lexKey', '[value 0', '+'));
br();
p($redis -> zlexcount('lexKey', '(value 0', '+'));
br();
p($redis -> zlexcount('lexKey', '[value 0', '[value 8'));
br();
p($redis -> zrangebylex('lexKey', '-', '+'));
br();
p($redis -> zrangebylex('lexKey', '[-', '+'));
br();
p($redis -> zrangebylex('lexKey', '[value 0', '+'));
br();
p($redis -> zrangebylex('lexKey', '(value 0', '+'));
br();
p($redis -> zrangebylex('lexKey', '[value 0', '[value 8'));
br();
echo " ================ LEx =================";
br();
p($redis -> zadd('sortedSets', 'ch', 11, '15')); // returns the total elements changed with 'ch' whereas by default it return total elements added
br();
p($redis -> zadd('sortedSets', 'ch', 12, '15')); // returns the total elements changed with 'ch' whereas by default it return total elements added
br();
p($redis -> zrange('sortedSets', 0, -1));
br();
p($redis -> zcard('sortedSets'));
br();
p($redis -> zcount('sortedSets', '1', '4'));
br();
p($redis -> zcount('sortedSets', '-inf', '+inf')); // -inf and +inf signify the minimum and maximum values of set value weights

// rank is calculated by score . So if score is minimum then rank is 0.
br();
p($redis -> zrange('inter_sset', 0, -1, 'WITHSCORES'));
br();
echo "ZRange By Score";
br();
p($redis -> zrangebyscore('sortedSets', '-inf', '+inf'));
br();
p($redis -> zrangebyscore('sortedSets', '1', '+inf'));
br();
p($redis -> zrangebyscore('sortedSets', '1', '6'));
br();
p($redis -> zrangebyscore('sortedSets', '(1', '(6'));
br();
p($redis -> zrangebyscore('sortedSets', '(1', '7')); // no '[' inclusive operand as by default it is inclusive
br();
p($redis -> zrank('sortedSets', 'ten'));
br();
p($redis -> zrevrange('sortedSets', '0', '-1'));
br();
p($redis -> zrevrangebylex('lexKey', '+', '-'));
br();
p($redis -> zrevrangebylex('lexKey', '(value 8', '-'));
br();
p($redis -> zrevrangebylex('lexKey', '(value 8', '[value 3'));
br();
p($redis -> zrevrangebyscore('sortedSets', '+inf', '-inf', 'WITHSCORES'));
br();
p($redis -> zrevrangebyscore('sortedSets', '(10', '+inf'));
br();
p($redis -> zrevrangebyscore('sortedSets', '13', '2', 'WITHSCORES'));
br();
p($redis -> zrevrank('sortedSets', 'four'));
br();
p($redis -> zscore('sortedSets', 'four'));
br();
p($redis -> zscan('sortedSets', '0'));
br();
$redis -> zunionstore('setUnion', array('set1', 'set2', 'set3'));
p($redis -> zrange('setUnion', '0', '-1', 'WITHSCORES'));
br();
$redis -> zrem('setUnion', 'value1');
$redis -> zremrangebylex('setUnion', '[value2', '+');
$redis -> zadd('setUnion', 23, 'value 3', 4, 'value 4', 56, 'value 5');
$redis -> zadd('setUnion', 24, 'value 6', 5, 'value 7', 57, 'value 8');
$redis -> zremrangebyrank('setUnion', '0', '2');
$redis -> zremrangebyscore('setUnion', '(1', '+inf');
p($redis -> zrange('setUnion', '0', '-1', 'WITHSCORES'));
br();
echo "<hr /> ================================= GEO SPATIAL REDIS ====================================== ";
//Geospatial indexing is implemented in Redis using Sorted Sets as the underlying data structure, but with on-the-fly encoding and decoding of location data and new APIs.
//The way the sorted set is populated is using a technique called Geohash. Latitude and Longitude bits are interleaved in order to form an unique 52 bit integer.
// Geohash is a public domain geocoding system invented by Gustavo Niemeyer, which encodes a geographic location into a short string of letters and digits.
// GeoRadiusBymember This command is exactly like GEORADIUS with the sole difference that instead of taking, as the center of the area to query, a longitude and latitude value, it takes the name of a member already existing inside the geospatial index represented by the sorted set.
//$redis -> geoadd('geoRedis', '12.9538477', '77.3507282', 'Bangalore');
//$redis -> geoadd('geoRedis', '26.4471054', '80.1982935', 'Kanpur');
//$redis -> geoadd('geoRedis', '51.528308', '-0.3817868', 'London');
//br();
//echo "Geo Range =>";
//br();
//p($redis -> zrange('geoRedis', 0, -1, 'WITHSCORES'));
//br();
//p($redis -> geodist('geoRedis', 'Bangalore', 'London', 'km'));
//br();
//p($redis -> geohash('geoRedis', array('Bangalore', 'Kanpur', 'London')));
//br();
//p($redis -> geopos('geoRedis', 'Kanpur'));
//br();
//p($redis -> georadius('geoRedis', '12', '77', '2000', 'km', 'WITHHASH'));
//br();
//p($redis -> georadius('geoRedis', '12', '77', '2000', 'km', 'WITHCOORD'));
//br();
//p($redis -> georadius('geoRedis', '12', '77', '2000', 'km', 'WITHDIST'));
//br();
//p($redis -> georadius('geoRedis', '12', '77', '20000', 'km', 'WITHDIST'));
//br();
//p($redis -> georadiusbymember('geoRedis', 'London', '20000', 'km', 'WITHDIST'));
echo "<hr />================================== Late Static Binding ==================================== ";

/**
 * late static bindings work by storing the class named in the last "non-forwarding call". In case of static method calls, this is the class explicitly named (usually the one on the left of the :: operator); in case of non static method calls, it is the class of the object. A "forwarding call" is a static one that is introduced by self::, parent::, static::, or, if going up in the class hierarchy, forward_static_call(). The function get_called_class() can be used to retrieve a string with the name of the called class and static:: introduces its scope.

This feature was named "late static bindings" with an internal perspective in mind. "Late binding" comes from the fact that static:: will not be resolved using the class where the method is defined but it will rather be computed using runtime information. It was also called a "static binding" as it can be used for (but is not limited to) static method calls.
 */
//	p(new static()); dont work without class
//	p(new self()); dont work without class
class stA {
    private static $var1 = "this is variable one";
    public static $var2 = "this is variable two";
    private $var3 = "this is a variable three";
    public $var4 = "this is a variable four";
    public function f1() {
        echo "<br />Inside F1<br />";
    }
    public function staticInstanceCheck() {
        echo "inside static instance method";
    }
    private function f2() {
        echo "<br />Inside F2";
    }
    public static function f3() {
        echo "<br />Inside F3<br />";
    }
    private static function f4() {
        echo "<br />Inside F4";
    }
    public function __call($name, $args) {
        echo "Inside __call $name <br />";
    }
    protected  function cannotBeCalled() {
        echo "<br />This wont be printed if called outside the class or child class even if it is called using class_name:: outside this or child class<br />";
    }
    public static function lateStaticBinding() {
        echo "<br />".get_class()."<br />";
        echo "<br />".self::f3()."<br />";
        echo "<br />".static::f3()."<br />";
//        echo "<br /> Parent ".parent::f3()."<br />"; // parent:: can be used to call both class method and instance methods.
        echo "<br />".self::f4()."<br />";
//			echo "<br />".static::f4()."<br />"; This will not work because static will make a call to stB's f4 which private for stA
//			echo "<br />".self::f9()."<br />"; This will not work because f9() is not defined in stA even though is extended in stB and called using stB
//			but because of static binding
        echo "<br />".static::f9()."<br />";

        echo "<br /> Calling Static Instance Method => <br />";
        static::staticInstanceCheck();
        try {
            echo "<br />Inside try 1: <br />";
            $this -> f2();
            echo "<br />Inside try 2: <br />";
            // Even fatal errors can now be caught using try catch because now Errors are also classes which implement throwable interface
            $this -> f3(); // Uncaught Error: Using $this when not in object context
        } catch(Error $e) {
            echo $e -> getMessage();
        }
    }
}

class stB extends stA {
    private static $var1 = "this is variable stb one";
    public static $var2 = "this is variable stb two";
    private $var3 = "this is a variable stb three";
    public $var4 = "this is a variable stb four";
    public function f1() {
        echo "<br />Inside F1  stb  <br />";
    }
    private function f2() {
        echo "<br />Inside F2  stb  ";
    }
    public static function f3() {
        echo "<br />Inside F3 stb <br />";
    }
    private static function f4() {
        echo "<br />Inside F4 stb ";
    }
    // Separate methods
    public function f5() {
        echo "<br />Inside F5  stb  <br />";
    }
    private function f6() {
        echo "<br />Inside F6  stb  ";
    }
    public static function f7() {
        echo "<br />Inside F7 stb <br />";
    }
    private static function f8() {
        echo "<br />Inside F8 stb ";
    }
    protected static function f9() {
        echo "<br /> Inside f9 <br />";
    }
    public static function staticCall() {
        br();
        echo "Inside staticCall";
        br();
        self::f3();
        br();
        static::f3();
    }
//        public function __call($name, $args) {
//            echo "Inside __call $name  stb <br />";
//        }
}
$objSta = new stA();
$objSta -> f1();
$objSta -> f2();
stA::f3();
//	stA::f4();
$objSta -> f3();
$objSta -> f4();

echo "<hr />";

$objStB = new stB();
$objStB -> f1();
$objStB -> f2();
$objStB -> f3();
$objStB -> f4();
$objStB -> f5();
$objStB -> f6();
$objStB -> f7();
$objStB -> f8();
stB::staticCall();
stB::lateStaticBinding();


br();
echo "<hr />";
echo "=========== OPCACHE ========= <br />";
p(opcache_get_status());

$total = 100;
// use is allowed only on lambda methods and not on normal methods
function calculate($tax) {
    $callback = function($q, $p) use ($tax, $total) {
        echo "Quantity = ".$q;
        echo "Product = ".$p;
        echo "Tax = ".$tax;
    };
}

$a = 10;

(function() use ($a){
    echo "Nice";
//		echo $a; Notice of undefined variable $a unless we use 'use' keyword as in above calculate method
})();

var_dump(include "index.html_");
var_dump(include("index.html_"));

phpinfo();
?>

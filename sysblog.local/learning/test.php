<?php
namespace constants {
    CONST sss = "SET";
    // this is globally accessible with namespaced scope.
    define('dss', 'SET');
    // define takes complete namespace when defining constant for a specific namespace only
    define('constants\dos', 'SET DOS');

}
namespace{
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
session_set_save_handler($memcachedRegenId, true);// we can pass this new class object here or we can pass individual methods for specific actions session_set_save_handler(open, close, read, write, destroy, gc)
session_start();
print_r($_COOKIE);
if(!$_COOKIE['Custom-Cookie']) {
        setcookie("Custom-Cookie", "Custom-Value", time()+3600);
    }
    echo "SESSION ID = ".session_id();
    // session_regenerate_id();
    echo "<pre>";
    echo "\n ========= Dollar underscore SERVER ========== \n";
    p($_SERVER);
    print("=================== Memcache ==================");
    if(extension_loaded("memcache")) {
        echo "true";
    }
    $memcache = new Memcache();
    $memcache -> addServer("tcp://localhost:11211");
    $memcache -> flush();
    $memcache -> set("memkey", "memvalue");
    $memcache -> add("memkey", "memval2");
    echo "Memcache value => {$memcache -> get('memkey')}";
    br();
    echo " ================= Memcached ================== ";
    br();
    if(extension_loaded("memcached")) {
        echo "true";
    }
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
    echo PHP_EOL;
    echo "----------------- APCU ENTRY ---------------";
    // fetch the key if exists otherwise transfers the control to callback and return the data from that callback
    $config = apcu_entry("config", function($key) {
        return [
            "fruit" => apcu_entry("config.fruit", function($key){
                return [
                    "apples",
                    "pears"
                ];
            }),
            "people" => apcu_entry("config.people", function($key){
                return [
                    "bob",
                    "joe",
                    "niki"
                ];
            })
        ];
    });

    var_dump($config);
    /**
     * The above example will output:

    array(2) {
    ["fruit"]=>
    array(2) {
    [0]=>
    string(6) "apples"
    [1]=>
    string(5) "pears"
    }
    ["people"]=>
    array(3) {
    [0]=>
    string(3) "bob"
    [1]=>
    string(3) "joe"
    [2]=>
    string(4) "niki"
    }
    }
     */
    echo PHP_EOL;
    br();
    echo " ================= Redis =================== ";
    br();
    require '../predis/autoload.php';
    //	$client = new Predis\Client([
    //		'scheme' => 'tcp',
    //		'host'   => '10.0.0.1',
    //		'port'   => 6379,
    //	]);

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
    $redis -> zadd('set3', 7, 'value1', 8, 'value2', 9, 'value3');
    $redis -> zinterstore('outset', array('set1', 'set2', 'set3'), array('WEIGHTS' => array(2, 4, 5)));
    br();
    p($redis -> zrange('outset', 0 , -1, 'WITHSCORES'));
    br();
    $redis -> zincrby('sortedSets', '2', 'sixteen');
    $redis -> zinterstore('inter_sset', array('sset','sortedSets'), array('WEIGHTS' => array(2,3)));
    br();
    $redis -> zadd('lexKey', 0, 'value 0', 1, 'value 1', 2, 'value 2', 3, 'value 3', 0, 'value 4', 0, 'value 5', 6, 'value 6', 7, 'value 7', 0, 'value  8');
    br();
    echo " ================ LEx =================";
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
    br();
    p($redis -> zrange('inter_sset', 0, -1, 'WITHSCORES'));
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
    //$redis -> geoadd('geoRedis', '12.9538477', '77.3507282', 'Bangalore');
    //$redis -> geoadd('geoRedis', '26.4471054', '80.1982935', 'Kanpur');
    //$redis -> geoadd('geoRedis', '51.528308', '-0.3817868', 'London');
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
            echo "<br />This wont be printed if called outside the class or child class event if it is called using class_name:: outside this or child class<br />";
        }
        public static function lateStaticBinding() {
            echo "==== INSIDE LATE STATIC BINDING ==== ";
            echo "<br />".get_class()."<br />"; // gives the class in which function is defined. Will not give actual calling class in case of late static binding. Note: it also accepts object as a parameter and sp at that time this function returns the class of that object. By default object is $this.
            echo "<br />".self::f3()."<br />";
            echo "<br />".static::f3()."<br />";
            echo "<br />".self::f4()."<br />";
    //			echo "<br />".static::f4()."<br />"; This will not work because static will make a call to stB's f4 which private for stA
    //			echo "<br />".self::f9()."<br />"; This will not work because f9() is not defined in stA even though is extended in stB and called using stB
    //			but because of static binding
            echo "<br />".static::f9()."<br />";
            echo " ===== GET_CALLED_CLASS ==== ";
            echo "<br />".get_called_class()."<br />"; // gives actual late static binding calling class
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
    // Static method can be called on class:: as well as on $object ->
    echo "<br />Static call to f3: <br />";

    stA::f3();
    //	stA::f4(); // similiar to __call we can use __callStatic which will then not give error.
    echo "<br />Instance call to f3: <br />";

    $objSta -> f3();
    // f4 is a private method and hence it is equivalent to non existent method and has no visibility outside the class and hence when we have __call method defined we go inside that which ideally would have given error when there was no __call.
    $objSta -> f4();

    echo "<br />Call f1 on static : <br />";
    try{
        stA::f1(); //Deprecated:  Non-static method stA::f1() should not be called statically
    }catch(Throwable $t) {
        echo $t -> getMessage(); // won't work because notice is not a Error or Execption so we need to use register_error_handler.
    }

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

    br();

    var_dump(include "index.html_");
    var_dump(include("index.html_"));

    final class finalClassCannotBeExtended {
        final public function cannotBeOverriden() {
            echo "Inside Class that cannot be extended and method That cannont be overriden";
        }
    }
    br();
    $cbeObj = new finalClassCannotBeExtended();
    $cbeObj -> cannotBeOverriden();
    /**
     * Not allowed to inherit from final class
     */
    // class extendOthers extends finalClassCannotBeExtended {

    // }

    /**
     * Cannot override final method
     */
    // class finalMethodCannotBeOverriden {
    // 	final public function cannotBeOverriden() {
    // 		echo "Inside Class that cannot be extended and method That cannont be overriden";
    // 	}
    // }
    // class cannotOverride extends finalMethodCannotBeOverriden {
    // 	public function cannotBeOverriden() {
    // 		echo "Inside Class that cannot be extended and method That cannont be overriden";
    // 	}
    // }
    br();
    echo "===================== Anonymous Classes ==================";
    br();
    class extendThis {}
    $class = new class extends extendThis{
        public $a = 10;
    };

    echo $class -> a;

    br();
    echo " ========= Stack Trace ========== ";
    br();
    function a() {
        b();
    }
    function b() {
        c();
    }
    function c() {
        var_dump(debug_backtrace());
        br();
        echo "------------- ";
        br();
        var_dump(debug_print_backtrace());
    }
    a();
    br();
    echo "====== Constants =====";
    br();
    // throws error cannot be defined inside blocks other than class or interface.
    CONST b = 30;
    define('x', 200);
    echo "Defined = >";
    br();
    // defined check if there is a constant defined using both CONST or define
    var_dump(defined('b'));
    var_dump(defined('x'));
    if(true) {
    //    CONST b = 30;
    }
    function defineConstants() {
    //    CONST c = 40;
    }
    (function() {
    //    CONST d = 30;
    })();
    try {
    //    CONST d = 30;
    } catch(Error $e) {

    }
    $sc = array(1,2,4,4);
    foreach($sc as $value) {
    //    const dd = 300;
    }
    // Const were not able to use expression in them before PHP 5.6 but are able to use expressions also with const after php 5.6
    const BIT_5 = 1 << 5; // valid since PHP 5.6, invalid previously
    // const is case sensitive, define is also case sensitive but allows to be case insensitive by passing 3rd argument as true.
    CONST df = 400;
    //CONST DF = 500;
    br();
    echo "Constants === ";
    br();
    echo df;
    br();
    echo DF;
    br();
    define('FOO', 'BAR', true);
    echo FOO; // BAR
    echo foo; // BAR

    br();
    echo "USING NAMESPACED CONSTANTS";
    br();
    use \ArrayObject as ArOb;
    var_dump(ArOb);
    /**
     * // importing a global class
    use ArrayObject;

    // importing a function (PHP 5.6+)
    use function My\Full\functionName;

    // aliasing a function (PHP 5.6+)
    use function My\Full\functionName as func;

    // importing a constant (PHP 5.6+)
    use const My\Full\CONSTANT;
     */
    use const constants\sss, constants\dos;
    echo sss, dos, dss;

    class constants {
        CONST a = 20;
        public function __construct() {
            echo a;
            br();
            define('constant', 30);
        }
    }
    new constants();
    br();
    echo "Constants here ===== ";
    br();
    echo "Constant a = ".a; // Cannot access outside class when defined use CONST
    br();
    echo "Constant 'constant' = ".constant; // can be access out class also when defined using define()
    br();
    echo " ======= Autoload =======";
    // we've writen this code where we need
    /***
     * As of php 7.0 this (__autoload) is deprecated
     */

    function __autoload($classname) {
        echo "inside __autoload method";
        $filename = "./". $classname .".php";
        include_once($filename);
    }
//    new DummyClass();
    //	This is one way to autoload classes using spl_autoload which gives default implementation of __autoload
    // spl_autoload_register can take multiple auto loading methods which are called using FIFO
    set_include_path("./include");
    // include_path is same as set_include_path, works as a base dir for require, include, fopen(), file(), readfile() and file_get_contents()
    //include_path(); No such method we have to set it from ini_set('include_path', "") or by set_include_path
    // set_include_path('/usr/lib/pear');
    // Or using ini_set()
    //    ini_set('include_path', '/usr/lib/pear');
    spl_autoload_register(function($classname) {
        // this function cannot take multiple file extensions like spl_autoload_extensions though it takes values from spl_autoload_extensions
        // if we need to supply multiple file extensions then we need to use spl_autoload_extensions and pass it as a second argument in spl_autoload
        // like in next section
        spl_autoload($classname, ".php");
    });
    br();
    // we've called a class ***
//    new includes();
    br();
    echo " ----------------- ";
    br();
    // here we are trying to include files with two type of extensions
    spl_autoload_extensions('.php,.class.php');
    $extensions = spl_autoload_extensions();
    // this is similar to not calling spl_autoload because if nothing is passed the spl_autoload is automatically called we can use this structure if we want to pass some different name which needs a little modification before autoloading
    spl_autoload_register(function($class) use ($extensions) {
        spl_autoload($class, $extensions);
    }); // calling this method without any arguments calls spl_autoload as a default implementation of __autoload
    br();
    //new includes();
    br();
    //new include2();
    // If we want to include only php files from a specific directory with file name same as class name then we just can do following
    br();
    spl_autoload_register();
    //new includes();
    br();
    echo "------------------ ";
    br();
    // Try all registered __autoload() functions to load the requested class
    spl_autoload_call('call');
    br();

    echo "============ Abstract Classes and interfaces ===============";
    echo "\n ======= Abstract Methods Without Abstract Classes =========== \n";
    class noAbs {
    //	    public abstract function absFunc(); // Not allowed to create abstract methods inside a class that is not abstract
    }
    interface inter {
        public function method1(); // abstract keyword in not allowed here in implement method definitions
        public function method5(); // implement methods should always be public and not private or protected
        // public function method2() {
        // 	echo "This is not allowed";
        // } // Not allowed to have a body
    }
    interface inter2 extends inter {
        public function method2(); // abstract keyword in not allowed here in implement method definitions
    }

    // if we dont implement methods in this class which is not abstract then we will get a fatal error
    class notabs implements inter2 {
        public function method1() {}
        public function method2() {}
        public function method5() {}
    }
    // but if we dont implement those implement methods here then we dont get any error because in abstract classes methods are allowed to have or not have a body
    abstract class abs implements inter2 {
        // 	public abstract function method3() {

        // 	} // abstract method cannot contain body
        public abstract function method3();
        // public function method1(); // non abstract methods should always contain a body
        public abstract function method1();
        public function method2() {

        }
        // public function method4(); // cannot define methods without body without using abstract keyword
    }

    class implMultipleInter implements inter, inter2 {
        public function method1() {}
        public function method2() {}
        public function method5() {}
    }

    br();
    echo ini_get('memory_limit');
    //	ini_set('memory_limit', '1G');
    br();
    echo " ============= Polymorphism ============ ";
    // Polymorphism can be applied using __call or by func_num_args, func_args
    class poly {
        public $ss = 300;
        public static $dd = 400;
        public function __call($name, $arguments) {
            // TODO: Implement __call() method.

            if(!(method_exists($this, $name))) {
                echo "<br />";
                echo "Inside Poly == > ";
                echo "<br />";
                echo $this -> ss;
                echo "<br />";
                echo self::$dd;
                //				Cannot use this approach like $this -> $name() because $name is not a function but $this->$name is a function so it should
    //				be called like ($this->$name)($arguments) and not like $this->$name()
                $this->$name = function($arguments) use ($name) {
                    echo "<br />This is a default implementation of $name as function definition was not found and received following arguments";
                    print_r($arguments);
                };
    //				$this -> defaultPoly($name, $arguments);
                ($this->$name)($arguments);
                return 0;
            }
            $this -> $name($arguments);
        }
        private function one($arguments) {
            echo "<br />Arguments received in one <br />";
            print_r($arguments);
        }
        private function defaultPoly($name,$arguments) {
            echo "<br />This is a default implementation of $name as function definition was not found and received following arguments";
            print_r($arguments);
        }
        public function __toString():string
        {
            // TODO: Implement __toString() method.
            return "Hello";
        }
    }
    //Forces collection of any existing garbage cycles.
    //	gc_collect_cycles();
    //	ob_clean();
    //	flush();

    $p = new poly();
    $p -> one(1,2,3,4);
    $p -> two(1,2,3,4);
    $p -> one(1,2,3,4,5,6);
    $p -> two(1,2,3,4);
    echo (string) $p;
    br();
    echo serialize(new poly());
    br();
    echo json_encode($p);
    br();

    function argumentsPloyCheck() {
        echo "============== FUNC ARGS ==============";
        echo "<br />";
        var_dump(func_get_arg(2));
        echo "<br />";
        var_dump(func_get_args());
        echo "<br />";
        var_dump(func_num_args());
        echo "<br />";
    }
    argumentsPloyCheck(1,2,3,4,5,6,6,8,9);
    // Doesnt work outside class
    function __call() {
        echo "called ------ ";
    }
    //undefined(); // doesnt go inside __call() because its a class function
    // Also dont work outise class
    function __get() {
        echo "Inside get";
    }
    // Also dont work outside class
    function __set() {
        echo "inside set";
    }
    $undefinedvar = 20;
    echo $undefinedvar;
    br();
    class comp1 {
        private $a, $b = null;
        public $c = null;
        private static $d = null;
        public static  $e = null;
        public function __construct($a, $b, $c, $d, $e) {
            $this -> a = $a;
            $this -> b = $b;
            $this -> c = $c;
            self::$d = $d;
            self::$e = $e;
        }
    }
    class comp2 {
        private $a, $b = null;
        public $c = null;
        private static $d = null;
        public static  $e = null;
        public function __construct($a, $b, $c, $d, $e) {
            $this -> a = $a;
            $this -> b = $b;
            $this -> c = $c;
            self::$d = $d;
            self::$e = $e;
        }
    }
    // comp1 < comp6 only when either one of the property of comp1 is less than comp6. comp1 will be greater than comp6 when all the properties of comp 1 are geater than comp6
    $comp1 = $comp5 = new comp1(10,40,30,240,50);
    $comp6 = new comp1(15,30,20,40,5);
    $comp7 = new comp1(10,20,30,40,50);
    $comp2 = new comp2(10,20,30,40,50);
    $comp3 = new comp2(30,90,10,0,150);
    $comp4 = new comp2(0,0,0,0,0);
    echo "\n ======== Class Comparison ===== \n";
    var_dump($comp1 == $comp2);
    var_dump($comp1 < $comp2);
    var_dump($comp1 > $comp2);
    echo "<hr />";
    var_dump($comp1 == $comp3);
    var_dump($comp1 < $comp3);
    var_dump($comp1 > $comp3);
    echo "<hr />";
    var_dump($comp1 == $comp4);
    var_dump($comp1 < $comp4);
    var_dump($comp1 > $comp4);
    echo "<hr />";
    var_dump($comp1 == $comp5);
    var_dump($comp1 < $comp5);
    var_dump($comp1 > $comp5);
    echo "<hr />";
    var_dump($comp1 == $comp6);
    var_dump($comp1 < $comp6);
    var_dump($comp1 > $comp6);
    echo "<hr />";
    var_dump($comp1 === $comp7);
    var_dump($comp1 < $comp7);
    var_dump($comp1 > $comp7);
    echo "<hr />";
    var_dump($comp1 === $comp5);
    var_dump($comp1 < $comp5);
    var_dump($comp1 > $comp5);
    class a {
        public function __construct() {
            return "Object Created";
        }

        public $a = 10;
        public $b = 20;
        public function meth() {
            echo "HI";
        }
        public function __toString()
        {
            return "Object Value";
            // TODO: Implement __toString() method.
        }
    }
    print_r(new a);
    echo "\n";
    print_r((string) new a); // This calls toString method
    echo "\n";
    print_r((array)new a); // can convert object to array
    echo "\n";
    echo "\n";
    // CONSTANTS can be accessed outside classes as class properties using :: operator
    class aconstants {
        const CON = 20;
    }
    echo aconstants::CON;
    $obj1 = new \stdClass; // Instantiate stdClass object
    $obj2 = new class{}; // Instantiate anonymous class
    $obj3 = (object)[]; // Cast empty array to object

    var_dump($obj1); // object(stdClass)#1 (0) {}
    var_dump($obj2); // object(class@anonymous)#2 (0) {}
    var_dump($obj3); // object(stdClass)#3 (0) {}

    echo "\n Isset and empty \n ";
    $a = null;
    $x = "yes";
    $z = array();
    $w = array(2,3,4,5);
    echo "\n ISSET \n";
    var_dump(isset($a));
    var_dump(isset($b));
    var_dump(isset($x));
    var_dump(isset($z));
    var_dump(isset($w));
    echo "\n EMPTY \n";
    var_dump(empty($a));
    var_dump(empty($b));
    var_dump(empty($x));
    var_dump(empty($z));
    var_dump(empty($w));

    echo "\n ======== Separators ========== \n";
    echo "PATH SEPARATOR = ".PATH_SEPARATOR;
    echo "DIRECTORY SEPARATOR = ".DIRECTORY_SEPARATOR;


    class ac {
        public static $modify = 20;
        public $instModify = 20;
        public function meth1($arg) {
            self::$modify += $arg;
            $this -> instModify += $arg;
        }
    }
    class b extends ac {
        public function meth1($arg) {
            parent::meth1($arg); // TODO: Change the autogenerated stub
        }
    }

    $obj1 = new b();
    $obj2 = new b();
    $obj1 -> meth1(10);
    echo b::$modify;
    echo PHP_EOL;
    echo $obj1 -> instModify;
    echo PHP_EOL;
    $obj2 -> meth1(20);
    echo b::$modify;
    echo PHP_EOL;
    echo $obj2 -> instModify;

    // Classes below demonstrate that if we extend another class and from child class call parent:: then $this referes to child class and not parent class. Only if something is not found in child class then only parent classe's value will be taken.

    class ass {
        public $s = 30;
        public $d = 300;
        public function retrieve() {
            echo $this -> s;
            echo $this -> x;
            echo $this -> d;
        }
    }
    class bss extends a {
        public $x = 40;
        public $s = 60;
        public function retrieve() {
            parent::retrieve();
        }
    }

    (new bss) -> retrieve();
    phpinfo();
}

?>

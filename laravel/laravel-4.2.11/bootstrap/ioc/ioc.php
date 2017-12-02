<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 24/11/17
 * Time: 11:19 PM
 */

echo App::environment();

//App::Abort(404);
//App::missing(function($route) {
//    echo "inside missing";
//    var_dump($route);
//});
//// We can check by passing environment name in method to check if current environment macthes it App::environment('local'); or matching either of environment App::environment('local', 'staging');
var_dump($_ENV);

// events during request cycle
// before, after, finish, shutdown
// before -> just before request is resolved and enters into application
// after -> just after the request has completed
// finish -> finish event is called after the response from your application has been sent back to the client.
// shutdown -> he  shutdown event is called immediately after all of the finish event handlers finish processing, and is the last opportunity to do any work before the script terminates.
///You may also register a listener on the matched event, which is fired when an incoming request has been matched to a route but that route has not yet been executed:

//Route::matched(function($route, $request)
//{
//    //
//});
// App::resolving('foo, function($foo) {})
App::resolvingAny(function($object) {
    if($object && is_object($object)) {
        echo "<br />";
        var_dump(get_class($object));
    }
});

echo "<pre>";
// App object is available after booted in illuminate start.php
App::bind('foo', function($bz) {
//    var_dump($bz); // this is current application object
});

echo PHP_EOL;
var_dump(App::make('foo'));
echo PHP_EOL;

class foobar {
    function __construct() {
        echo "inside";
    }
}
$app -> instance('foo', new foobar());

echo PHP_EOL;
var_dump($app -> make('foo')); // this is ioc way of creating new object
echo PHP_EOL;
//var_dump(new foo()); // this will generate nothing but error

//App::bind('foo', function(foobar $bz) { /// here the object will not be automatically injected
//    var_dump($bz);
//});

class singletonClass {
    public $x;
}
App::singleton('foo', function() {
    return new singletonClass();
});

$o1 = App::make('foo');
$o2 = App::make('foo');
echo PHP_EOL;
var_dump($o1);
echo PHP_EOL;
var_dump($o2);
echo PHP_EOL;
var_dump($o1 == $o2);
echo PHP_EOL;
var_dump($o1 === $o2);

class foojar {
    public function __construct(foobar $fb){
        var_dump($fb);
    }
}
var_dump(App::make('foojar'));

echo PHP_EOL;
echo "------------------- Bind Class with other Class and interfaces ---------------------------";
echo PHP_EOL;
interface foobarInterface{}
class foob {
    public $x;
}
class fb {
    public $a;
}
App::bind('fb', 'foob');
App::bind('foobarInterface', 'foob'); // foob is not implementing interface so if make called it gives error
// bind gives new instance for every call but if you return third argument as true it returns a shared object

var_dump(App::make('fb'));
class doo implements foobarInterface {

}
var_dump(App::make('doo')); // gives doo only
class fobar implements foobarInterface {

}
App::bind('foobarInterface', 'fobar'); // foob is not implementing interface so if make called it gives error
class dobar {
    public function __construct(doo $d, foobarInterface $fbi){
        var_dump($d, $fbi);
    }
}
//var_dump(App::make('dobar')); // generates error because doo is not implementing interface
class dBar {
    public function __construct(foobarInterface $fbi){
        var_dump($fbi);
    }
}
var_dump(App::make('dBar'));
// All controller are resolved as IoC so when we inject any class in controller if gets automatically injected
/// for sharing laravel uses a static object to store the previously resolved object and then reuse the same

class o {}
$app['ob'] = App::share(function($app) { /// $app is by default passed into the callback if we want to receive any other object there then its not possible and will get error
    return new o;
});

$o1 = App::make('ob');
$o2 = App::make('ob');

var_dump($o1 == $o2);
var_dump($o1 === $o2);

App::bindShared('obb', function() {
    return App::make('dBar');
});
$o1 = App::make('obb');
$o2 = App::make('obb');

var_dump($o1 == $o2);
var_dump($o1 === $o2);

App::instance("obbb", App::make('dBar'));
$o1 = App::make('obbb');
$o2 = App::make('obbb');

var_dump($o1 == $o2);
var_dump($o1 === $o2);

class ins {}
App::instance('p', new ins);
$o1 = App::make('p');
$o2 = App::make('p');

var_dump($o1 == $o2);
var_dump($o1 === $o2);
//bindShared and singleton are basically the same thing except bindShared is deprecated so you should use singleton instead.

//resolve('p'); // as of laravel 5.* if not in context of $app or App then resolve can be used to resolve the class with dependencies
//$app -> makeWith('p', ['id' => '1']); // If some of your class' dependencies are not resolvable via the container, you may inject them by passing them as an associative array into the makeWith method
$app -> bindIf('root', function() {});

// composer will override the parameters passed from controller to route
//View::composer('hello', function($view) {
//    echo "inside composer";
//    $view -> with("message", "changed by composer");
//});
// creator will not override the parameters passed from controller to route
//View::creator('hello', function($view) {
//    echo "inside creator";
//    $view -> with("message", "changed by creator");
//});

View::composer('home.check', 'comCr'); // only composers can use class instead of callbacks
//View::creator('home.check', 'comCr'); // not valid for creator

class comCr {
    public function compose($view) {
        $view -> with('message' , "changed inside class");
    }
}

// response macro used to prepare a response and save it so that it can be used at multiple places
Response::macro('caps', function($value) { // now this macro can be called from multiple places without having a need to rewrite the same logic again
    return Response::view('home.macro', ['name' => $value]);
});

echo "---------------";
var_dump(Event::firing());

Event::listen("admin.login", function($data) {
    echo "inside admin login";
    var_dump($data);
});

Event::fire("admin.login", ["kushagra"]);

Event::listen('admin.create', 'Suscriber');
class Suscriber {
    public function handle($data) {
        var_dump("inside subscriber");
        var_dump($data);
    }
}
Event::fire('admin.create', [["kusagra", 200]]);

class Suscriber2 {
    public function f1($data) {
        var_dump("inside f1", $data);
    }
    public function f2($data) {
        var_dump("inside f2", $data);
    }
    public function subscribe($events) {
        var_dump("inside subscriber2", Event::firing());
        $events -> listen('admin.edit', "Suscriber2@f1");
        $events -> listen('admin.store', "Suscriber2@f2");
    }
}

Event::subscribe('Suscriber2');
//Event::subscribe(new Suscriber2); //same as above

Event::fire('admin.edit',  [['page' => 1, "total" => 100]]);
Event::fire('admin.store',  [['page' => 2, "total" => 100]]);
echo "</pre>";
// events can be used with precedence as third argument in listen call. if a callback of listen returns false then the event listen or subscriber chain is broken which is generally made with help of precedence

// Logging is done using monolog and has seven logging methods info, error, notice, warning, critical, alert, debug.
$log = Log::getMonolog();
var_dump($log);
//$log -> info("logging here", ['page' => 1, "total" => 100]);

// Listen to log message
Log::listen(function($level, $message, $context) {
//    var_dump($level);
//    var_dump($message);
//    var_dump($context);
});

// provides method is used for deferred loading of service providers
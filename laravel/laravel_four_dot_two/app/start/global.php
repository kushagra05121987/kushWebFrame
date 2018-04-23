<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(
	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',
	app_path().'/classes',
	app_path().'/traits',
));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');
/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
    if($exception instanceof Illuminate\Database\Eloquent\ModelNotFoundException) {
        echo "Model Not Found";
    }
	Log::error($exception);
});
App::fatal(function($exception)
{
    //
});
//You may register an error handler that handles all "404 Not Found" errors in your application, allowing you to easily return custom 404 error pages:
// We can also check for 404 code in App::error method
App::missing(function($exception)
{
    return Response::view('errors.missing', array(), 404);
});

// Fatal errors can be caught by App:fatal. All 404 error maybe handled by App::missing(function($error) {}) . To abort request with error we may use App::abort(404) or App::abort(403, 'Forbidden')



/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

// App::up is not defined App::down is used for both states
//App::up(function() {
//    echo "Going live .....";
//});
App::down(function()
{
    return View::make('maintenance');
//	return Response::make("Be right back!", 503);
//    return Response::view('maintenance', array(), 503);
    return null; // if closure returns null then maintenance mode will be ignored for that request
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

View::share('nameshared', 'Steve'); // View share can be used to share a data between different views

class notFound {
    public function compose($view) {
//        $view -> make('home.base') -> with('delivery_status', 'delivered'); // cannot use make here because $view is after doing View::make. So we can only attach data using with method to the view
        $view -> with('delivery_status', 'delivered');
    }
}
class baseViewComposer {
    public function __construct(User $user){
        $this -> user = $user;
    }

    public function redesign($view) {
        $view -> with('user', $this -> user);
    }
}
// in view::composers we have opposite mapping compared to View::composer in which we define view name first and the callback or class but in composers we need class first and then callbacks.
View::composers(array(
    'notFound' => 'errors.missing',
    'baseViewComposer@redesign' => 'home.base'
));

Form::macro('myfield', function($class) {
    return "<input type='text' value='' name='customtext' class='".$class."' /> ";
});

Route::filter('customFilter', 'HomeController');

Event::subscribe('HomeController');

Validator::extend('kushagra_rule', function($attribute, $value, $parameters) {
    return $parameters[0] <= $value && $value < $parameters[1];
});

Validator::replacer('kushagra_rule', function($message, $attribute, $rule, $parameters) {
    return str_replace(':kush', $parameters[0], $message);
});

Validator::resolver(function($translator, $data, $rules, $messages) {
    echo "<pre>";
    print_r($translator);
    print_r($data);
    print_r($rules);
    print_r($messages);
    echo "</pre>";
    return new ValidatorCustom($translator, $data, $rules, $messages);
});
Queue::failing(function($connection, $job, $data)
{
    print_r("\nJob Failing\n");
//    print_r($connection);
//    print_r($job);
//    print_r($data);
});

DB::listen(function($sql, $bindings, $time) {
    echo "\nListening ------ \n";
    echo $sql;
    echo "\n";
});


require app_path().'/filters.php';

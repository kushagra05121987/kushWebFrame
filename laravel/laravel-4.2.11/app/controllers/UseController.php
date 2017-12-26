<?php

class UseController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getIndex($id)
	{
        var_dump(Route::getCurrentRoute() -> parameters());
        echo "inside get index";
	}

	public function postIndex() {
        echo "inside post index";
    }

    public function getCreate() {
        echo "inside get create";
    }

    public function putUpdate() {
        echo "inside put update";
    }

    public function missingMethod($parameters = array()) {
	    echo "inside missing methods";
    }

    public function anyCall() {
	    echo "inside any call";
    }
}

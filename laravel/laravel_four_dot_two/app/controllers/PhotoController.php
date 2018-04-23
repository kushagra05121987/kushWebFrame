<?php

class PhotoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	    var_dump(Route::getCurrentRoute() -> parameters());
	    var_dump(Route::currentRouteName());
	    var_dump(Route::currentRouteAction());
	    echo "<pre>";
	    var_dump(Route::getCurrentRoute());
	    echo "</pre>";


		//
        echo "inside index";
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
        echo "<pre>";
        echo "inside create";
        var_dump(Input::all());
        var_dump(Input::old());
        var_dump(Session::all());
        var_dump(Session::get('message'));
        // return download
        // app_path() -> till app
        // public_path() -> till public directory
        //storage_path() -> till storage
        echo base_path();
        return Response::download(base_path()."/1.tt", "1.text", ['Content-Type: application/pdf', 'Content-Disposition:inline']);
        echo "</pre>";
    }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        echo "inside store";
        echo "<pre>";
        var_dump(Input::all()); // this has data even if we send a raw input / input in json format which needs php://input stream
        var_dump(Input::get('id')); // this has data even if we send a raw input / input in json format which needs php://input stream
        // Input::get('name', 'Default') if name is not found then Default is returned
//        Input::has(); is used to check if input has a parameter with given name
//        Input::only('username', 'password'); this gets only username and password
//        Input::except('name'); this gets everything except name
//        If input has form with array elements then we can directly take it from Input::get('product.0.names')
//        return Redirect::route('admin.photo.create') -> withInput(Input::flash());
//        return Redirect::to('admin/photo/create') -> with("message", "success"); // all flash data is set inside session so inorder to retrieve it we can use Session::get
//        return Redirect::action('PhotoController@create') -> with("message", "success"); // all flash data is set inside session so inorder to retrieve it we can use Session::get
//        return Redirect::action('PhotoController@create', ["id" => 330]) ; // data passed like this to redirected routes goes into their Input
        var_dump(Input::file('photo'));
        var_dump(Input::hasFile('photo'));
        var_dump(Input::file('photo') -> isValid());
        var_dump(Input::file('photo') ->getRealPath());
//        var_dump(Input::file('photo') ->move("/var/www/", "testsocket.log")); // if we will try to access below thing after uploading they wont work
        var_dump(Input::file('photo') ->getRealPath());
        var_dump(Input::file('photo') ->getClientOriginalName());
        var_dump(Input::file('photo') ->getClientOriginalExtension());
        var_dump(Input::file('photo') ->getSize());
        var_dump(Input::file('photo') ->getMimeType());

        var_dump(Request::server());
        var_dump(Request::path());
        var_dump(Request::method());
        var_dump(Request::isMethod('post'));
        var_dump(Request::is('admin/*'));
        var_dump(Request::url());
        var_dump(Request::segment(1));
        var_dump(Request::header('Content-Type'));
        var_dump(Request::secure());
        var_dump(Request::ajax());
        var_dump(Request::isJson());
        var_dump(Request::wantsJson());

        // returning json response
        return Response::json(['name' => "Kushagra"]);

//        return Response::download($pathToFile, $name, $headers);

        echo "</pre>";
    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	    echo "inside show";
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
        echo "inside edit";
    }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
        echo "inside update";
    }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
        echo "inside delete";
    }


}

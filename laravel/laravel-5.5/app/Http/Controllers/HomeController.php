<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPost;
use App\Rules\Uppercase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this -> app = $app;
        $this->middleware('auth');
    }

    public function postIndex(Request $request) {
//        dd($request -> all());
//        dd($request -> file);
//        dd($request -> hasFile('files'));
//        dd($request -> hasFile('file'));
//        dd($request -> file -> getClientOriginalName());
//        dd($request -> file -> getClientOriginalExtension());
//        dd($request -> file -> extension());
//        dd($request -> file -> path());
//        dd($request -> file -> getRealPath());
//        echo $request -> file -> path(), "<br />".$request -> file -> getRealPath();
//        echo "<br />";
//        echo $request -> file -> getClientOriginalExtension(), "<br />".$request -> file -> extension();
//        dd($request -> file -> getSize());
//        dd($request -> file -> getMimeType());
//        $request -> file -> store('images', 'local');
//        $request -> file -> storeAs('images', 'filenamme.jpg', 'local');
        return response("Hello", 200);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, \App\User $user)
    {

//        dd($request->a);
//        dd(Input::all()); // not exists in 5.6
//        dd($request -> session());
//        dd($request -> cookie());
//        dd($request -> cookie('XSRF-TOKEN'));
//        dd($request -> session('laravel_session'));
//        \Dumper::dump($request -> user() -> name);
//        \Dumper::dump($user -> name);
//        session() -> put('name', 'value');
//        session() -> put('nullval', '');
//        session() -> put('nullval2', null);
//        \Dumper::dump(session() -> has('name'));
//        \Dumper::dump(session() -> has('nullval'));
//        \Dumper::dump(session() -> has('nullval2'));
//        \Dumper::dump(session() -> exists('nullval'));
//        \Dumper::dump(session() -> exists('nullval2'));
//        \Dumper::dump(config() -> set('app.nval', 'pp'));
//        \Dumper::dump(config() -> get('app.nval'));
//        \Dumper::dump(config(['app.nval' => 'pp']));


//        abort(404);
//        throw new \App\Exceptions\CustomHandler('This is custom Exception', 503);

        return view('components');
    }

    public function validations(StoreBlogPost $request) {
//        $request -> validate([
//            'email' => 'sometimes|required|email',
//            'username' => 'sometimes|nullable|min:3|max:10',
//            'file' => 'required|size:10'
//        ]);
//        $validate = \Validator::make($request -> all(), [
//            'email' => 'sometimes|required|email',
//            'username' => 'sometimes|nullable|min:3|max:10',
//            'file' => 'required|size:10'
//        ]) -> validate('login');
        $validate = \Validator::make($request -> all(), [
            'email' => 'sometimes|required|email',
            'username' => [new Uppercase, 'sometimes','nullable','min:3','max:10'],
            'file' => 'required|size:10'
        ]);
        $validate->after(function ($validator) {
           \Dumper::dump("Inside after manual");
        });
        $validate -> passes();
        \Dumper::dump($validate -> errors());
        dd("Hello Validation successfull");
    }

    public function callFireDepartment($id, $name, Request $request) {
        var_dump($id);
        var_dump($name);
        var_dump(get_class($request));
        var_dump($this -> app -> make('appUtility'));
    }

    public function dbQuery() {
        \Dumper::dump(\DB::table('users') ->where('id', '>=', '1') -> value('name')) ;
        \Dumper::dump(\DB::table('users') ->where('id', '>=', '1') -> pluck('id','name', 'email')) ;
        // DB raw wont take any parameter binding expressions . also binding doesn't work on table . It takes columns names as binding but will not then return results. So we can only do binding for where and other conditions
        \Dumper::dump(\DB::select(
            \DB::raw('select id, name, email from users where id >= ?', [1]),
            [1]
        )) ;

        \Dumper::dump(\DB::table('users') -> select(\DB::raw('CONCAT(name, ".", "manager") as name'), 'email as em') -> get()); // cannot using parameter binding in this
//        \Dumper::dump(\DB::table('users') ->where('id', '>=', '1') -> lists('id','name', 'email')) ; // doesnot exists
    }
    public function schemaCreate() {
//        if(\Schema::hasTable('comments')) {
//            \Schema::drop('comments');
//        }
////
//        if(\Schema::hasTable('post_comments')) {
//            \Schema::drop('post_comments');
//        }
////
//        if(\Schema::hasTable('posts')) {
//            \Schema::drop('posts');
//        }
////        // create will not automatically perform check if table exists or not
//        \Schema::create('posts', function(Blueprint $table) {
//            $table -> engine = "InnoDB";
//            $table -> increments('id'); //-> primary()
//            $table -> string('content');
//            $table -> integer('user_id') -> unsigned();
//            $table -> foreign('user_id') -> references('id') -> on('users') -> onDelete('cascade');
//            $table -> softDeletes();
//            $table -> timestamps();
//        });
//        \Schema::create('comments', function(Blueprint $table) {
//            $table -> engine = "InnoDB";
//            $table -> increments('id'); //-> primary()
//            $table -> string('content');
//            $table -> string('type');
//            $table -> integer('post_id') -> unsigned();
//            $table -> integer('parent_id') -> unsigned();
//            $table -> foreign('parent_id') -> references('id') -> on('comments');
//            $table -> foreign('id') -> references('id') -> on('posts') ->  onDelete('cascade');
////            $table->renameColumn('content', 'comment');
//            $table -> softDeletes();
//            $table -> timestamps();
////            $table -> integer('post_id') -> after('id')-> unsigned() ;
//        });


//        $table = new Blueprint('post_comments');
//        $table->renameColumn('content', 'comment');

        // $table->dropColumn(array('votes', 'avatar', 'location'));
//        var_dump(\Schema::hasColumn('users', 'email'));
//        \Schema::rename('comments', 'post_comments');
            \Schema::table('post_comments', function($table) {
//            $table -> string('type', 100)->default('parent') -> after('content');
//            $table -> enum('lightings', ['on', 'off'])->default('on');
//            $table -> dropColumn('lightings');
//            $table -> enum('lights', ['on', 'off'])->default('on') -> after('content');
//            $table -> enum('lights', ['on', 'off'])->default('on') -> before('content');
                $table -> integer('type') -> nullable() -> change();

//            $table -> renameColumn('content', 'comments'); doesnt work
            });
    }

    public function queryingModel() {
//        foreach(\App\User::where('id', '>', 1) -> cursor() as $row) {
//            \Dumper::dump($row);
//        }
//        \App\User::find([1,2,3]);
//        \App\User::findOrFail([1,2,3]);
//        \App\User::find(1) -> update(["name" => "kushagra", "email" => 'kariz@gmail.com']);

//        $user = new \App\User(['name' => "Dummy2", "email" => 'dummy2@dummy.com', 'password' => \Hash::make('secret')]);
//        \App\User::create(
//            ['name' => "Dummy1", "email" => 'dummy1@dummy.com', 'password' => \Hash::make('secret')]
//        );
//        \App\User::ofType(1)->get(); Doesnot exist
//        $user = new \App\User();
//        $user -> name = "Kushagra";
//        $user -> email = "kush@gmail.com";
//        $user -> password = "anldal";
//        $user -> save();
        return response('Hello', 200);

    }
}

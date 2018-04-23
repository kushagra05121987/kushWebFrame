<?php
use Illuminate\Database\Schema\Blueprint;
//use DatabaseC\DatabaseC;
class HomeController extends BaseController {

    protected $layout = 'blade.controllerDefault';

    public function __construct(Event $event){
        $this -> event = $event;
        parent::__construct();
//        $this -> layout = "blade.default";
        // whatever is retured in larave is treated as response so if even 1 is returned from filter it wil be treated as responnse and no other routes will execute.
//        $this -> beforeFilter(function($route, $request) {
//            echo "filtering 1 before .. ";
////            return 1;
//        }, array('on' => ['post', 'get'], 'only' => ['postLetter', 'getLetter']));
//        $this -> afterFilter(function($route, $request, $response) {
//            echo "filtering 1 before .. ";
//            return 1;
//        }, array('on' => 'get', 'only' => 'user'));
//
//        $this -> beforeFilter(function($route, $request) {
//            echo "filtering 2 before .. ";
//        }, array('on' => 'get', 'only' => ['filter', 'filterRoutes']));
//
//        $this -> beforeFilter('@filterRoutes', array('on' => 'get', 'only' => ['filterFunctionCallCheck']));
    }

    public function index() {
//        dd(Input::get('c', function() {
//            return "Duffer";
//        }));
//        dd(Input::get('c', 'Default'));
//        dd(Request::url());
//        dd(Request::fullUrl());
//        dd(Request::query());
//        dd(Request::query('c', 'a'));
//        dd(Input::a);
//        dd(Input::has(['a', 'b']));/
//        dd(Input::filled('a'));
//        dd(Request::cookie());
//        dd(Request::cookie('xss-cookie'));
        echo "<pre>";
//        dd(Request::session('started', 'default'));
//        return Response::make('hello', 200) -> withHeaders(['hx1' => '22', 'hx2' => '33']);
//        return Redirect::away('https://www.google.com');
//        return Response::file('/home/kushagra/Downloads/myfile.pdf'); // not in 4.2
//        return View::first(['delivery.failure', 'delivery.success'], array('delivery_status' => 'failed', 'contact' => "Dan's number")); not in 4.2
    }
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

    public function checkIOCFunctionInjection(EventsCheckController $eve) {
        var_dump($eve);
    }

    public function filter($route, $request) {
        echo "Inside Filter -> ";
        // cannot use this beforeFilter and afterFilter when using the class for route::filter
//        $this -> beforeFilter('@filterRoutes');
//        $this -> afterFilter('@filterRoutes');
    }

    public function filterRoutes($route, $request, $response = null) {
        echo " Filtering inside filter routes .... ";
        return Response::make("Success");
    }

    public function useBladeProfiles() {
        return View::make('delivery.failure',  array('delivery_status' => 'failed', 'contact' => "Dan's number"));
//        $this -> layout -> content = View::make('blade.sidebar_left',  array('delivery_status' => 'failed', 'contact' => "Dan's number"));
//        return View::make('delivery.failure',  array('delivery_status' => "Check received at Dan's", 'contact' => "Dan's number"));
//        return Response::make("Hello Reponse successful", 200);
//        $this -> layout -> sidebar_left = View::make('delivery.failure',  array('delivery_status' => 'failed', 'contact' => "Dan's number"));
    }

    public function useControllerBladeProfiles() {
        $this -> layout -> content = View::make('blade.controllerBlade',  array('delivery_status' => 'failed', 'contact' => "Dan's number"));
//        $this -> layout -> content = View::make('blade.sidebar_left',  array('delivery_status' => 'failed', 'contact' => "Dan's number"));
//        return View::make('delivery.failure',  array('delivery_status' => "Check received at Dan's", 'contact' => "Dan's number"));
//        return Response::make("Hello Reponse successful", 200);
//        $this -> layout -> sidebar_left = View::make('delivery.failure',  array('delivery_status' => 'failed', 'contact' => "Dan's number"));
    }

    public function showWelcome()
    {
        print_r(Input::all()); // Input facade can give any type of input data sent it can also be php://input
        return View::make('hello') -> with("message", "created inside controller");
    }

    public function check() {
        var_dump(Route::currentRouteName());
        return View::make('home.check') -> with("message", "created check inside action");
    }

    public function responseMacro() {
        return Response::caps('kushagra');
    }

    public function returnCookieResponse() {
        Log::info('Hello world');
        Log::error('Hello world');
        Log::critical('Hello world');
        Log::warning('Hello world');
        Log::alert('Hello world');
        return Response::make('Hello Cookie');
    }

    public function getLetter($id = null, $function = null) {
//	    echo "<pre>";
//	    echo $id;
//	    echo PHP_EOL;
//	    echo $function;
//	    echo PHP_EOL;
        $oldData = Input::old();
//	    print_r($oldData);
        if(!empty($oldData)) {
            $name = Input::old('name');
            $password = Input::old('password');
        } else {
            $name = "";
            $password = "";
        }
//        echo PHP_EOL;
//	    echo $name;
//	    echo PHP_EOL;
//	    echo $password;
//	    echo PHP_EOL;
//	    print_r(Request::method());
//	    echo PHP_EOL;
//	    var_dump(Request::isMethod('post'));
//        echo PHP_EOL;
//        print_r(Request::path());
//        echo PHP_EOL;
//        print_r(Request::url());
//        echo PHP_EOL;
//        var_dump(Request::is('*/admin'));
//        var_dump(Request::is('(admin){1}/*')); // it is not actually a regular expression match. Because this should have give true for getLetter/admin/. This will only check if route starts and has the given expression in it.
//
//        echo PHP_EOL;
//        print_r(Request::segment(1));
//        echo PHP_EOL;
//        var_dump(Request::ajax());
//        echo PHP_EOL;
//        var_dump(Request::secure());
//        echo PHP_EOL;
//        var_dump(Request::isJson());
//        echo PHP_EOL;
//        var_dump(Request::wantsJson());
//        echo PHP_EOL;
//        var_dump(Request::format() == 'json');
//        echo PHP_EOL;
//        var_dump(Request::format() == 'html');
//        echo PHP_EOL;
//        print_r(Request::header());
//        echo PHP_EOL;
//        print_r(Request::server());
        if(Session::has('show_notification')) {
            echo Session::get('show_notification');
        }
        if(View::exists('home.base')) {
            return View::make('home.base', array('oldname' => $name, 'oldpassword' => $password, "delivery_status" => Session::get('delivery_status'), "show_notification" => Session::get('show_notification')));
        } else {
            return View::make('errors.views.notfound') -> with('message', 'Sorry Route was correct but no views found');
        }

    }
    public function postLetter() {
        echo "<pre>";
        $input = Input::all();
        // Input has can check if the value key is present and also if the value key is present but is empty
        if(Input::has('name')) {
            $name = Input::get('name');
        }
        if(Input::has('password')) {
            $password = Input::get('password');
        }
        if(Input::hasFile('file')) {
            $file = Input::file('file');
            print_r($file);
            echo PHP_EOL;
            print_r($file -> isValid());
            echo PHP_EOL;
            print_r($file -> getRealPath());
            echo PHP_EOL;
            print_r($file -> getClientOriginalName());
            echo PHP_EOL;
            print_r($file -> getClientOriginalExtension());
            echo PHP_EOL;
            print_r($file -> getSize());
            echo PHP_EOL;
            print_r($file -> getMimeType());
            echo PHP_EOL;
            $file -> move("..".DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR, $file -> getClientOriginalName());
        }
        print_r($input);
        echo "<hr />";
        print_r($name);
        echo "<hr />";
        print_r($password);
        echo "<hr />";
        print_r($file);
        echo "<hr />";
        print_r(Input::only('name', 'password'));
        echo "<hr />";
        print_r(Input::except('name', 'file'));
        echo "<hr />";
        Input::flash(); // flash will flash file also to session. But will not be able to redirect file in flash data. Laravel throws serialization error.
        print_r(Session::all());
        Input::flashOnly('name');
        Input::flashExcept('sbmt', 'file');
        // Multiple flashes will overwrite each other
        print_r(Session::all());
//        exit;
        return Redirect::route('letter.receive', array('status' => 'secured', 23, 'set1' => 3, 'set4' => 20)) -> with('delivery_status', 'failed') -> with('show_notification', "Yes Please"); // redirects to getLetter/admin?status=secured&23
//        return Redirect::action('HomeController@getLetter', array('user' => 1, 'function' => 'decider'));

        // Both below method produce same output
//        return Response::make([1,2,3,4]);
//        return [1,2,3,4];
//        return Response::make("Success", "200");
//        return Response::make("Success", "503");
//        return Response::view('delivery.success', array('delivery_status' => 'failed'), 404) -> header('processed', 'true') -> withCookie(Cookie::make('local_user', shell_exec('hostname'), 3600));
    }
    public function download() {
        return Response::download('../notes.txt', 'chinku.txt', array('Content-type' => "text/plain", "Content-Disposition", "inline; filename=chinku.txt")); // this will replace content-disposition's attachment value and will always set it to attachment even if we set it to inline but will not replace the filename= parameter.
    }

    public function user(User $user) {
        return Response::view('home.formModel', array('user' => $user), 200) -> header('encryption', 'DES');
    }

    public function susbcribeCheck($args) {
        echo "inside self subscribe check";
        print_r($args);
    }
    public function subscribe($event) {
//        $event -> listen('eve.fired.1', '@susbcribeCheck'); // this won't work. It works only for filter
        $event -> listen('eve.fired.1', 'HomeController@susbcribeCheck');
        $event -> listen('eve.fired.2', 'EventsCheckController@executeCallbacks');
    }

    public function fireEvent() {
        Event::fire('eve.fired.1', array('id' => 30));
        Event::fire('eve.fired.2', array('id' => 59));
    }

    public function storeCache()
    {
        echo "<pre>";
        echo Cache::get('dist_id', 'Default ID');
        echo Cache::get('dist_name', 'Default dist_name');
        print_r(Cache::get('new_dist', 'Default new_dist'));
        echo Cache::tags('public_history') -> get('new_dist', 'Default public_history');
        print_r(Cache::tags('public_history') -> get('tag_new_dist', 'Default public_history'));
        var_dump(Cache::tags('trusted') -> get('tag_new_dist', 'Default public_history'));
        var_dump(Cache::get('remembered', 'Default rememberd'));
        var_dump(Cache::get('rememberedForever', 'Default rememberedForever'));
        Cache::put('dist_id', 22, 3600);
        Cache::add('dist_name', 'rkg', 3600);
        Cache::forever('new_dist', [1, 2, 4], 3300);
        // Serialization of 'class@anonymous' is not allowed in memcached
//        Cache::forever('new_dist', json_encode(new class {
//            public $i = 30;
//            private $d = 40;
//        }), 5300);
        $cl = new class {
            public $i = 30;
            private $d = 40;
        };
        echo json_encode([1,2,4]);
        echo json_encode($cl);
        // tags are not available for file and database
        Cache::tags('public_history') -> add ('tag_new_dist', [123,34], 3600);
        // not allowed in memcached
//        Cache::tags('public_history, trusted') -> add ('tag_new_dist', $cl, 3600);
        Cache::remember('remembered', 3600, function() {
            return array(
                'apples',
                'oranges'
            );
        });
        Cache::rememberForever('rememberedForever', function() {
            return array(
                'apples',
                'oranges'
            );
        });
        if(Session::has('putvar')) {
            print_r(Session::get('putvar'));
        }
        Session::put('putvar', 30000000000);
        print_r(Session::get('pushvar'));
        Session::push('pushvar', 12);
    }

    public function sendMail() {
//        var_dump(Mail::send(array('text' => 'email.textmail'), array('variable' => "Message Sent"), function($message) {
//            $message -> to('kushagra.mishra05121987@gmail.com') -> subject("Test Email") -> attach('/home/kushagra/Downloads/08IyrVQ8k9ZssUnX0NDAuJYb6fy.jpg', ['as' => 'motimaal.jpg', 'mime' => 'image/jpg'])->cc('desparados.me@gmail.com');
//        }));
        Mail::send('email.mail', ['variable' => "Message Sent"], "setMailContents");
//        Mail::queue('email.mail', ['variable' => "Message Sent"], "setMailContents");
//        Mail::later(5, 'email.mail', ['variable' => "Message Sent"], "setMailContents");
        try {
//            var_dump(\Mail::queue('email.mail', array('variable' => "Message Sent"), function($message) {
//                $message -> to('kushagra.mishra05121987@gmail.com', 'Kushagra Mishra')
//                    -> subject("Test Email");
//            }));

//            Mail::pretend();
//            Mail::send([], [], function($message)
//            {
//                $message->to('kushagra.mishra05121987@gmail.com', 'John Smith')->subject('Welcome!') -> setBody('This is a mail');
//            });
        } catch(Throwable $t) {
            echo $t -> getMessage();
        }

    }

    public function pullLang() {
        App::setLocale('ru');
        echo Lang::get('tmessage.apples');
        echo "<br/>";
        echo Lang::choice('tmessage.apples', 10);
        echo "<br/>";
        echo Lang::get('tmessage.orange', ['color' => 'red']);
        echo "<br/>";
        echo Lang::choice('tmessage.papaya', 19, ['color' => 'yellow']);
        echo "<br/>";
        echo Lang::choice('tmessage.papaya', 90, ['color' => 'yellow'], 'en');
        echo "<br/>";
    }

    public function validation() {
        echo "<pre>";
        $inputPretend = array(
            'email' => 'kariz',
            'name' => 'Kusha',
            'password' => '222',
            'age' => 30,
            'salary' => 1210000
        );
        $rules = array(
            'email' => 'required|email|max:10',
            'name' => 'required|alpha|min:10',
            'password' => 'required|size:8',
            'age' => 'sometimes|required'
        );
        $validator = Validator::make($inputPretend, $rules, array(
            'email.required' => 'This email is needed for monitoring purposes.',
            'size' => 'We need to have this minimum :attribute field with :size.'
        ));

        $validator -> sometimes('salary', 'required|kushagra_rule:12,99|dumb:200|dumber:900', function($input) use ($inputPretend) {
            echo "Printing input \n";
            print_r($input); // $input is the input array passed for validation its not the actual input received from request.
            echo "Exiting \n";
            return $input -> age >= 30;
        });

//        $validator -> validate(); not in 4.2

        if($validator -> fails()) {
            print_r($messages = $validator -> messages());
            print_r($validator -> failed());
            echo $messages->first('email', '<b>:message from first</b>');
            echo "<br />";
            print_r($messages->get('name', '<b>:message from get.</b>'));
            echo "<br />";
            foreach ($messages->get('password', '<b>:message from get.</b>') as $message)
            {
                print_r($message);
                echo "<br />";
            }
            foreach ($messages->all('<b>:message from get.</b>') as $message)
            {
                print_r($message);
                echo "<br />";
            }
            echo "</pre>";
//            exit;
            return Redirect::to('displayValidationErrors') -> withErrors($validator);
        }


    }

    public function displayValidationErrors() {
        echo "inside vaidation redirect";
//        Artisan::call('run:tests', array(
//            "a1" => 20, "a3" => 390, '--option2' => 23, '--option3' => [34, 44], '--option4'
//        ));
        return View::make('validations.validations');
    }

    public function fireJobs() {
//        \Queue::push('JobHandler', ['del_job' => true, "timeout" => 3], 'queue1');
        \Queue::push('JobHandler@sendMail', [], 'queue1');
//            \Queue::bulk(['JobHandler@processJobs', \OtherJobHandler::class, "OtherJobHandler@processJobs"], ['del_job' => false, "timeout" => 20, 'release' => true], 'queue2');
//            \Queue::push(\OtherJobHandler::class, ['del_job' => true, "timeout" => 10, 'release' => true, 'release_delay' => 10], 'queue3');
//            \Queue::push('JobHandler@processJobs', ['del_job' => true, "timeout" => 2, 'release' => false, 'fail_job' => true], 'queue4');
    }

    public function db() {
        echo "<pre>";
        echo PHP_EOL;
        DB::transaction(function() {
            echo "============= All Initial Users =========== \n";
            print_r(DB::select('select * from users'));
            echo PHP_EOL;
//            echo "============= Inserting New Users =========== \n";
            print_r(DB::insert('insert into users(name, email, password) values (:name1, :email1, :password1), (:name2, :email2, :password2), (:name3, :email3, :password3)', array(
                'name1' => 'Stshu3jskjfd', 'name2' => 'sase2u323e', 'name3' => '45redfaudasud',
                'password1' => 'rieriweoweklskfjlf', 'password2' => 'sdifseiweoweklskfjlf', 'password3' => 'asda3eadiweoweklskfjlf',
                'email1' => 'rier@idkfaduasiudkjasasd.coom', 'email2' => 'sdifse@kdisfaduasiasddkj.com', 'email3' => 'asda3easadd@odfauasiudkj.cmm'
            )));
//            print_r(DB::insert('insert into users(name, email, password) values (:name, :email, :password)', array(
//                'name' => 'Kushagra','password' => '75793sjs','email' => 'riersss@gmail.coom'
//            )));
            echo PHP_EOL;
            echo "============= Updating Users =========== \n";
            print_r(DB::update('update users set email="rier@gmailww.coom" where email=?', array('rier@gmail.coom')));
            echo PHP_EOL;
//            DB::beginTransaction();
            try{
                echo "============= Select Users from delete =========== \n";
                // This won't generate any issues . All delete and updates from DB class return the count of the result set. They don't check if the query was actually delete of update. So if we fire an update query from delete it will work and return the number of row updated.
                DB::transaction(function() {
                    print_r(DB::delete('update users set phone=? where id=3', array('2232666')));
                    echo "============= Update Users from delete =========== \n";
                    print_r(DB::delete('update users set phone="3647474" where phone ?', array('IS NULL')));
                });


                echo PHP_EOL;
                echo "============= Delete Users =========== \n";
                print_r(DB::delete('delete from users where id=?', [9]));
                echo PHP_EOL;
                echo "============= Statement select Users =========== \n";
                print_r(DB::statement('select * from users'));
//                print_r(DB::update('insert into users(name, email, password) values (:name1, :email1, :password1), (:name2, :email2, :password2), (:name3, :email3, :password3)', array(
//                    'name1' => 'Stshu3jskjfd', 'name2' => 'sase2u323e', 'name3' => '45redfaudasud',
//                    'password1' => 'rieriweoweklskfjlf', 'password2' => 'sdifseiweoweklskfjlf', 'password3' => 'asda3eadiweoweklskfjlf',
//                    'email1' => 'rier@idkfaduasudkasdasd.coom', 'email2' => 'sdifse@kdisfduasasdudkj.com', 'email3' => 'asdaeasadd@odfadasiudkj.cmm'
//                )));
//                DB::commit();
            } catch(Throwable $t) {
                echo PHP_EOL;
                print_r($t -> getMessage());
                DB::rollback();
            }
            echo PHP_EOL;
        }, 3);
        print_r(DB::getQueryLog());
        print_r(DB::connection()->getPdo());
        print_r(DB::getPdo());
    }

    public function nestedtransactions() {
        echo "<pre>";
        $PdoSavePoints = new PdoSavePoints;
        $PdoSavePoints -> beginTransaction();
        try{
            $PdoSavePoints -> insert(
                'insert into users(name, email, password, phone) values (:name, :email, :password, :phone)',
                array(
                    'name' => 'i4jskd','password' => '3eqpow','email' => 'a9dsk@gmail.coom', 'phone' => '88999887'
                )
            );

//            DB::update(
//                'update users set email=? where email=?',
//                array(
//                    'hashjh@gmail.com', 'rangesss@gmail.coom'
//                )
//            );
//
            $PdoSavePoints -> beginTransaction();
            try{
//                DB::table('testUsers') -> insert([array('name' => "Dan", "phone" => "75757"), array('name' => "Man", "phone" => 4848), array("name" => "Chan", "phone" => '55833')]
//                );
                $PdoSavePoints -> table('testUsers') -> insert(array('name' => "Stansieul", "phone" => "757599"));

//                DB::connection('mysql')->table('testUsers') -> where('name', 'Stansy') -> update(['id' => '14']);
                throw new Exception("Error Occured while processing request.", 404);
                $PdoSavePoints -> commit();
            } catch(Throwable $t) {
                echo "\n Error Occured In Inner Transaction Rolling Back\n ";
                echo "\n {$t -> getMessage()} \n";
                $PdoSavePoints -> rollback();
            }
            $PdoSavePoints -> insert(
                'insert into users(name, email, password, phone) values (:name, :email, :password, :phone)',
                array(
                    'name' => '85sajs8dj','password' => 'aesasd','email' => '95osjsjk@gmail.coom', 'phone' => '434344393049'
                )
            );
            $PdoSavePoints -> commit();
        } catch(Throwable $t) {
            echo " \n Error Encountered in Main transaction. Aborting Main \n ";
            echo "\n {$t -> getMessage()} \n";
            $PdoSavePoints -> rollback();
        }
    }

    public function queryBuild() {
        // returns complete database query build object as opposed to DB static query which returned only std class objects. get returns std class object.
        echo "<pre>";
        // select * from `users` inner join `testUsers` on `users`.`id` = `8`)
        // join is inner join
        $queryBuilderObject = DB::table('users') -> join('testUsers', 'users.id', '=', 'testUsers.id');
//        print_r($queryBuilderObject); // This here gives query builder object
        $queryBuilderObject2 = DB::table('users') -> join('testUsers', function($join) {
//            $join -> on('users.id', '=', 'testUsers.id') -> where('users.id', '=', '8');
            $join -> where('users.id', '=', '8');
        });
        // only when we use get puck or lists it will execute the query and return a normal object. And only when we do get `
        $result = $queryBuilderObject -> get();
        print_r($result);
        echo "\n Starting Dump 1\n";
        foreach($result as $key => $value) {
            echo "\n";
            print_r($key);
            echo "\n";
            print_r($value);
            echo "\n ======================== \n";
        }
        $result = $queryBuilderObject2 -> get();
        echo "\n Starting Dump 2\n";
        foreach($result as $key => $value) {
            echo "\n";
            print_r($key);
            echo "\n";
            print_r($value);
            echo "\n ======================== \n";
        }
        /**
         * Illuminate\Database\Query\Expression Object
        (
        [value:protected] => select * from testUsers
        )
         */
        // So as we can see DB::raw only returns expression object we cannot execute a query using it we can only use in inside any other sub methods such as select update etc
        print_r(DB::raw("select * from testUsers"));
        DB::table(DB::raw('(select * from testUsers) as tu')) -> select('tu.name') ->get();
        DB::select(DB::raw('select tu.name from (select * from testUsers) as tu'));
        print_r(DB::table('users') -> select('id', 'name') -> union(DB::table('testUsers') -> select('id', 'name')) ->get());

        // If the query changes a new cache is inserted but if old query is fired within the specified amount of time then it will be loaded from cache only and no query is fired . This can be checked from the fact that DB::listen will not fire is is fetched from cache.
        print_r($users = DB::table('users') -> where('id', '>', '20') -> where('id', '<', 30) ->remember(10)->get());
        print_r(DB::getQueryLog());
    }

    public function createSchema() {
        // same as dropIfExists
//        if(Schema::hasTable('comments')) {
//            Schema::drop('comments');
//        }
////
//        if(Schema::hasTable('post_comments')) {
//            Schema::drop('post_comments');
//        }
////
//        if(Schema::hasTable('posts')) {
//            Schema::drop('posts');
//        }
////        // create will not automatically perform check if table exists or not
//        Schema::create('posts', function(Blueprint $table) {
//            $table -> engine = "InnoDB";
//            $table -> increments('id'); //-> primary()
//            $table -> string('content');
//            $table -> integer('user_id') -> unsigned();
//            $table -> foreign('user_id') -> references('id') -> on('users') -> onDelete('cascade');
//            $table -> softDeletes();
//            $table -> timestamps();
//        });
//        Schema::create('comments', function(Blueprint $table) {
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
//
//
////        $table = new Blueprint('post_comments');
////        $table->renameColumn('content', 'comment');
//
//        // $table->dropColumn(array('votes', 'avatar', 'location'));
//        var_dump(Schema::hasColumn('users', 'email'));
//        Schema::rename('comments', 'post_comments');
        Schema::table('post_comments', function($table) {
//            $table -> string('type', 100)->default('parent') -> after('content');
//            $table -> enum('lightings', ['on', 'off'])->default('on');
//            $table -> dropColumn('lightings');
//            $table -> enum('lights', ['on', 'off'])->default('on') -> after('content');
//            $table -> enum('lights', ['on', 'off'])->default('on') -> before('content');
            $table -> integer('type') -> nullable() -> change();

//            $table -> renameColumn('content', 'comments'); doesnt work
        });

//        Schema::table('post_comments', function($table) {
////            $table -> string('type', 100)->default('parent') -> after('content');
////            $table -> enum('lightings', ['on', 'off'])->default('on');
////            $table -> dropColumn('lightings');
////            $table -> enum('lights', ['on', 'off'])->default('on') -> after('content');
////            $table -> enum('lights', ['on', 'off'])->default('on') -> before('content');
//            $table -> string('type') -> nullable() -> change();
//
////            $table -> renameColumn('content', 'comments'); doesnt work
//        });

    }

    public function modelQueryUsers() {
        echo "<pre>";
        print_r(User::find(1));

        try{
            print_r(User::where('id', '>', '1') -> findOrFail(3));
            print_r(User::findOrFail(34));
            print_r(User::firstOrFail());
            print_r(User::where('id', '2') -> firstOrFail());
            print_r(User::where('id', '>', '1') -> firstOrFail());
        } catch(Throwable $t) {
            echo $t -> getMessage();
        }

        print_r(User::where('id', '>', '1') -> get());
        print_r(User::whereRaw('id > 1') -> get());
        print_r(User::whereRaw('id > 1') -> get());
        print_r(User::where('id', '1') -> where(function($query) {
            $query -> where('id', '2') -> where('name', 'Ets');
        }) -> get());
        print_r(User::where('id', '1') -> orWhere(function($query) {
            $query -> where('id', '2') -> where('name', 'Ets');
        }) -> get());
        echo "\n ===Chunk=== \n";

        User::chunk(1, function($users) {
            foreach ($users as $user) {
                echo $user -> name;
                echo PHP_EOL;
            }
        });

    }

    public function modelQueryDuplicates() {
        echo "<pre>";
        echo "\n ===ALL=== \n";
        print_r(Duplicates::find(1));

        echo "\n ===Find or fail(3)=== \n";
        try{
            print_r(Duplicates::where('id', '>', '1') -> findOrFail(3));

        } catch(Throwable $t) {
            echo $t -> getMessage();
        }

        echo "\n ===Find Or fail (34)=== \n";
        try{
            print_r(Duplicates::findOrFail(34));
        } catch(Throwable $t) {
            echo $t -> getMessage();
        }
        echo "\n ===First Or fail (empty)=== \n";
        try{
            print_r(Duplicates::firstOrFail());
        } catch(Throwable $t) {
            echo $t -> getMessage();
        }
        echo "\n ===First Or fail (empty) where id 2=== \n";
        try{
            print_r(Duplicates::where('id', '2') -> firstOrFail());
        } catch(Throwable $t) {
            echo $t -> getMessage();
        }
        echo "\n ===First Or fail (empty) where id > 1=== \n";
        try{
            print_r(Duplicates::where('id', '>', '1') -> firstOrFail());
        } catch(Throwable $t) {
            echo $t -> getMessage();
        }
        echo "\n ===First Or fail (empty) where id 1=== \n";
        try{
            print_r(Duplicates::where('id', '1') -> firstOrFail());
        } catch(Throwable $t) {
            echo $t -> getMessage();
        }
        echo "\n ===Find Or fail (1) === \n";
        try{
            print_r(Duplicates::findOrFail(1));
        } catch(Throwable $t) {
            echo $t -> getMessage();
        }

        print_r(Duplicates::where('id', '>', '1') -> get());
        print_r(Duplicates::whereRaw('id > 1') -> get());
        print_r(Duplicates::whereRaw('id > 1') -> get());
        print_r(Duplicates::where('id', '1') -> where(function($query) {
            $query -> where('id', '2') -> where('name', 'Ets');
        }) -> get());
        print_r(Duplicates::where('id', '1') -> orWhere(function($query) {
            $query -> where('id', '2') -> where('name', 'Ets');
        }) -> get());

        Duplicates::chunk(1, function($users) {
            foreach ($users as $user) {
                echo $user -> name;
                echo PHP_EOL;
            }
        });

    }

    public function createModel() {
//        echo "<pre>";
//        echo "\n ======== Creating using create ========= \n";
//        print_r($userC = User::create(array(
//            'name' => "4th person", 'email' => 'uruuri@gg.com', 'password' => 'aieoqwd', 'id' => '99'
//        )));
//        // using above way we will not be able to set id and password thats why in db id is autoincremented and password is empty
//        echo "\n Saved User -> {$userC -> id}\n";
//        $userC -> id = 99;
//        $userC -> password =  'yryruru';
//        $userC -> save();
//        echo "\n Saved User -> {$userC -> id}\n";
//        echo "\n ======== Creating using new ========= \n";
//        print_r($userN = new User(['name' => "6th person", 'email' => 'a3@gg.com']));
//        $userN -> id = 33;
//        $userN -> password = Hash::make('832984elka');
//        $userN -> save();
//        echo "\n ======== Updating using new ========= \n";
//        $usersU = new User;
//        $usersU -> id = 52;
//        $usersU -> password = 'ajsdaksda';
//        $usersU -> save();

        // Retrieve the user by the attributes, or create it if it doesn't exist...
        // This persists the record in db and return the model instance
//        print_r($user = User::firstOrCreate(array('name' => 'Johns', 'email' => 's')));

        // Retrieve the user by the attributes, or instantiate a new instance...
        // This does not persists the record in db and return the model instance so that we can call save()
//        print_r($user = User::firstOrNew(array('name' => 'Johnyy', 'email' => 'ss')));
        // This method touch will not only update timestamps but also change save the record in db. Which can logically be understood because it has to update create_at field so record first needs to be creted.
//        $user->touch();

        echo "\n ==== Soft Deleting ====\n";
        echo "<pre>";
//        $user = User::withTrashed() -> find(5);
//        $user -> withTrashed() -> where('id', 5) -> restore();
//        $user -> destroy(5);
//        $user = User::onlyTrashed() -> find(5);
//        print_r($user -> name);
//        // it will update the updated_at timestamp
////        print_r($user -> restore());
//
////        print_r($user -> forceDelete());
//
//        var_dump($user -> trashed());
//
//        var_dump($user -> email(5) -> pluck('name', 'email'));
//        var_dump($user -> email(5) -> lists('email'));
//        //below is just a generalization of what i ahve done above
//        var_dump($user -> email(5) -> get(['email']));

//        $user = new User();
//        $user ->name = "Nmaing";
//        $user -> password = Hash::make('skjkaska');
//        $user -> email = "asdjs]ksjnskdk";
//        $user -> save();

//        $user = User::find(1);
//        $user -> name = "updated name";
//        $user -> save();

//        $user = User::find(19);
//        echo $user -> created_at -> format('d-m-Y');

//        $user = new User();
//        $user -> password = Hash::make('kasldkjalsjdl');
//        $user -> name = 'kushagraagain';
//        $user -> email = '4ssdksd9';
//        $user -> save();
//        print_r($user -> find(1) -> get(['name', 'email']));
//        print_r($user -> find(1) -> pluck('name' ,'email'));
//        echo "\n Pluck for multiple rows \n";
//        print_r($user -> find(1) -> pluck('name' ,'email'));
//        print_r(User::pluck('name' ,'email'));
//        print_r($user -> where('id', '>=', '1') -> pluck('name' ,'email'));
//        print_r($user -> find(1) -> lists('id', 'name', 'email'));

        // Not allowed only one array is allowed
//        $user = new User([
//            ['name' => "Dummy1", "email" => 'dummy1@dummy.com', 'password' => \Hash::make('secret')] ,
//            ['name' => "Dummy2", "email" => 'dummy2@dummy.com', 'password' => \Hash::make('secret')]
//        ]);
        // id and password are guarded thats why its not allowing mass assignment.
//        $user = new User(['name' => "Dummy1", "email" => 'dummy2@dummy.com', 'password' => Hash::make('secret')]);
//
//        $user -> save();

        // This is also not allowed only one array is allowed same as new user
//        User::create([
//            ['name' => "Dummy1", "email" => 'dummy3@dummy.com', 'password' => \Hash::make('secret')] ,
//            ['name' => "Dummy2", "email" => 'dummy4@dummy.com', 'password' => \Hash::make('secret')]
//        ]);
//
        $user = new User;
        // these are als not allowed
//        $user -> save(['name' => "Dummy1", "email" => 'dummy3@dummy.com', 'password' => \Hash::make('secret')]);
//        $user -> saveMany([
//            ['name' => "Dummy1", "email" => 'dummy3@dummy.com', 'password' => \Hash::make('secret')] ,
//            ['name' => "Dummy2", "email" => 'dummy4@dummy.com', 'password' => \Hash::make('secret')]
//        ]);
//        $user -> updateOrCreate([
//            "name" => "kushagra", "email" => "dangessrw", 'remember_token' => 'danss_tok'
//        ]);
//        $user -> updateOrCreate([
//            "name" => "kushagra",
//            'email' => "mamas"
//        ], ['email' => 'mamaz']);
        $user -> firstOrCreate([
            "name" => "kushagra",
            'email' => "mamas"
        ], ['remember_token' => 'mamaz']);

    }

    public function  callJmin() {
        echo "<pre>";
        JMin::startMinification();
    }
    public function redirectTo() {
        return Redirect::to('getLetter', array('status' => 'secured', 23, 'set1' => 3, 'set4' => 20));
    }

    public function relationships() {
        // User
//        $user = User::find(2);

//        var_dump($user -> posts());exit;

        // New Post
//        $posts = new Posts();
//        $posts -> content = "Content posted";
//        $posts -> save();

        // attaching current post to user_id
//        $posts -> user() -> associate($user);
        
//        $posts->save();

//        $post = Posts::find(5);

//        $comment = new PostComments();
//        $comment -> type = 'child';
//        $comment -> content = 'Comment Posted';
//
//        $comment -> posts() -> associate($post) -> save();

//        $comment = PostComments::find(4);
//
//        $comment2 = new PostComments();
//        $comment2 -> type = 'child';
//        $comment2 -> content = 'Comment 2 Posted';
//        $comment2 -> posts() -> associate($post);
//        $comment2 -> post_comments() -> associate($comment);
//
//        $comment2 -> save();

//        $user = new User();
//        $user -> name = "Random name";
//        $user -> password = "Random Password";
//        $user -> email = "random30Email@gmail.com";
//        $user -> save();
//
//        $posts = new Posts();
//        $posts -> content = "Content posted";
//        $user -> posts() -> save($posts);
//
//        $comments = new PostComments();
//        $comments -> type = 'child';
//        $comments -> content = 'Comment 2 Posted';
//        $comments -> post_comments() -> associate(PostComments::find(8));
//        $posts -> post_comments() -> save($comments);

//        $user = User::find(48) -> get();
//        echo "<pre>";
//        $user -> comments -> each(function($comment) {
//            echo "\n {$comment -> content} \n";
//        });
//        echo "</pre>";

//        $user = new User();
//        $user -> name = "Random name";
//        $user -> password = "Random Password";
//        $user -> email = "random40Email@gmail.com";
//        $user -> save();

//        $post = Posts::find(5) -> post_comments() -> where('id', '4') -> get();
//        Symfony\Component\VarDumper\VarDumper::dump($post );
//        $user = User::find(48);
//
//        $role = Roles::find(2);

//        Symfony\Component\VarDumper\VarDumper::dump($user -> roles() -> wherePivot('id', 11) -> first() -> pivot -> options );
//        echo "<pre>";
//        $user -> roles -> each(function($role) {
//            Symfony\Component\VarDumper\VarDumper::dump($role -> pivot -> role_id);
//        });
//        echo "</pre>";

//        var_dump($user -> pivot -> get());

//        $user -> roles() -> save($role, ['options' => json_encode(['p' => ['model' => ['name' => "Star", "size" => '33 inch', 'color' => 'red_black'], ['name' => 'Blizzard', 'size' => "55 inch", "color" => 'grey']]])]);
//        echo "<pre>";
//            var_dump($role -> pivot);
//        echo "</pre>";

//        $user = User::has('Posts');
//        Symfony\Component\VarDumper\VarDumper::dump($user -> count());
//        $user = User::has('Posts.post_comments'); // user has strtolower(Posts) and Posts has strtolower('post_comments')
//        Symfony\Component\VarDumper\VarDumper::dump($user -> count());
//
//        $user = User::has('Posts.post_comments'); // user has strtolower(Posts) and Posts has strtolower('post_comments')
//        Symfony\Component\VarDumper\VarDumper::dump($user -> count());

//        $user = User::withCount(['Posts.post_comments']); // user has strtolower(Posts) and Posts has strtolower('post_comments')
//        Symfony\Component\VarDumper\VarDumper::dump($user);


//        $users = User::with('Posts') -> get();
//        $users = User::with('Posts.post_comments') -> get();
////        $users = User::with(['Posts','comments']) -> get();
//        foreach ($users as $user) {
//            Symfony\Component\VarDumper\VarDumper::dump($user -> id);
//            if($user -> posts) {
//                Symfony\Component\VarDumper\VarDumper::dump($user -> posts -> content);
//                Symfony\Component\VarDumper\VarDumper::dump($user -> posts -> post_comments);
////                Symfony\Component\VarDumper\VarDumper::dump($user -> comments -> first());
//                if($user -> posts -> post_comments) {
//                    Symfony\Component\VarDumper\VarDumper::dump($user -> posts -> post_comments -> content);
//                }
//            }
//
//        }

//        $users = User::with('Posts.post_comment') -> get();
//        foreach ($users as $user) {
//            Symfony\Component\VarDumper\VarDumper::dump($user -> id);
//            Symfony\Component\VarDumper\VarDumper::dump($user -> posts);
//
//        }
//        $users = User::with(['Posts', 'Roles']) -> get();
//        foreach ($users as $user) {
//            Symfony\Component\VarDumper\VarDumper::dump($user -> id);
//            foreach ($user -> posts() -> get() as $post) {
//                Symfony\Component\VarDumper\VarDumper::dump($post -> content);
//            }
//            foreach ($user -> roles() -> get() as $role) {
//                Symfony\Component\VarDumper\VarDumper::dump($role -> name);
//            }
//
//        }
        Symfony\Component\VarDumper\VarDumper::dump(User::find(2) -> posts -> content);
    }
}

<?php

namespace App\Http\Controllers;

use App\Comments;
use App\Http\Resources\UserCollection;
use App\Post;
use App\User;
use App\Video;
use Illuminate\Http\Request;
use \App\Http\Resources\User as UserResource;

class HomeTownController extends Controller
{
    //
    public function queryingDB() {
//        \App\User::ofType(1)->get(); //Doesnot exist
//        $user = new \App\User();
//        $user -> name = "Kushagra";
//        $user -> email = "kusha@gmail.com";
//        $user -> password = "anldal";
//        $user -> save();
//        return response('Hello', 200);
        $user = \App\User::find(14);
        \Dumper::dump($user -> name);
        \Dumper::dump($user -> email);
        \Dumper::dump($user -> remember_token);
        \Dumper::dump($user -> options);
        // direct modification is not possible
        $options = $user -> options;
        $options['p']['name'] = "bright Flat";
        $user -> options = $options;
//        $user -> save();
        \Dumper::dump($user -> toArray());
        \Dumper::dump($user -> toJson(JSON_PRETTY_PRINT));
        \Dumper::dump((string) $user);

        \D::dump(\App\User::find(14) -> makeVisible('password') -> toArray());
        \D::dump(\App\User::find(14) -> makeHidden('name') -> toArray());
        \D::dump(\App\User::find(14) -> append('is_prop') -> toArray());
        \D::dump(\App\User::find(14) -> setAppends(['is_drop', 'is_prop']) -> toArray());

//        foreach($user as $u) {
//            \Dumper::dump($u -> remember_token);
//            \Dumper::dump($u -> name);
//        }


    }
    public function getUserResources() {
//        $user = \App\User::with(['posts' => function($q) {
//            $q -> where('id', '5');
//        }, 'roles', 'user_roles']) -> get();

//        $user = \App\User::find(2);
//        dd($user -> posts);
//        foreach($user as $u) {
//            if($u -> posts) {
//                foreach($u -> posts as $post) {
//                    \Dumper::dump($post -> content);
//                }
//            }
//            if($u -> roles) {
//                foreach($u -> roles as $role) {
//                    \Dumper::dump($role -> name);
//                }
//            }
//        }
//        $user = \App\User::withCount(['posts', 'comments']) -> get();
//        foreach ($user as $u) {
//            \Dumper::dump($u -> name);
//            \Dumper::dump($u -> posts_count);
//            \Dumper::dump($u -> comments_count);
//        }

//        $post = new \App\Post;
//        $post -> content = "This is kushagra content";
//
//        $post2 = new \App\Post;
//        $post2 -> content = "This is kushagra content";
//
//        $post3 = new \App\Post;
//        $post3 -> content = "This is kushagra content";

        $user = \App\User::find(2);
//        $user -> posts() -> saveMany([
//            $post, $post2, $post3
//        ]);
//        $user -> posts() -> createMany([
//            ['content' => "content 1"],
//            ['content' => "content 2"],
//            ['content' => "content 3"],
//        ]);

        $user -> roles() -> toggle([1,2,3]);


//        return (new UserResource($user));
//        return (UserResource::collection($user));
//        return (new UserCollection($user));
    }
    public function nm() {
//        $user = \App\User::find(48);
//        $role = \App\Roles::find(1);
//        $options = $user -> roles() -> where('role_id', 1) -> wherePivot('id', 11) -> wherePivot('options->p->model->name', '\"Star\"') -> get();
////        dd($options  -> pivot);
//        foreach($options as $u) {
//            \Dumper::dump($u -> pivot -> options);
//        }

        $comment = new Comments(["content" => "My New comment"]);
        $comment2 = new Comments(["content" => "My New comment 2"]);

        $video = new Video();
        $video -> name = "Training Video.mp3";
        $video -> save();
        $video -> comments() -> saveMany([$comment, $comment2]);

//        $user = new User();
//        $user -> name = "Kushagra";
//        $user -> email = "kushsa@gmail.com";
//        $user -> password = "anldal";
//
//
//        $post = new Post();
//        $post -> content = "This is a post content";
//        $post -> user() -> associate($user) -> save([$comment2]);


    }

    public function checkAuth() {
//        return view('components');
        echo "<pre>";
        $post = \App\Post::find(4);
        if(\Gate::allows('updatepost', $post)) {
            echo "<br/>inside true update post allows<br/>";
//            return response('Hello World 1', 200);
        }
        echo "<hr />";
        if(\Gate::allows('authPost', $post)) {
            echo "<br/>Inside true authPost allows<br/>";
//            return response('Hello World 2', 200);
        }
        echo "<hr />";
        if(\Gate::denies('post.view', $post)) {
            echo "<br/>Inside true post.view denies<br/>";
        }
        if(\Gate::denies('post.create', $post)) {
            echo "<br/>Inside true post.create denies<br/>";
        }
        if(\Gate::allows('post.update', $post)) {
            echo "<br/>Inside true post.update allows<br/>";
        }
        if(\Gate::allows('post.delete', $post)) {
            echo "<br/>Inside true post.delete allows<br/>";
        }
//
        if($this -> authorize('post.delete', $post)) {
            echo "<br/>Inside true post.delete authorize<br/>";
        }
        if($this -> authorize('delete', $post)) {
            echo "<br/>Inside true post.delete authorize for policy<br/>";
        }

        echo "<hr />";
        echo "<hr />";
        $user = User::find(1);
        var_dump($user -> can('update', $post));
        echo "<hr />";

        var_dump($user -> can('delete', $post));
        echo "<hr />";

        var_dump($user -> cant('view', $post));
        echo "<hr />";

        var_dump($user -> cant('post.view', $post));
        echo "<hr />";

        var_dump($user -> cannot('create', $post));
        echo "<hr />";

        var_dump($user -> cannot('views', $post));
        echo "<hr />";
    }

    public function checkAuthBlade() {
        return view('components');
    }

    public function createClient() {
//        dd(\Cookie::get('laravel_session'));

        dd(file_get_contents('http://laravel.test.v5:8080/oauth/clients'));
    }

}

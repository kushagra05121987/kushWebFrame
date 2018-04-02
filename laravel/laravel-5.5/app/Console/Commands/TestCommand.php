<?php

namespace App\Console\Commands;

use App\Mail\UserTestMail;
use App\Notifications\testnotification;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\User as User;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $storage = Storage::disk('public');
        $storage -> put('testfile.txt', 'this is test data');
        Storage::put('testfile', 'this is test data');
        echo asset('storage/testfile');
        echo Storage::get('public/testfile.txt');
        echo Storage::url('fileDoesNotExists.txt');
        echo PHP_EOL;
        echo Storage::putFileAs('public/', new File('storage/app/testfile'), '1.txt');
        echo PHP_EOL;
        echo Storage::putFile('public/', new File('storage/app/testfile'));
        echo PHP_EOL;
        echo App::isDownForMaintenance();
        echo PHP_EOL;
//        echo Mail::to("karizmatic.kay@gmail.com") -> queue(new UserTestMail(["message" => "this is test data"]));
//        $users = new User();
//        $users -> name = "Mishra";
//        $users -> email = "kushagra.mishra05121987@gmail.com";
//        $users -> password = "34699";
//        $users -> save();
        $usersAll = User::all() -> first();
//        $usersAll = User::all(); // notifications do not work on collections

//        $users -> notify(new testnotification());

//        $users -> route('mail', 'kushagra.mishra05121987@gmail.com')
//            -> route('mail', 'karizmatic.kay@gmail.com') -> notify(new testnotification()); // wont work
//        Notification::send($usersAll, new testnotification());
//        Notification::route('mail', 'kushagra.mishra05121987@gmail.com')
//            -> route('mail', 'karizmatic.kay@gmail.com') -> notify(new testnotification());
//        $usersAll -> notify(new testnotification($usersAll));
        $this -> comment($usersAll -> notifications);
        $this -> comment($usersAll -> unreadNotifications);
        $this -> comment($usersAll -> notifications -> markAsRead());
        $this -> comment($usersAll -> unreadNotifications -> markAsRead());
        $this -> comment($usersAll -> unreadNotifications);

//        Notification::route('nexmo', '09632491417') -> notify(new testnotification($usersAll));
        $usersAll -> notify(new testnotification($usersAll));

    }
}

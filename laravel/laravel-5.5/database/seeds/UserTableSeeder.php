<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = factory(\App\User::class, 5) -> states('email') -> make([
            'name' => 'TYpo Name'
        ]);
        \Dumper::dump($user);

        $user = factory(\App\User::class, 5) -> states('username', 'email') -> create([
            'remember_token' => "not found"
        ]);
        \Dumper::dump($user);
    }
}

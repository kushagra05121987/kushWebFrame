<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17/4/18
 * Time: 6:07 PM
 */
class UserTableSeeder extends Seeder {
    public function run() {
        DB::table('users') -> delete();
        DB::table('users') -> insert([
            ['name' => 'Kushagra', 'email' => 'kari@ff.com', 'password' => Hash::make('aik3')],
            ['name' => 'Ets', 'email' => 'sd@ff.com', 'password' => Hash::make('asdas')],
            ['name' => '8eoie', 'email' => 'aksdk@ff.com', 'password' => Hash::make('askdas')],
        ]);
    }
}
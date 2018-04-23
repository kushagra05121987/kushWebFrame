<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/4/18
 * Time: 12:07 PM
 */

class DuplicatesTableSeeder extends Seeder {
    public function run() {
        DB::table('duplicates') -> insert(array(
            ['id' => '1', 'name' => "Kushagra", 'password' => 'jaskdhakjs'],
            ['id' => '1', 'name' => "Rgsh", 'password' => 'jaskdhakjs'],
            ['id' => '1', 'name' => "oorot", 'password' => 'jaskdhakjs']
        ));
    }
}

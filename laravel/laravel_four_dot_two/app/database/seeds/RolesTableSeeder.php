<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/4/18
 * Time: 1:26 PM
 */

class RolesTableSeeder extends Seeder {
    public function run() {
        DB::table('Roles') -> truncate();
        DB::table('Roles') -> insert([
            ['name' => 'Admin'],
            ['name' => 'User'],
            ['name' => 'Super Admin'],
            ['name' => 'Supervisor'],
            ['name' => 'Manager'],
        ]);
    }
}
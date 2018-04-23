<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/4/18
 * Time: 9:06 PM
 */

class PostsDatabaseSeeder extends Seeder {
    public function run() {
        DB::table('posts') -> insert([]);
    }
}
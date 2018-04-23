<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this -> command -> info('Seeding User Table');
		$this -> call('UserTableSeeder');

        $this -> command -> info('Seeding Duplicates Table');
        $this -> call('DuplicatesTableSeeder');

        $this -> command -> info('Seeding Test Users Table');
        $this -> call('TestUserTableSeeder');

        $this -> command -> info('Seeding Roles Table');
        $this -> call('RolesTableSeeder');
	}

}

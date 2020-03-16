<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Eloquent::unguard();
        DB::table('profeplus_roles')->delete();
        
        Role::create(array(
            'userId' => 1,
            'role' => 3,
        ));
    }
    

}
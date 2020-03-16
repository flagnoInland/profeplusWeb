<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Eloquent::unguard();
        DB::table('profeplus_users')->delete();
        
        User::create(array(
            'email' => 'herbertacg@gmail.com',
            'password' => Hash::make('1234'),
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'nationid' => '123123123',
            'gender' => 'Male',
            'birthdate' => '1990-08-07',
            'country' => 'U.S.A.',
            'city' => 'New York',
            'phone' => '123123123',
            'teacher' => 1,
            'studentid' =>  '',
            'appmode' => 1,   
        ));
        
        User::create(array(
            'email' => 'stefan@mail.com',
            'password' => Hash::make('1234'),
            'first_name' => 'Stefan',
            'last_name' => 'Mandel',
            'nationid' => '123123123',
            'gender' => 'Male',
            'birthdate' => '1990-08-07',
            'country' => 'U.S.A.',
            'city' => 'New York',
            'phone' => '123123123',
            'teacher' => 0,
            'studentid' =>  '',
            'appmode' => 1,            
        ));
        
        User::create(array(
            'email' => 'hanna@mail.com',
            'password' => Hash::make('1234'),
            'first_name' => 'Hanna',
            'last_name' => 'Mandel',
            'nationid' => '123123123',
            'gender' => 'Female',
            'birthdate' => '1990-08-07',
            'country' => 'U.S.A.',
            'city' => 'New York',
            'phone' => '123123123',
            'teacher' => 1,
            'studentid' =>  '',
            'appmode' => 2,    
        ));
		
		User::create(array(
            'email' => 'lucia@mail.com',
            'password' => Hash::make('1234'),
            'first_name' => 'Lucia',
            'last_name' => 'Mandel',
            'nationid' => '123123123',
            'gender' => 'Female',
            'birthdate' => '1990-08-07',
            'country' => 'U.S.A.',
            'city' => 'New York',
            'phone' => '123123123',
            'teacher' => 0,
            'studentid' =>  '',
            'appmode' => 1,            
        ));
        
	}

}
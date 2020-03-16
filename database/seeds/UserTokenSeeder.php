<?php

use Illuminate\Database\Seeder;
use App\UserToken;

class UserTokenSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Eloquent::unguard();
        DB::table('profeplus_user_token')->delete();
        
        UserToken::create(array(
            'user_id' => 1,
            'remember_token' => 'zzz',
            'device' => 1,            
        ));
        
        UserToken::create(array(
            'user_id' => 2,
            'remember_token' => 'zzz',
            'device' => 1,            
        ));
        
        UserToken::create(array(
            'user_id' => 3,
            'remember_token' => 'zzz',
            'device' => 1,            
        ));
		
		UserToken::create(array(
            'user_id' => 4,
            'remember_token' => 'zzz',
            'device' => 1,            
        ));
        
	}

}
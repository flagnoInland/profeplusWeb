<?php

use Illuminate\Database\Seeder;
use App\QuestionMode;

class QuestionModeSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Eloquent::unguard();
        DB::table('profeplus_questionmodes')->delete();
        
        QuestionMode::create(array(
            'name_es' => 'Individual',
            'name_en' => 'Individual',         
        ));
        
        QuestionMode::create(array(
            'name_es' => 'Instrucción por pares',
            'name_en' => 'Peer Instruction',         
        ));
        
        QuestionMode::create(array(
            'name_es' => 'Grupal',
            'name_en' => 'By groups',         
        ));
        
        QuestionMode::create(array(
            'name_es' => 'Ninguna',
            'name_en' => 'None',         
        ));
        
        
	}

}
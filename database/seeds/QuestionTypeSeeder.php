<?php

use Illuminate\Database\Seeder;
use App\QuestionType;

class QuestionTypeSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
        DB::table('profeplus_questiontypes')->delete();
        
        QuestionType::create(array(
            'name_es' => 'Normal',
            'name_en' => 'Normal',         
        ));
        
        QuestionType::create(array(
            'name_es' => 'Banco de datos',
            'name_en' => 'Data Bank',         
        ));
        
        QuestionType::create(array(
            'name_es' => 'Verdadero y falso',
            'name_en' => 'Truen and false',         
        ));
        
        QuestionType::create(array(
            'name_es' => 'Opinión',
            'name_en' => 'Opinion',         
        ));
        
        QuestionType::create(array(
            'name_es' => 'Evaluación',
            'name_en' => 'Evaluation',         
        ));
        
	}

}
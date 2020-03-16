<?php

class EvaluationSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Eloquent::unguard();
        DB::table('profeplus_evaluations')->delete();
        
        Evaluation::create(array(
            'user_id' => 1,
            'number_question' => 12,
            'overall_score' => 120,
            'duration' => 120,
            'start_time' => '14:00',
            'end_time' => '16:00',
            'date' => '2016-07-07',
            'exam_title' => 'Examen Metales',
            'materials' => '1,0,0,0,1',
            'answer_keys' => '1,2,1,3,4,5,1,2,1,3,4,5',
            'answer_weights' => '10,10,10,10,10,10,10,10,10,10,10,10',
            'lesson_id' => '0',
        ));
        
        Evaluation::create(array(
            'user_id' => 1,
            'number_question' => 12,
            'overall_score' => 120,
            'duration' => 120,
            'start_time' => '14:00',
            'end_time' => '16:00',
            'date' => '2016-07-07',
            'exam_title' => 'Examen Resistencia',
            'materials' => '1,0,1,0,1',
            'answer_keys' => '1,2,1,3,4,5,1,2,1,3,4,5',
            'answer_weights' => '10,10,10,10,10,10,10,10,10,10,10,10',
            'lesson_id' => '0',
        ));
        
        Evaluation::create(array(
            'user_id' => 1,
            'number_question' => 12,
            'overall_score' => 120,
            'duration' => 120,
            'start_time' => '14:00',
            'end_time' => '16:00',
            'date' => '2016-07-06',          
            'exam_title' => 'Examen Elementos',
            'materials' => '1,0,1,1,1',
            'answer_keys' => '1,2,1,3,4,5,1,2,1,3,4,5',
            'answer_weights' => '10,10,10,10,10,10,10,10,10,10,10,10',         
            'lesson_id' => '0',
        ));
        
        Evaluation::create(array(
            'user_id' => 1,
            'number_question' => 12,
            'overall_score' => 120,
            'duration' => 120,
            'start_time' => '14:00',
            'end_time' => '16:00',
            'date' => '2016-07-04',        
            'exam_title' => 'Examen Máquinas',
            'materials' => '1,1,0,0,1',
            'answer_keys' => '1,2,1,3,4,5,1,2,1,3,4,5',
            'answer_weights' => '10,10,10,10,10,10,10,10,10,10,10,10',
            'lesson_id' => '0',
        ));
        
        
        
        
        
        
	}

}
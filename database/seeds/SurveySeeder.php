<?php

use Illuminate\Database\Seeder;
use App\Survey;

class SurveySeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Eloquent::unguard();
        DB::table('profeplus_survey')->delete();
        
        Survey::create(array(
        'name_es' => 'Ninguno',
        'name_en' => 'None',
        'opt1_name_es' => 'Alternativa A',
        'opt2_name_es' => 'Alternativa B',
        'opt3_name_es' => 'Alternativa C',
        'opt4_name_es' => 'Alternativa D',
        'opt5_name_es' => 'Alternativa E',
        'opt1_name_en' => 'Answer A',
        'opt2_name_en' => 'Answer B',
        'opt3_name_en' => 'Answer C',
        'opt4_name_en' => 'Answer D',
        'opt5_name_en' => 'Answer E',
        ));
        
        Survey::create(array(
        'name_es' => 'nivel de satisfaccion',
        'name_en' => 'satisfaction level',
        'opt1_name_es' => 'Estoy muy satisfecho con lo planteado.',
        'opt2_name_es' => 'Estoy satisfecho con lo planteado.',
        'opt3_name_es' => 'Estoy regularmente satisfecho con lo planteado.',
        'opt4_name_es' => 'Estoy insatisfecho con lo planteado.',
        'opt5_name_es' => 'Estoy totalmente insatisfecho con lo planteado.',
        'opt1_name_en' => 'I am totally satisfied with the solution offered.',
        'opt2_name_en' => 'I am satisfied with the solution offered.',
        'opt3_name_en' => 'Neither I am satisfied nor I am unsatisfied.',
        'opt4_name_en' => 'I am unsatisfied the solution offered.',
        'opt5_name_en' => 'I am totalle unsatisfied with the solution offered.',
        ));
        
        Survey::create(array(
        'name_es' => 'nivel de acuerdo',
        'name_en' => 'agreement level',
        'opt1_name_es' => 'Estoy muy de acuerdo con lo planteado.',
        'opt2_name_es' => 'Estoy de acuerdo con lo planteado.',
        'opt3_name_es' => 'Estoy indeferente con lo planteado.',
        'opt4_name_es' => 'Estoy en desacuerdo con lo planteado.',
        'opt5_name_es' => 'Estoy totalmente en desacuerdo con lo planteado.',
        'opt1_name_en' => 'I totally agree with the solution offered.',
        'opt2_name_en' => 'I agree with the solution offered.',
        'opt3_name_en' => 'Neither I agree nor I disagree.',
        'opt4_name_en' => 'I disagree with the solution offered.',
        'opt5_name_en' => 'I totally disagree with the solution offered.',
        ));
        
        Survey::create(array(
        'name_es' => 'nivel de calificacion',
        'name_en' => 'qualification level',
        'opt1_name_es' => 'Muy alta calificación.',
        'opt2_name_es' => 'Alta calificación.',
        'opt3_name_es' => 'Regular calificación.',
        'opt4_name_es' => 'Baja calificación.',
        'opt5_name_es' => 'Muy baja calificación.',
        'opt1_name_en' => 'Very High Score.',
        'opt2_name_en' => 'High Score.',
        'opt3_name_en' => 'Regular Score.',
        'opt4_name_en' => 'Low Score.',
        'opt5_name_en' => 'Very Low Score.',
        ));
        
        Survey::create(array(
        'name_es' => 'expositor',
        'name_en' => 'speaker',
        'opt1_name_es' => 'Muy buen expositor o docente.',
        'opt2_name_es' => 'Buen expositor o docente.',
        'opt3_name_es' => 'Regular expositor o docente.',
        'opt4_name_es' => 'Debe mejorar.',
        'opt5_name_es' => 'Debe mejorar urgentemente.',
        'opt1_name_en' => 'Very good speaker or teacher.',
        'opt2_name_en' => 'Good speaker or teacher.',
        'opt3_name_en' => 'Acceptable speaker or teacher.',
        'opt4_name_en' => 'Must improve.',
        'opt5_name_en' => 'Must urgently improve.',
        ));
    
	}

}
<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeEvals extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'eval:make';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create evaluations';

	/**
	 * Create a new command instance.
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

        $inactive = $this->option('inactive');
		$pending = $this->option('pending');
		
		$teacher = User::find(1);
		$eval = new Evaluation(array(
				'number_question' => 4, 
				'overall_score' => 4,
				'duration' => 120,
				'start_time' => '14:00',
				'end_time' => '16:00',
				'date' => '2016-07-14',
				'course_name' => 'Rockets',
				'speciality' => 'Spaceships',
				'institution' => 'Whatever',
                'exam_title' => 'Final Exam',
                'materials' => '1,1,1,1,0',
                'answer_keys' => '1,2,3,2',            
				'answer_weights' => '1,1,1,1',
				'observations' => 'None',
				'status' => 0,
                'statusLesson' => 0,
                'lesson_id' => 0,              
            ));
		$teacher->evaluations()->save($eval);   
		
		if ($inactive){
            $eval->status = 1;          
            $eval->save();
        } else {
            $eval->status = 0;          
            $eval->save();
        }
		
		if ($pending){
            $eval->statusLesson = 1;          
            $eval->save();
        } else {
            $eval->statusLesson = 0;          
            $eval->save();
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('inactive', '-i', InputOption::VALUE_NONE, 'Activate or deactivate', null,false),
			array('pending', '-p', InputOption::VALUE_NONE, 'Activate or deactivate', null,false),
		);
	}

}

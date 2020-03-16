<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TestLessons extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'lesson:test';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Test Lessons.';

	/**
	 * Create a new command instance.
	 *
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
        $code = $this->argument('code');
        $teacher = User::find(1);
        
        $run = $this->option('run');
        $clear = $this->option('clear');
        $active = $this->option('active');
        $survey = $this->option('survey');
		$binary = $this->option('binary');
        
        $lesson = Lesson::where('accesscode',$code)->where('run',$run)->first();
        if ($lesson== null){
            $lesson = new Lesson(array(
                'user_id' => 1,
				'course_id' => -1, 
				'accesscode' => $code,
				'subject' => 1,
				'exercise' => 1,
				'ans1' => 0,
				'ans2' => 0,
				'ans3' => 0,
				'ans4' => 0,
				'ans5' => 0,
                'ans_yes' => 0,
                'ans_no' => 0,
                'ans_na' => 0,            
				'ansnn' => 0,
				'inlesson' => 0,
				'inactive' => 0,
                'run' => $run,
                'survey' => 0,
                'question_type' => 1,
                'question_mode' => 1,
				'app_mode' => 1,
            ));
            $teacher->lessons()->save($lesson); 
            $lesson->save();  
        }
        
        if ($survey!=0){
            $lesson->question_type = 4;
            $lesson->survey = $survey;
            $lesson->save();
        }
        
        if ($binary){
            $lesson->question_type = 3;          
            $lesson->save();
        }
        
        if ($active){
            $lesson->inactive = 0;          
            $lesson->save();
        } else {
            $lesson->inactive = 1;          
            $lesson->save();
        }
        
        if ($clear){
            $lesson->ans1 = 0;		
            $lesson->ans2 = 0;
            $lesson->ans3 = 0;	
            $lesson->ans4 = 0;		
            $lesson->ans5 = 0;
            $lesson->ansnn = 0;
            $lesson->ans_yes = 0;
            $lesson->ans_no = 0;
            $lesson->ans_na = 0;
            $lesson->inlesson = 0;         
            $lesson->save();
        }
        
        $this->info('Code: '.$lesson->accesscode);
        $this->info('Id: '.$lesson->id);
        $this->info('Inactive: '.$lesson->inactive);
        
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('code', InputArgument::REQUIRED, 'Lesson id for this session'),
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
			array('run', null, InputOption::VALUE_REQUIRED, 'Run number', null,1),
            array('active', null, InputOption::VALUE_NONE, 'Activate or deactivate', null,true),
            array('clear', null, InputOption::VALUE_NONE, 'Clear answer values', null,false),
            array('survey', null, InputOption::VALUE_OPTIONAL, 'Choose survey type', null,0),
            array('binary', null, InputOption::VALUE_NONE, 'Choose true false type', null,false),
		);
	}

}

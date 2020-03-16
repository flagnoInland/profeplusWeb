<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FillLessons extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'lesson:fill';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Populate lesson.';

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
        $lesson = Lesson::where('accesscode',$code)->where('user_id',1)->first();
		if ($lesson->question_type != 3){
            $num1 = rand (0,50);
            $num2 = rand (0,100-$num1);
            $num3 = rand (0,100-$num1-$num2);
            $num4 = rand (0,100-$num1-$num2-$num3);
            $num5 = rand (0,100-$num1-$num2-$num3-$num4);
            $num6 = 100-$num1-$num2-$num4-$num3-$num5;
            $lesson->ans1 = $num1;		
            $lesson->ans2 = $num2;
            $lesson->ans3 = $num3;	
            $lesson->ans4 = $num4;		
            $lesson->ans5 = $num5;
            $lesson->ansnn = $num6;
            $lesson->ans_yes = 0;
            $lesson->ans_no = 0;
            $lesson->ans_na = 0;
            $lesson->inlesson = 100;
            $this->info('Ans1: '.$num1); 
            $this->info('Ans2: '.$num2); 
            $this->info('Ans3: '.$num3); 
            $this->info('Ans4: '.$num4); 
            $this->info('Ans5: '.$num5); 
            $this->info('NN: '.$num6); 
        } else {
            $num1 = rand (0,50);
            $num2 = rand (0,100-$num1);
            $num3 = rand (0,100-$num1-$num2);
            $num4 = 100-$num1-$num2-$num3;
            $lesson->ans1 = 0;		
            $lesson->ans2 = 0;
            $lesson->ans3 = 0;	
            $lesson->ans4 = 0;		
            $lesson->ans5 = 0;
            $lesson->ansnn = $num4;
            $lesson->ans_yes = $num1;
            $lesson->ans_no = $num2;
            $lesson->ans_na = $num3;
            $lesson->inlesson = 100;
            $this->info('Ans1: '.$num1); 
            $this->info('Ans2: '.$num2); 
            $this->info('Ans3: '.$num3); 
            $this->info('NN: '.$num4);
        }
        $lesson->save();
               
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('code', InputArgument::REQUIRED, 'Code for the lesson.'),
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
			array('run', null, InputOption::VALUE_OPTIONAL, 'run 2', null),
		);
	}

}

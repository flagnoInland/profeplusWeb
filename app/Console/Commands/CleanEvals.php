<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CleanEvals extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'eval:clean';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clear evaluations';

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
		DB::select(DB::raw('TRUNCATE TABLE profeplus_evaluations'));
		DB::select(DB::raw('TRUNCATE TABLE profeplus_lessons'));
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
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}

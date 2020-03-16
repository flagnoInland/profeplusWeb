<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		Eloquent::unguard();
        $this->call('UserSeeder');
        $this->call('UserTokenSeeder');
        $this->call('RoleSeeder');
        //$this->call('CourseSeeder');
        $this->call('QuestionTypeSeeder');
        $this->call('QuestionModeSeeder');
		$this->call('SurveySeeder');
        $this->call('RandomNumberSeeder');
        $this->call('RandomNumberSeeder2');
        $this->call('RandomNumberSeeder3');
        $this->call('RandomNumberSeeder4');
        //$this->call('EvaluationSeeder');
		//$this->call('TutorialSeeder');
    }
}

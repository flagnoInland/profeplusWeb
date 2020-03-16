<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profeplus_lessons', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->index();
			$table->integer('course_id')->default(0);;
            $table->integer('previous_lesson')->default(0);
			$table->char('accesscode',6);
			$table->integer('subject')->default(0);
			$table->integer('exercise')->default(0);
            $table->boolean('status')->default(true);
			$table->integer('app_mode')->default(1);
            $table->integer('inactive')->default(1)->nullable();
			$table->integer('run')->default(1);
			$table->integer('ans1')->default(0);
			$table->integer('ans2')->default(0);
			$table->integer('ans3')->default(0);
			$table->integer('ans4')->default(0);
			$table->integer('ans5')->default(0);
            $table->integer('ans_yes')->default(0);
            $table->integer('ans_no')->default(0);
            $table->integer('ans_na')->default(0);
            $table->integer('ansnn')->default(0);
			$table->integer('inlesson')->default(0);                  
            $table->integer('question_type')->default(1);
            $table->integer('question_mode')->default(1);
            $table->integer('survey')->default(1);
            $table->integer('finished')->default(0);
            $table->string('level')->default('')->nullable(); 
            $table->string('grade')->default('')->nullable(); 
            $table->string('classroom')->default('')->nullable(); 
            $table->string('observations')->default('')->nullable();
            $table->string('answer_keys')->default('');
            $table->string('institution')->default('')->nullable();    
            $table->string('speciality')->default('')->nullable();    
            $table->string('course_name')->default('')->nullable();                
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('profeplus_lessons');
	}

}

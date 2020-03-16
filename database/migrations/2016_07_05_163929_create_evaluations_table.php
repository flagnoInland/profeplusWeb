<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profeplus_evaluations', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id')->index();
			$table->integer('lesson_id');
			$table->integer('eval_type');
			$table->integer('visibility');
			$table->integer('number_question');
			$table->integer('overall_score');
			$table->integer('duration');
			$table->string('start_time');
			$table->string('end_time');
			$table->date('date');
			$table->string('exam_title')->nullable();
			$table->string('materials')->nullable();
			$table->string('answer_keys');
			$table->string('answer_weights');
			$table->string('answer_types');
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
		Schema::dropIfExists('profeplus_evaluations');
	}

}

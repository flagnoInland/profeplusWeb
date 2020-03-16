<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentevaluationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profeplus_student_evaluation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('evaluation_id');
			$table->integer('user_id');
			$table->string('solutions')->default('');
			$table->decimal('score',3,1)->default(0.0);
			$table->integer('status')->default(0);
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
		Schema::dropIfExists('profeplus_student_evaluation');
	}

}

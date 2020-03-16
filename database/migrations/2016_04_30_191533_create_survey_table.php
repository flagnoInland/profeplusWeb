<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profeplus_survey', function (Blueprint $table) {
			$table->increments('id');
            $table->string('name_es');
            $table->string('name_en');
            $table->string('opt1_name_es');
            $table->string('opt2_name_es');
            $table->string('opt3_name_es');
            $table->string('opt4_name_es');
            $table->string('opt5_name_es');
            $table->string('opt1_name_en');
            $table->string('opt2_name_en');
            $table->string('opt3_name_en');
            $table->string('opt4_name_en');
            $table->string('opt5_name_en');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('profeplus_survey');
	}

}

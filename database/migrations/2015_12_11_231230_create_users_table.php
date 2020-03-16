<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profeplus_users', function (Blueprint $table) {
			$table->increments('id');		
			$table->string('email')->unique();
			$table->string('password', 60);          
			$table->string('first_name');
			$table->string('last_name');
			$table->integer('nationid')->nullable();
			$table->date('birthdate');
			$table->string('country');
			$table->string('city');
			$table->string('phone')->nullable();
            $table->integer('appmode')->default(1);
            $table->string('gender')->default('');
            $table->string('facebook')->default('');
            $table->string('google')->default('');
            $table->string('linkedin')->default('');
            $table->string('status')->default('');
            $table->string('description')->default('')->nullable();
            $table->string('institution_name')->default('')->nullable();
            $table->integer('institution_type')->default(0)->nullable();
            $table->string('speciality')->default('')->nullable();
			$table->string('studentid')->nullable();
			$table->integer('teacher');
			$table->rememberToken();
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
		Schema::dropIfExists('profeplus_users');
	}

}

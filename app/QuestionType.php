<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class QuestionType extends Eloquent {

    public $timestamps = false;
	protected $table = 'profeplus_questiontypes';

	protected $fillable = array('name_es','name_en');
}
<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class QuestionMode extends Eloquent {


    public $timestamps = false;
	protected $table = 'profeplus_questionmodes';

	protected $fillable = array('name_es','name_en');
    
}
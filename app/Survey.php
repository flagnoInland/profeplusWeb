<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Survey extends Eloquent {

    public $timestamps = false;
	protected $table = 'profeplus_survey';

	protected $fillable = array('name_es','name_en','opt1_name_es', 'opt2_name_es', 'opt3_name_es', 'opt4_name_es', 'opt5_name_es', 'opt1_name_en', 'opt2_name_en', 'opt3_name_en', 'opt4_name_en', 'opt5_name_en');
}
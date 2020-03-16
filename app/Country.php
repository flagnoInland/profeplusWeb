<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Country extends Eloquent {

	protected $table = 'profeplus_countries';
	protected $fillable = array('name_es','name_en');
    
}
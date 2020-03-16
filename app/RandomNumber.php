<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class RandomNumber extends Eloquent {

	protected $table = 'profeplus_randomnumbers';

	protected $fillable = array('randoms');
    
    public $timestamps = false;


}
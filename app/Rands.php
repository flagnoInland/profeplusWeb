<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Rands extends Eloquent {

	protected $table = 'profeplus_rands';

	protected $fillable = array('accesscode','disabled');
    

}
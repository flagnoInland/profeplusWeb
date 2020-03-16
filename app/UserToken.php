<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserToken extends Eloquent {

	protected $table = 'profeplus_user_token';
    
    protected $primaryKey = 'user_id';

	protected $fillable = array('user_id','remember_token','device');


	public function user()
	{
		return $this->belongsTo('User');
	}


}
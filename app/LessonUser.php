<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use App\Lesson;
use App\User;
use App\LessonUser;
use App\Evaluation;

class LessonUser extends Eloquent {

	protected $table = 'profeplus_lessonsusers';

	protected $fillable = array('lesson_id','run','answer','last_answer', 'owner');


	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function lesson()
	{
		return $this->belongsTo('App\Lesson');
	}
	
	public function setAnswer($letter){
		$this->attributes['answer'] = 1;
		$this->attributes['last_answer'] = $letter;
		$this->save();
	}

}
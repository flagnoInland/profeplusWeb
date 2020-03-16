<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use App\Lesson;
use App\User;
use App\LessonUser;
use App\Evaluation;

class EvaluationStudent extends Eloquent {
	
    const INACTIVE = 0;
    const DONE = 1;
    const INCOMPLETE = 2;

    protected $table = 'profeplus_student_evaluation';
    protected $fillable = array('evaluation_id','user_id','solutions','score','status');
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function evaluation()
    {
        return $this->belongsTo('App\Evaluation');
    }
	
    public function scopeFindExaminado($query, $user_id, $eval_id)
    {
        return $query->where('user_id',$user_id)
            ->where('evaluation_id', $eval_id);
        /*
            ->where(function($query){
                    $query->where('status', EvaluationStudent::INACTIVE)->orWhere('status', EvaluationStudent::INCOMPLETE);
            });*/
    }
    
}
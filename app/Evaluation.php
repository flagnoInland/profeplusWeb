<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use App\Lesson;
use App\User;
use App\LessonUser;
use App\Evaluation;

class Evaluation extends Eloquent {
	
	const ANS_F = 7;
	const ANS_V = 6;
	const ANS_E = 5;
	const ANS_D = 4;
	const ANS_C = 3;
	const ANS_B = 2;
	const ANS_A = 1;
	const ANS_N = 0;
        
        const EVAL_NORMAL = 1;
        const EVAL_FCI = 2;
        
        const INVISIBLE = 0;
        const VISIBLE = 1;
	
	protected $table = 'profeplus_evaluations';
    
	protected $fillable = array( 'lesson_id','user_id','number_question', 'eval_type', 'visibility',
            'overall_score', 'start_time', 'end_time', 'date', 'duration', 'exam_title', 'materials', 'answer_keys', 'answer_weights', 'answer_types');
    
    public function user()
	{
		return $this->belongsTo('App\User');
	}
	
	public function lesson()
	{
		return $this->belongsTo('App\Lesson');
	}
	
	public function scopeData($query)
	{
		return $query->select(array('id','lesson_id', 'eval_type', 'exam_title', 'visibility',
                    'number_question as questions','overall_score','start_time','end_time','date', 'materials','answer_weights as weights', 'answer_types as types'));
	}
    
}
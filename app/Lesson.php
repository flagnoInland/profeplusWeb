<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use App\Lesson;
use App\User;
use App\LessonUser;
use App\Evaluation;

class Lesson extends Eloquent{
	
    const Q_NORMAL = 1;
    const Q_BANK = 2;
    const Q_TRUE = 3;
    const Q_SURVEY = 4;
    const Q_EVAL = 5; 
	
    const ENABLED = 0;
    const DISABLED = 1;
    const PENDING = 2;

    protected $table = 'profeplus_lessons';

    protected $fillable = array('course_id','accesscode','subject','exercise','ans1','ans2','ans3','ans4','ans5','ans_yes','ans_no','ans_na', 'ansnn','run','inlesson','status','survey','question_type','question_mode','level','classroom','grade', 'course_name', 'speciality', 'institution', 'observations', 'previous_lesson', 'answer_keys', 'app_mode', 'finished');


    public function user()
    {
        return $this->belongsTo('App\User');
    }
	
    public function evaluation()
    {
        return $this->hasOne('App\Evaluation');
    }
	
    public function scopeConnectedToExam($query, $lesson_id)
    {
        return $query->select(array('id as lesson_id','accesscode','inlesson','course_name','institution','speciality'))
                    ->where('id', $lesson_id);
    }
	
    public function scopeGetExamHeader($query, $lesson_id)
    {
        return $query->select(array('id','course_name','institution','speciality','observations'))
                    ->where('id', $lesson_id);
    }
	
    public function scopeHasEvaluation($query, $accesscode)
    {
        return $query->where('accesscode', $accesscode)
                    ->where('question_type',Lesson::Q_EVAL)
                    ->where('status',Lesson::ENABLED);
    }
	
    public function setCode($accesscode){
        $this->attributes['accesscode'] = $accesscode;
        $this->save();
    }
	
    public function getCode(){
        return $this->accesscode;
    }

    public function switchOff(){
        $this->attributes['status'] = Lesson::DISABLED;
        $this->save();		
    }

    public function switchOn(){
        $this->attributes['status'] = Lesson::ENABLED;
        $this->save();		
    }

    public function addStudent(){
        $inlesson = $this->inlesson;
        $ansnn = $this->ansnn;
        $this->attributes['inlesson'] = $inlesson+1;
        $this->attributes['ansnn'] = $ansnn+1; 
        $this->save();		
    }

    public function addFinished(){
        $finished = $this->finished;
        $this->attributes['finished'] = $finished + 1;
        $this->save();
    }

    public function collectAnswer($letter1){
        $col = $this->getField($letter1);
        $count = $this->$col;
        //Log::info($count);
        $this->attributes[$col] = $count+1;
        $ansnn = $this->ansnn;
        if ($ansnn > 0){
                $this->attributes['ansnn']= $ansnn-1; 	
        }
        $this->save();
    }

    public function changeAnswer($letter1, $letter2){
        $col = $this->getField($letter1);
        $count = $this->$col;
        //Log::info($count);
        $this->attributes[$col] = $count+1;
        $col = $this->getField($letter2);
        $count = $this->$col;
        if ($count > 0){
            $this->attributes[$col] = $count-1;
        }	
        $this->save();
    }

    private function getField($letter){
        $field = 'ans1';
        switch($letter){
            case "A":
                    $field = 'ans1';
                    break;
            case "B":
                    $field = 'ans2';
                    break;
            case "C":
                    $field = 'ans3';
                    break;
            case "D":
                    $field = 'ans4';
                    break;
            case "E":
                    $field = 'ans5';
                    break;
            case "F":
                    $field = 'ans_yes';
                    break;
            case "G":
                    $field = 'ans_no';
                    break;
            case "H":
                    $field = 'ans_na';			
                    break;				
        } 
        return $field;
    }

}
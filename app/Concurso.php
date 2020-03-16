<?php

namespace App;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Validator, Input, Redirect, Response, DB, Hash, Mail, Auth;
use App\Lesson;
use App\User;
use App\LessonUser;
use App\Evaluation;

class Concurso extends Eloquent {

    protected $table = 'profeplus_concurso';
    protected $fillable = array( 'user_id','team', 'institute');

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function scopeConcursoByGroup(){
    return DB::table('profeplus_concurso')->select(DB::raw('team, COUNT(team) AS votes'))
            ->groupBy(DB::raw('team'))
            ->get();
  }
    
}


<?php

namespace App;

use Eloquent;
use App\Lesson;
use App\User;
use App\LessonUser;
use App\Evaluation;

class Role extends Eloquent{
    
    const USER = 0;
    const TESTER = 1;
    const ADMIN = 2;
    const SUPER = 3;
    
    

    protected $table = 'profeplus_roles';
    protected $fillable = array('userId','role');
    
    public function user() {
        return $this->belongsTo('App\User', 'userId');
    }
     
}

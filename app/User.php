<?php

namespace App;

use Eloquent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use DB;
use App\Lesson;
use App\UserToken;
use App\LessonUser;
use App\Evaluation;
use App\EvaluationStudent;
use App\Role;

class User extends Authenticatable {
	
	use HasApiTokens;

	const INACTIVE = 0;
	const ACTIVE = 1;

	protected $table = 'profeplus_users';

	#protected $casted = array('id' => 'integer','teacher' => 'integer',
	#'appmode' => 'integer');

	protected $fillable = array('first_name','last_name','email', 'password',
	  'nationid','birthdate','country','city','phone','studentid','teacher',
	  'gender','appmode','facebook','google','linkedin','status',
	  'description','institution_name','institution_type','speciality');

	protected $visible = array('id','first_name','last_name','email',
	  'nationid','birthdate','country','city','phone','studentid','created_at',
	  'updated_at', 'institution_name', 'speciality', 'appmode');


	protected $hidden = array('password');

	/**
	* Get the unique identifier for the user.
	*
	* @return mixed
	*/
	public function getAuthIdentifier() {
		return $this->getKey();
	}

	public function getAuthPassword() {
		return $this->password;
	}

	public function getReminderEmail() {
		return $this->email;
	}

	public function token() {
		return $this->hasOne('App\UserToken');
	}

	public function lessons() {
		return $this->hasMany('App\Lesson');
	}

	public function scopeLessonEvaluations($query, $user_id) {
	//Log::info($user_id);
	return DB::table(DB::raw("profeplus_evaluations AS pe"))
			->join(DB::raw("profeplus_lessons AS pl"),'pe.lesson_id','=','pl.id')
			->select(DB::raw("pe.id AS id, pl.id AS lesson_id, pe.exam_title AS exam_title, pe.date AS date, 
				pe.end_time AS time, pe.visibility AS visibility, pl.status AS status, 
				pl.course_name AS course, pe.eval_type AS type"))
			->where('pe.user_id', $user_id)
			->orderBy('pe.id','desc')
			->get();
	}

	public function scopeLessonOneEvaluation($query, $user_id, $lessonId) {
	//Log::info($user_id);
	return DB::table(DB::raw("profeplus_evaluations AS pe"))
			->join(DB::raw("profeplus_lessons AS pl"),'pe.lesson_id','=','pl.id')
			->select(DB::raw("pe.id AS id, pl.id AS lesson_id, pe.exam_title AS exam_title, pe.date AS date, 
				pe.end_time AS time, pl.status AS status, pl.accesscode, pl.inlesson, pl.finished,
				pl.course_name, pe.eval_type AS type"))
			->where('pe.user_id', $user_id)
			->where('pl.id', $lessonId)
			->orderBy('pe.id','desc')
			->first();
	}

	public function evaluations() {
		return $this->hasMany('App\Evaluation')
					->select(array('id', 'exam_title'));
	}

	public function lessonsusers() {
	return $this->hasMany('App\LessonUser');
	}

	public function evaluationstudents() {
	return $this->hasMany('App\EvaluationStudent');
	}

	public function getRememberToken() {
	return $this->remember_token;
	}

	public function setRememberToken($value) {
		$this->remember_token = $value;
	}

	public function getRememberTokenName() {
		return 'remember_token';
	}

	public function roles() {
		return $this->hasOne('App\Role','userId');
	}

	public function scopeUsersByMonth(){
	return DB::table('profeplus_users')->select(
			DB::raw('SUM(CASE WHEN studentid ="" OR studentid = "0000" THEN 1 ELSE 0 END) AS teachers, '
					. 'SUM(CASE WHEN studentid !="" AND studentid != "0000" THEN 1 ELSE 0 END) AS students, '
					. 'YEAR(created_at) AS f_year, MONTHNAME(created_at) AS f_month, '
					. 'MONTH(created_at) AS n_month'))
			->groupBy(DB::raw('YEAR(created_at)'),DB::raw('MONTH(created_at)'))
			->orderBy('f_year', 'desc')
			->orderBy('n_month', 'desc')
			->get();
	}

	public function scopeUsersByCountry(){
	return DB::table('profeplus_users')->select(
			DB::raw('SUM(CASE WHEN country ="Perú" THEN 1 ELSE 0 END) AS peru, '
					. 'SUM(CASE WHEN country !="Perú" THEN 1 ELSE 0 END) AS others, '
					. 'YEAR(created_at) AS f_year, MONTHNAME(created_at) AS f_month, '
					. 'MONTH(created_at) AS n_month'))
			->groupBy(DB::raw('YEAR(created_at)'),DB::raw('MONTH(created_at)'))
			->orderBy('f_year', 'desc')
			->orderBy('n_month', 'desc')
			->get();
	}

	public function scopeNationalUsers(){
	return DB::table('profeplus_users')->select(DB::raw('city, COUNT(city) AS users'))
			->where('country','Perú')
			->groupBy("city")
			->get();
	}

}
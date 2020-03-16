<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\JsonResponse;
use App\User;
use App\Lesson;


Route::get('/', function () {
    return view('welcome');
});
const PUPIL = 0;
const TEACHER = 1;
    
const MOD_UNI = 1;
const MOD_SCHOOL = 2;


Route::get('/locale', function(){
	return Response::json(array('lan'=>App::getLocale()),JsonResponse::HTTP_OK);
});

// App mode
Route::get('/', function () {   
    return View::make('start.app-mode',array('userid'=>'0'));
});

Route::get('/web/user/{user}/', function ($user) {   
    return View::make('start.app-mode', array('userid'=>$user));
});

// User Mode
Route::get('/web/mode/{mode}/', function ($mode) {   
    return View::make('start.general-user-mode', array('mode'=>$mode, 'userid' =>'0'));
})->where(array('mode' => '[1-2]'));

Route::get('/web/user/{user}/{mode}/', function ($user, $mode) {   
    return View::make('start.general-user-mode', array('mode'=>$mode, 'userid' =>$user));
})->where(array('mode' => '[1-2]'));

Route::get('/web/user/{user}/{mode}/{type}/', 'AjaxController@updateMode');


// Home
Route::get('/web/start/{mode}/{type}/', array ('as'=>'home', function ($mode, $type) {   
    return View::make('start.home', array('mode'=>$mode,'type'=>$type));
}));


// Recover
Route::get('/web/recover/{mode}/{type}/', array ('as'=>'recover', function ($mode, $type) {   
    return View::make('start.recover', array('mode'=>$mode,'type'=>$type));
}));

Route::post('/web/recover-user/', 'AjaxController@recover');

// Login
Route::get('/web/login/{mode}/{type}', array ('as'=>'login', function () {   
    return View::make('start.login');
}));

Route::post('/web/login/{mode}/{type}', 'AjaxController@authenticate');

Route::post('/web/student/guest-login', 'AjaxController@guestLogin');
Route::post('/web/student/guestschool-login', 'AjaxController@guestSchoolLogin');


// Register
Route::get('/web/register/{mode}/{type}', array ('as'=>'register', function ($mode, $type) {
		if ($type== TEACHER){
			return View::make('register.register-teacher', array('mode'=>$mode,'type'=>$type));
		} else if ($mode == MOD_SCHOOL && $type == PUPIL) {
			return View::make('register.register-school-student');
		} else if ($mode == MOD_UNI && $type == PUPIL) {
			return View::make('register.register-uni-student');
		}
}));

Route::post('/web/register/{mode}/{type}', 'AjaxController@register');

// Update profile
Route::get('/web/update/{user}/{mode}/{type}/{code}', function ($user, $mode, $type, $code) {
		$account = User::find($user);
		if ($type== TEACHER){
			return View::make('update.update-teacher', array('userid'=>$user, 'mode'=>$mode, 'user'=>$account, 'code'=>$code));
		} else if ($mode == MOD_SCHOOL && $type == PUPIL) {
			return View::make('update.update-school-student', array('userid'=>$user, 'mode'=>$mode, 'user'=>$account, 'code'=>$code));
		} else if ($mode == MOD_UNI && $type == PUPIL) {
			return View::make('update.update-uni-student', array('userid'=>$user, 'mode'=>$mode, 'user'=>$account, 'code'=>$code));
		}
});

Route::post('/web/update/{user}/{mode}/{type}/{code}', 'AjaxController@update');


// User boards
Route::get('/web/board/{user}/{mode}/{code}/1', function ($user, $mode, $code) {
	$teacher = User::find($user);

	// Search for active lessons
	$active_lesson = Lesson::where('user_id',$user)->where('status',Lesson::ENABLED)->first();
	if ($active_lesson){
		$type = $active_lesson->question_type;
		if ($type == Lesson::Q_EVAL){ //EVALUACION
			$data = array(
	              'user_id' => $user,
	              'mode' => $mode,
	              'lessonId' => $active_lesson->id
	            );
	    	return View::make( 'exams.eval-code', $data);
    	} else { //PREGUNTAS
    		$gnr = $teacher->gender;
			$welcome = '¡Bienvenido '.$teacher->first_name.' '.$teacher->last_name.'!';
			if ($gnr =='Female' || $gnr=='Femenino'){
				$welcome = '¡Bienvenida '.$teacher->first_name.' '.$teacher->last_name.'!';
			}	
    		return View::make('teacher-board', array('userid'=>$user,'welcome'=>$welcome, 'mode'=>$mode, 'code'=>$code));
    	}
	}
	else{
		$gnr = $teacher->gender;
		$welcome = '¡Bienvenido '.$teacher->first_name.' '.$teacher->last_name.'!';
		if ($gnr =='Female' || $gnr=='Femenino'){
			$welcome = '¡Bienvenida '.$teacher->first_name.' '.$teacher->last_name.'!';
		}	
	    return View::make('teacher-board', array('userid'=>$user,'welcome'=>$welcome, 'mode'=>$mode, 'code'=>$code));
	}

});

Route::POST('/web/disableOldlessons/{user}', 'AjaxController@disableOldLessons');

Route::get('/web/board/{user}/{mode}/0000/0', function ($user, $mode) {
	$student = User::find($user);
	$gnr = $student->gender;
	$welcome = '¡Bienvenido '.$student->first_name.' '.$student->last_name.'!';
	if ($gnr =='Female' || $gnr=='Femenino'){
		$welcome = '¡Bienvenida '.$student->first_name.' '.$student->last_name.'!';
	}
	if ($mode == MOD_SCHOOL){
		return View::make('student-school-board',array('userid'=>$user, 'welcome'=>$welcome, 'mode'=>$mode));
	} else if ($mode == MOD_UNI){
		return View::make('student-uni-board',array('userid'=>$user, 'welcome'=>$welcome, 'mode'=>$mode));
	}
});

// User manuals for teacher
Route::get('/web/teacher-manual-list/{user}/{mode}/{code}', function ($user, $mode, $code) {   
    return View::make('teacher-manual-list', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code));
});

Route::get('/web/manual/protocol/{user}/{mode}/{code}', function ($user, $mode, $code) {   
    return View::make('manuals.main-protocol', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code));
});

Route::get('/web/manual/teacher/{user}/{mode}/{code}/{lessonid}/{question}/{survey}/{exercise}/{subject}', 
	function ($user, $mode, $code, $lessonid, $question, $survey, $exercise, $subject) {   
		return View::make('manuals.teacher-manual', 
		array( 
			'userid'=>$user, 
			'mode'=>$mode, 
			'code'=>$code, 
			'lessonid'=>$lessonid,
			'question'=>$question,
			'survey'=>$survey,
			'exercise'=>$exercise,
			'subject'=>$subject,
			));
});

Route::get('/web/manual/question/{user}/{mode}/{code}', function ($user, $mode, $code) {   
    return View::make('manuals.question-bank', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code));
});

// User manual for student

Route::get('/web/student-manual-list/{user}/{mode}/{code}', function ($user, $mode, $code) {   
    return View::make('student-manual-list', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code));
});


// Information

Route::get('/web/info-list/{user}/{mode}/{type}/{code}', function ($user, $mode, $type, $code) {   
    return View::make('info-list', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code, 'type'=>$type));
});

Route::get('/web/manual/mobile/{user}/{mode}/{type}/{code}', function ($user, $mode, $type, $code) {   
    return View::make('manuals.mobile', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code, 'type'=>$type));
});

Route::get('/web/manual/how/{user}/{mode}/{type}/{code}', function ($user, $mode, $type, $code) {   
    return View::make('manuals.how', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code, 'type'=>$type));
});

Route::get('/web/manual/emprender/{user}/{mode}/{type}/{code}', function ($user, $mode, $type, $code) {   
    return View::make('manuals.emprender', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code, 'type'=>$type));
});

Route::get('/web/manual/why/{user}/{mode}/{type}/{code}', function ($user, $mode, $type, $code) {   
    return View::make('manuals.why', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code, 'type'=>$type));
});

Route::get('/web/manual/who/{user}/{mode}/{type}/{code}', function ($user, $mode, $type, $code) {   
    return View::make('manuals.who', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code, 'type'=>$type));
});

Route::get('/web/manual/thanks/{user}/{mode}/{type}/{code}', function ($user, $mode, $type, $code) {   
    return View::make('manuals.thanks', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code, 'type'=>$type));
});

Route::get('/web/manual/about/{user}/{mode}/{type}/{code}', function ($user, $mode, $type, $code) {   
    return View::make('manuals.about', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code, 'type'=>$type));
});

// Questions

Route::get('/web/questions/{user}/{mode}/{code}', function ($user, $mode, $code) {   
    return View::make('question-list', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code));
});

Route::get('/web/exercise/{user}/{mode}/{code}', function ($user, $mode, $code) {   
    return View::make('exercise', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code));
});


Route::get('/web/survey/{user}/{mode}/{code}', function ($user, $mode, $code) {   
    return View::make('survey-list', array('userid'=>$user, 'mode'=>$mode, 'code'=>$code));
});


// Access Code Request
Route::POST('/web/code/{user}', 'TeacherLessonController@createLesson');

// Show Access Code
Route::get('/web/session/{question}/{survey}/{exercise}/{subject}/{code}/{lessonid}/{user}/{mode}', 
	function ($question, $survey, $exercise, $subject, $code, $lessonid, $user, $mode) {   
		return View::make('accesscode', array(
		'question'=>$question,
		'survey'=>$survey,
		'exercise'=>$exercise,
		'subject'=>$subject,		
		'code'=>$code, 
		'lessonid'=>$lessonid, 
		'userid'=>$user, 
		'mode'=>$mode));
	});

// Update session
Route::POST('/web/session/{lessonid}', 'AjaxController@updateLesson');
Route::POST('/web/disable/{id}', 'TeacherLessonController@disableActual');
Route::POST('/web/share-report-data/{lessonid}/{previous}', 'AjaxController@shareReportData');
Route::GET('/web/check/{id}', 'AjaxController@checkLesson');
Route::GET('/web/full-report-data/{lessonid}', 'AjaxController@getReportData');

// Normal Results

Route::get('/web/graph/1/{id}/{run}', 'TeacherLessonController@showActual');
Route::get('/web/graph/2/{id}/{previous}', 'TeacherLessonController@compareActualPrevious');

// Paso 1 - 5 alternativas, Obtener opinión
Route::get('/web/result/1/{question}/{run}/{survey}/{exercise}/{subject}/{code}/{lessonid}/{user}/{mode}', 
	function ($question, $run, $survey, $exercise, $subject, $code, $lessonid, $user, $mode) {   
    return View::make('results.result-1', array(
		'question'=>$question,
		'run'=>$run,
		'survey'=>$survey,
		'exercise'=>$exercise,
		'subject'=>$subject,
		'code'=>$code, 
		'lessonid'=>$lessonid, 
		'userid'=>$user, 
		'mode'=>$mode));
	})->where(array('question' => '[1,2,4]'));

// Paso 2 - 5 alternativas, Obtener opinión
Route::get('/web/result/2/{question}/{previous}/{survey}/{exercise}/{subject}/{code}/{lessonid}/{user}/{mode}', 
	function ($question, $previous, $survey, $exercise, $subject, $code, $lessonid, $user, $mode) {    
    return View::make('results.result-2', array(
		'question'=>$question,
		'previous'=>$previous,
		'survey'=>$survey,
		'exercise'=>$exercise,
		'subject'=>$subject,
		'code'=>$code, 
		'lessonid'=>$lessonid, 
		'userid'=>$user, 
		'mode'=>$mode));
	})->where(array('question' => '[1,2,4]'));

// Paso 1 - Verdadero/Falso	
Route::get('/web/result/1/3/{run}/{survey}/{exercise}/{subject}/{code}/{lessonid}/{user}/{mode}', 
	function ($run, $survey, $exercise, $subject, $code, $lessonid, $user, $mode) {   
    return View::make('results.tfresult-1', array(
		'question'=>3,
		'run'=>$run,
		'survey'=>$survey,
		'exercise'=>$exercise,
		'subject'=>$subject,
		'code'=>$code, 
		'lessonid'=>$lessonid, 
		'userid'=>$user, 
		'mode'=>$mode));
	});
// Paso 2 - Verdadero/Falso
Route::get('/web/result/2/3/{previous}/{survey}/{exercise}/{subject}/{code}/{lessonid}/{user}/{mode}', 
	function ($previous, $survey, $exercise, $subject, $code, $lessonid, $user, $mode) {    
    return View::make('results.tfresult-2', array(
		'question'=>3,
		'previous'=>$previous,
		'survey'=>$survey,
		'exercise'=>$exercise,
		'subject'=>$subject,
		'code'=>$code, 
		'lessonid'=>$lessonid, 
		'userid'=>$user, 
		'mode'=>$mode));
	});
	
// Checking Student
Route::get('/web/student/{user_id}/{owner_id}/{accesscode}/{previous_answer}/{student_appmode}', 'StudentLessonController@getLessonDetails');

// Open student answer board
Route::get('/web/answer-board/{user}/{code}/{lessonid}/{question}/{survey}/{check}/{mode}', 
	function ($user, $code, $lessonid, $question, $survey, $check, $mode) {
	$details = array('survey'=>$survey,'question'=>$question,'code'=>$code, 
	'lessonid'=>$lessonid, 'userid'=>$user, 'check'=>$check, 'mode'=>$mode);
	if ($question==3){
		return View::make('boards.tfcircle', $details);
	} else if ($question==4) {
		return View::make('boards.square', $details);
	} else {
		return View::make('boards.circle', $details);
	}
});
	
// Answer a question
Route::post('/web/answer/{user_id}/{lesson_id}/{letter}','StudentLessonController@answerQuestion');

// Send email
Route::post('/web/report-answer/{lesson_id}','AjaxController@updateAnswerLesson');
Route::post('/web/report-data/{lesson_id}','AjaxController@updateReportLesson');
Route::get('/web/mail/{user_id}/{lesson_id}','AjaxController@makeReport');
	
	
// Report
Route::get('/web/report/{step}/{question}/{run}/{survey}/{exercise}/{subject}/{code}/{lessonid}/{user}/{mode}', 
	function ($step, $question, $run, $survey, $exercise, $subject, $code, $lessonid, $user, $mode) {   
    return View::make('report-simple', array(
		'step'=>$step,
		'question'=>$question,
		'run'=>$run,
		'survey'=>$survey,
		'exercise'=>$exercise,
		'subject'=>$subject,
		'code'=>$code, 
		'lessonid'=>$lessonid, 
		'userid'=>$user, 
		'mode'=>$mode));
	});

	
Route::get('/web/report-full/{step}/{question}/{run}/{survey}/{exercise}/{subject}/{code}/{lessonid}/{user}/{mode}', 
	function ($step, $question, $run, $survey, $exercise, $subject, $code, $lessonid, $user, $mode) { 
	$details = array(
		'step'=>$step,
		'question'=>$question,
		'run'=>$run,
		'survey'=>$survey,
		'exercise'=>$exercise,
		'subject'=>$subject,
		'code'=>$code, 
		'lessonid'=>$lessonid, 
		'userid'=>$user, 
		'mode'=>$mode);
	if ($mode==1){
		return View::make('report-uni', $details);
	} else {
		return View::make('report-school', $details);
	}
    
	});	
	













    






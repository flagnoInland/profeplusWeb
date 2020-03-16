<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Mobile Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "mobile" middleware group. Now create something great!
|
*/

// Route for getting user password
Route::post('/user/recover-pass', 'RegisterUserController@recover');

// Route for creating new users
Route::post('/user/create', 'RegisterUserController@store');

// Route for signing in user...
Route::post('/usertoken', 'AuthenticateController@authenticate');

// Route for signing in user...
Route::get('/user-auth', 'AuthenticateController@authenticate');

// Route for signing in a school user...
Route::get('/guest-login', 'AuthenticateController@guestLogin');

// Route for answering school question
Route::put('/answer/{accesscode}/{run}/{letter}/{old}','StudentLessonController@answerSchoolQuestion');

// Route for answering question
Route::get('/user/{user_id}/lesson/{lesson_id}/answer/{letter}','StudentLessonController@answerQuestion');
    
// Route for getting details about the lesson    
Route::get('/student/{user_id}/{owner}/lesson/{accesscode}/{previous_answer}/{student_appmode}', 'StudentLessonController@getLessonDetails');

// Route for getting details about the lesson    
Route::get('/lesson/{accesscode}/{id}/{check}/{previous_answer}', 'StudentLessonController@getSchoolLessonDetails');

// Route for registering in a lesson...
Route::post('/student/{user_id}/check-in/{lesson_id}', 'StudentLessonController@checkIn');

// Route for unregistering from a lesson...
Route::put('/student/{user_id}/check-out/{lesson_id}', 'StudentLessonController@checkOut');

// Route for looking up a student...
Route::get('/student/{user_id}/look-up/{lesson_id}', 'StudentLessonController@lookUp');

// Route for getting actual result
    Route::post('/lesson/result-live/{id}/{run}', 'TeacherLessonController@showActualLive');
	
// Route for comparing previous and actual result
    Route::post('/lesson/compare-live/{id}/{previous}', 'TeacherLessonController@compareLive');
	
// Route for getting actual lessonid
    Route::post('/lesson/info-live/{userid}/{code}/{lessonid}', 'StudentLessonController@getLiveInfoLesson');

	

// Route for getting user details
	Route::post('/user/details/{user_id}', 'RegisterUserController@index');

// Route for updating users
	Route::put('/user/update/{user_id}', 'RegisterUserController@update');
    
// Route for change user mode
	Route::post('/user/mode/{user_id}', 'RegisterUserController@changeMode');

// Route for creating lessons...
    Route::get('/lesson/new/{user_id}', 'TeacherLessonController@createLesson');
	
// Route for creating lessons...
    Route::post('/lesson/fix-032017/create/{user_id}', 'TeacherLessonController@storeNewLesson');
    
// Route for updating lessons...
	Route::put('/lesson/update/{id}', 'TeacherLessonController@updateLesson');

// Route for disabling a lesson...
	Route::get('/lesson/disable/{id}', 'TeacherLessonController@disableActual');
    
// Route for getting actual result
    Route::get('/lesson/result/{id}/{run}', 'TeacherLessonController@showActual');
	

    
// Route for comparing previous and actual result
    Route::get('/lesson/compare/{id}/{previous}', 'TeacherLessonController@compareActualPrevious');
	
// Route for disabling code
    Route::get('/code/disable/{code}', 'TeacherLessonController@disableRnds');
    

    
    
// Route for creating evaluations...
    Route::post('/user/{user_id}/evaluation/create', 'EvaluationController@storeNewEvaluation');
	Route::post('/user/{user_id}/evaluation/save', 'EvaluationController@saveNewEvaluation');
    
// Route for connected students...
    Route::get('/evaluation/{eval_id}/lesson/{lesson_id}', 'EvaluationController@connectedStudents');
    
// Route for evaluations...
    //Route::get('/teacher/{user_id}/evaluations', 'EvaluationController@teachersEvaluations'); 

// Alternative change mode
Route::get('/user/mode/{user_id}/{app}/{teacher}', 'RegisterUserController@changeModeNew');

// Mail report
Route::get('/sendemail/{user_id}', 'MailController@mailResults');

// Mail report
Route::get('/makereport/{user_id}/lesson/{lesson_id}', 'MailController@makeReport');
	
// Mail evaluation
Route::get('/sendemail/{user_id}/eval/{eval_id}', 'MailController@mailEvaluations');

// Test mail
Route::get('/testmail/{user_id}', 'MailController@testMail');
	
// Test mail
Route::get('/test-eval-mail/{user_id}', 'MailController@testEval');

Route::get('/teacher/{user_id}/evaluations', 'EvaluationController@teachersEvaluations'); 

Route::get('/teacher/{user_id}/active-evaluations', 'EvaluationController@teachersActiveEvaluations'); 

Route::get('/teacher/{user_id}/evaluation/{eval_id}/deactivate', 'EvaluationController@deactivateEvaluation');

Route::get('/teacher/{user_id}/lesson/{lesson_id}/evaluation/{eval_id}/finish', 'EvaluationController@deactivateLessonEvaluation'); 

Route::get('/teacher/{user_id}/lesson/{lesson_id}/eval/{eval_id}/autofinish', 'EvaluationController@autoMailEvaluation'); 

Route::get('/teacher/{user_id}/evaluation/{eval_id}/details', 'EvaluationController@evaluationDetails');

Route::get('/teacher/{user_id}/evaluation/{eval_id}/full-details', 'EvaluationController@evaluationFullDetails');

Route::put('/teacher/{user_id}/evaluation/{eval_id}/update', 'EvaluationController@evaluationUpdate');

Route::put('/student/{user_id}/lesson/{lesson_id}/evaluation/{eval_id}/sols', 'StudentLessonController@submitEvaluation');

Route::put('/student/{user_id}/lesson/{lesson_id}/evaluation/{eval_id}/finish', 'StudentLessonController@finishEvaluation');
    

Route::get('/videos', array(function () {   
    return Redirect::to('https://www.youtube.com/user/ProfePlus1');;
}));

Route::get('/video', array(function () {   
    return Redirect::to('https://www.youtube.com/user/ProfePlus1');;
}));

<?php

Route::get('/mock', 'WebEvaluationController@getEmpty');

Route::get('/web/exam/testing', function () {   
  return View::make('exams.testing');
});

Route::get('/web/exam/testLogin', 'WebEvaluationController@testLogin');

Route::get('/web/exam/student/{user_id}/{mode}',
  function ($user_id,$mode) {
    $data = array(
              'user_id' => $user_id,
              'mode' => $mode
            );
    return View::make( 'exams.student-start', $data);
});

Route::get('/web/exam/student/{user_id}/{mode}/lesson/{lesson_id}/eval/{eval_id}', 
  function ($user_id,$mode,$lesson_id,$eval_id) {
    $data = array(
              'user_id' => $user_id,
              'mode' => $mode,
              'lesson_id'=>$lesson_id,
              'eval_id'=>$eval_id
            );
    return View::make( 'exams.answer-sheet', $data);
});

Route::get('/web/exam/student/{user_id}/{mode}/lesson/{lesson_id}/custom/eval/{eval_id}', 
  function ($user_id,$mode,$lesson_id,$eval_id) {
    $data = array(
              'user_id' => $user_id,
              'mode' => $mode,
              'lesson_id'=>$lesson_id,
              'eval_id'=>$eval_id
            );
    return View::make( 'exams.custom-answer-sheet', $data);
});

Route::get('/web/exam/lesson/{lesson_id}', 'WebEvaluationController@getExam');

Route::get('/web/exam/lesson/{lesson_id}/status', 'WebEvaluationController@getStatus');

Route::get('/web/exam/eval/{eval_id}/student/{user_id}', 'WebEvaluationController@getExamStudent');

Route::get('/web/exam/student/{user_id}/code/{code}', 'WebEvaluationController@takeExam');

Route::post('/web/exam/student/{user_id}/eval/send/{eval_id}', 'WebEvaluationController@sendExam');


Route::get('/web/exam/teacher/{user_id}/{mode}',
  function ($user_id, $mode) {
    $data = array(
              'user_id' => $user_id,
              'mode' => $mode
            );
    return View::make( 'exams.teacher-start', $data);
})->where(array('mode' => '[1-2]'));

Route::get('/web/exam/teacher/{user_id}/{mode}/new', 
  function ($user_id, $mode) {
    $data = array(
              'user_id' => $user_id,
              'mode' => $mode
            );
    return View::make( 'exams.new-eval', $data);
});

Route::get('/web/exam/teacher/{user_id}/{mode}/fci', 
  function ($user_id, $mode) {
    $data = array(
              'user_id' => $user_id,
              'mode' => $mode
            );
    return View::make( 'exams.fci', $data);
});


Route::get('/web/exam/teacher/{user_id}/{mode}/board', 
  function ($user_id, $mode) {
    $data = array(
              'user_id' => $user_id,
              'mode' => $mode
            );
    return View::make( 'exams.board', $data);
});

Route::get('/web/exam/teacher/{user_id}/{mode}/board/lesson/{lessonId}', 
  function ($user_id, $mode, $lessonId) {
    $data = array(
              'user_id' => $user_id,
              'mode' => $mode,
              'lessonId' => $lessonId
            );
    return View::make( 'exams.eval-code', $data);
});

Route::get('/web/exam/teacher/{user_id}/code', function () {   
  return View::make('exams.eval-code');
});

Route::post('/web/exam/teacher/{user_id}/new', 'WebEvaluationController@create');

Route::post('/web/exam/teacher/{user_id}/start/{lesson_id}', 'WebEvaluationController@startExam');

Route::get('/web/exam/teacher/{user_id}/index', 'WebEvaluationController@index');

Route::get('/web/exam/teacher/{user_id}/show/{lesson_id}', 'WebEvaluationController@examIndex');

Route::get('/web/exam/teacher/{user_id}/show/full/{lesson_id}', 'WebEvaluationController@indexEval');

Route::post('/web/exam/teacher/{user_id}/end/{lesson_id}', 'WebEvaluationController@destroy');

Route::post('/web/exam/teacher/{user_id}/remove/{eval_id}', 'WebEvaluationController@removeByLesson');

Route::post('/web/exam/teacher/{user_id}/cleanExam', 'WebEvaluationController@cleanExam');

Route::get('/web/exam/email/{user_id}/eval/{eval_id}', 'WebEvaluationController@mailExam');

Route::post('/web/exam/teacher/{user_id}/custom/eval/new/{custom_eval_id}', 'WebEvaluationController@createCustomEval');

Route::get('/web/exam/teacher/{user_id}/custom/eval/status/{custom_eval_id}', 'WebEvaluationController@statusCustomEval');

Route::get('/web/exam/email/{user_id}/custom/eval/{custom_eval_id}', 'WebEvaluationController@mailCustomEval');

Route::post('/web/exam/teacher/{user_id}/remove/custom/eval/{custom_eval_id}', 'WebEvaluationController@removeCustomEval');

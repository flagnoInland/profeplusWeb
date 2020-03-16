<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Validator, Input, Redirect, Response, DB; 
use Carbon\Carbon;
use App\User;
use App\Lesson;
use App\Evaluation;
use App\RandomNumber;
use App\Rands;


class TeacherLessonController extends Controller {
    
    const S_NONE = 1;
    const S_SATISFACTION = 2;
    const S_AGREEMENT = 3;
    const S_QUALIFICATION = 4;
    const S_SPEAKER = 5;

    const Q_NORMAL = 1;
    const Q_BANK = 2;
    const Q_TRUE = 3;
    const Q_SURVEY = 4;
    const Q_EVAL = 5; 

    const STUDENT = 0;
    const TEACHER = 1;

    const NORMAL_MODE = 1;
    const SCHOOL_MODE = 2;

    const ACTIVE = 0;
    const INACTIVE = 1;
    
    // TRUE =>1
    // FALSE=>0
	
    public function createLesson($user_id) {
        $response = DB::connection()->transaction(function() use($user_id) {
        // start a new lesson
        //$token = Input::get('auth_token');
        $teacher = User::find($user_id);
        $data = Input::json()->all();
        $lesson = new Lesson(array(
                'course_id' => $data['course_id'],
                'evaluation_id' => $data['evaluation_id'],
                'accesscode' => $data['accesscode'],
                'subject' => $data['subject'],
                'exercise' => $data['exercise'],
                'status' => $data['inactive'],
                'app_mode' => $data['app_mode'],
                'run' => $data['run'],
                'survey' => $data['survey'],
                'question_type' => $data['question_type'],
                'question_mode' => $data['question_mode'],               
            ));
        // save lesson to get ID
        $teacher->lessons()->save($lesson);    
        // get a new accescode
        if ($data['accesscode'] == 0){
			//$code = $this->generateRnds($lesson->id);
            $code = RandomNumber::find($lesson->id % 8999 + 1)->random;
            $lesson->accesscode = $code; 
            $lesson->save();    
        } else {
            $code = $lesson->accesscode;
        }
        // evaluations case      
        if ($data['evaluation_id']!= 0){
            $eval = Evaluation::find($data['evaluation_id']);
            $eval->lesson_id = $lesson->id;
            $eval->save();
        }
        
        // disable old unfinished lessons
        $ulessons = Lesson::where(function ($query) use ($code) {$query->where('accesscode', '=', $code);})
			->where(function ($query) {$query->where('status', '=', 0);})->get();
        $count = count($ulessons);
        foreach ($ulessons as $ulesson) {
            if (--$count <= 0) {
                break;
            }
            $ulesson->status = Lesson::DISABLED;
            $ulesson->save();
        }
        $details = array(
            'id' => $lesson->id,
            'run' => $lesson->run,
            'accesscode'=> $code
        );
        return Response::json($details, JsonResponse::HTTP_CREATED);
        });
    return $response;
    }
    
    
    public function storeNewLesson($user_id) {
        $response = DB::connection()->transaction(function() use($user_id){
        // start a new lesson
        //$token = Input::get('auth_token');
        //$user = AuthToken::validate($token);
        $teacher = User::find($user_id);
        $data = Input::json()->all();
        $lesson = new Lesson(array(
            'course_id' => $data['course_id'],
            'evaluation_id' => $data['evaluation_id'],
            'accesscode' => $data['accesscode'],
            'subject' => $data['subject'],
            'exercise' => $data['exercise'],
            'status' => $data['inactive'],
            'app_mode' => $data['app_mode'],
            'run' => $data['run'],
            'survey' => $data['survey'],
            'question_type' => $data['question_type'],
            'question_mode' => $data['question_mode'],               
        ));
        // save lesson to get ID
        $teacher->lessons()->save($lesson);    
        // get a new accescode
        if ($data['accesscode'] == 0){
            $code = RandomNumber::find($lesson->id % 8999 + 1)->random;
            $lesson->accesscode = $code; 
            $lesson->save();    
        } else {
            $code = $lesson->accesscode;
        }
        // evaluations case      
        if ($data['evaluation_id']!= 0){
            $eval = Evaluation::find($data['evaluation_id']);
            $eval->lesson_id = $lesson->id;
            $eval->save();
        }
        
        // disable old unfinished lessons
        $ulessons = Lesson::where(function ($query) use ($code) {$query->where('accesscode', '=', $code);})
			->where(function ($query) {$query->where('status', '=', 0);})->get();
        $count = count($ulessons);
        foreach ($ulessons as $ulesson) {
            if (--$count <= 0) {
                break;
            }
            $ulesson->inactive = 1;
            $ulesson->save();
        }
        $details = array(
            'id' => $lesson->id,
            'run' => $lesson->run,
            'accesscode'=> $code
        );
        return Response::json($details, JsonResponse::HTTP_CREATED);
        });
    return $response;
    }
    
    public function updateLesson($id) {
        $response = DB::connection()->transaction(function() use($id) {
        //$token = Input::get('auth_token');
        //$user = AuthToken::validate($token);
        $data = Input::json()->all();
        $lesson = Lesson::find($id);
        $lesson->course_id = $data['course_id'];
        //$lesson->evaluation_id = $data['evaluation_id'];
        $lesson->accesscode = $data['accesscode'];
        $lesson->subject = $data['subject'];
        $lesson->exercise = $data['exercise'];	
        $lesson->run = $data['run'];		
        $lesson->status = Lesson::ENABLED;
        $lesson->survey = $data['survey'];
        $lesson->question_type = $data['question_type'];
        $lesson->question_mode = $data['question_mode'];
        $lesson->level = $data['level'];
        $lesson->grade = $data['grade'];
        $lesson->observations = $data['observation'];
        $lesson->classroom = $data['classroom'];
        $lesson->institution = $data['institution'];
        $lesson->speciality = $data['speciality'];
        $lesson->course_name = $data['course_name'];
        $lesson->answer_keys = $data['answer_keys'];
        $lesson->save();
        return Response::json(array(), JsonResponse::HTTP_OK);
        });
    return $response;
    }
        
    public function showActual($id,$run){
        //$token = Input::get('auth_token');
        //$user = AuthToken::validate($token);
        $lesson = Lesson::find($id);
        $answers = array(
            'ans1' => $lesson->ans1,
            'ans2' => $lesson->ans2,
            'ans3' => $lesson->ans3,
            'ans4' => $lesson->ans4,
            'ans5' => $lesson->ans5,
            'ans_yes' => $lesson->ans_yes,
            'ans_no' => $lesson->ans_no,
            'ans_na' => $lesson->ans_na,            
            'ansnn' => $lesson->ansnn,
            'inlesson' => $lesson->inlesson,               
        );
    return Response::json($answers, JsonResponse::HTTP_OK);
    }
	
    public function showActualLive($id,$run){
        $data = Input::json()->all();
        $dats = $data["graph"];
        //$anss = array(0,0,0,0,0,0,0,0,0,0);
        $anss = $this->myQuestionData($id);
        $answers = array(
            'ans1' => $anss[0],
            'ans2' => $anss[1],
            'ans3' => $anss[2],
            'ans4' => $anss[3],
            'ans5' => $anss[4],
            'ans_yes' => $anss[5],
            'ans_no' => $anss[6],
            'ans_na' => $anss[7],            
            'ansnn' => $anss[8],
            'inlesson' => $anss[9],               
        );
        //Log::info('anss:');
        //Log::info($anss);
        //Log::info('dats:');
        //Log::info($dats);
        $response = Response::json($answers, JsonResponse::HTTP_OK);
        //return $response;
        $sent = true;
        $time = 0;
        do {
            if (!$sent) {
                sleep(2);
                $time += 2;
                $anss = $this->myQuestionData($id);
            }
            if ($time < 100){
                for ($x = 0; $x < 10; $x++){
                    if ($anss[$x] != $dats[$x] ){
                        return $response;
                    } 
                }
                $sent = false;
            } else{
                return $response;
            }				
        } while (!$sent);
    }
	
    private function myQuestionData($id){
        $lesson = Lesson::find($id);
        $anss[] = $lesson->ans1;
        $anss[] = $lesson->ans2;
        $anss[] = $lesson->ans3;
        $anss[] = $lesson->ans4;
        $anss[] = $lesson->ans5;
        $anss[] = $lesson->ans_yes;
        $anss[] = $lesson->ans_no;
        $anss[] = $lesson->ans_na;
        $anss[] = $lesson->ansnn;
        $anss[] = $lesson->inlesson;
        return $anss;
    }
    
    public function compareActualPrevious($id,$previous){
        //$token = Input::get('auth_token');
        //$user = AuthToken::validate($token);
        $lesson = Lesson::find($id);
        $lessoni = Lesson::find($previous);
        $answers = array(
            'ans1' => $lesson->ans1,
            'ans2' => $lesson->ans2,
            'ans3' => $lesson->ans3,
            'ans4' => $lesson->ans4,
            'ans5' => $lesson->ans5,
            'ans_yes' => $lesson->ans_yes,
            'ans_no' => $lesson->ans_no,
            'ans_na' => $lesson->ans_na,            
            'ansnn' => $lesson->ansnn,
            'inlesson' => $lesson->inlesson,
            'ans1i' => $lessoni->ans1,
            'ans2i' => $lessoni->ans2,
            'ans3i' => $lessoni->ans3,
            'ans4i' => $lessoni->ans4,
            'ans5i' => $lessoni->ans5,
            'ans_yesi' => $lessoni->ans_yes,
            'ans_noi' => $lessoni->ans_no,
            'ans_nai' => $lessoni->ans_na,            
            'ansnni' => $lessoni->ansnn,
            'inlessoni' => $lessoni->inlesson,                
        );
        return Response::json($answers, JsonResponse::HTTP_OK);
    }
	
    public function compareLive($id, $previous){
        $data = Input::json()->all();
        $dats = $data["graph"];
        //$anss = array(0,0,0,0,0,0,0,0,0,0);
        $lessoni = Lesson::find($previous);
        $anss = $this->myQuestionData($id);
        $answers = array(
            'ans1' => $anss[0],
            'ans2' => $anss[1],
            'ans3' => $anss[2],
            'ans4' => $anss[3],
            'ans5' => $anss[4],
            'ans_yes' => $anss[5],
            'ans_no' => $anss[6],
            'ans_na' => $anss[7],            
            'ansnn' => $anss[8],
            'inlesson' => $anss[9],
            'ans1i' => $lessoni->ans1,
            'ans2i' => $lessoni->ans2,
            'ans3i' => $lessoni->ans3,
            'ans4i' => $lessoni->ans4,
            'ans5i' => $lessoni->ans5,
            'ans_yesi' => $lessoni->ans_yes,
            'ans_noi' => $lessoni->ans_no,
            'ans_nai' => $lessoni->ans_na,            
            'ansnni' => $lessoni->ansnn,
            'inlessoni' => $lessoni->inlesson, 				
        );
        $response = Response::json($answers, JsonResponse::HTTP_OK);
        $sent = true;
        $time = 0;
        do {
            if (!$sent) {
                sleep(2);
                $time += 2;
                $anss = $this->myQuestionData($id);
            }
            if ($time < 100){
                for ($x = 0; $x < 10; $x++){
                    if ($anss[$x] != $dats[$x] ){
                        return $response;
                    } 
                }
                $sent = false;
            } else{
                return $response;
            }				
        } while (!$sent);
    }
	
	
    
    public function disableActual($id) {
        $response = DB::connection()->transaction(function() use ($id) {
        //$token = Input::get('auth_token');
        //$user = AuthToken::validate($token);
        $lesson = Lesson::find($id);
        if ($lesson != null){
            #$lesson->accesscode = $lesson->accesscode.'R';
            $lesson->status = Lesson::DISABLED;
            $lesson->save();
            return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
        } else {
            return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
        }
        });
    return $response;
    }
	
    public function generateRnds($id){
        //srand(time());
        srand($id);
        do {
            $code = rand(1,9999);
            $isRnd = Rands::where('accesscode',$code)->where('disabled',0)->first();
        } while ($isRnd != null);
        Rands::create(array('accesscode'=>$code, 'disabled'=>0));
        return str_pad($code, 4, '0', STR_PAD_LEFT);
    }

    public function disableRnds($code){
        $rnd = Rands::where('accesscode',$code)->first();
        $rnd->disabled = 1;
        $rnd->save();
        return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
    }
      
}

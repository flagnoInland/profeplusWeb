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
use App\EvaluationStudent;
use App\LessonUser;


class StudentLessonController extends Controller {
    
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
   
    
	public function answerQuestion($user_id, $lesson_id, $letter) {
        $response = DB::connection()->transaction(function() use ($user_id, $lesson_id, $letter){ 
            $lesson = Lesson::where('id',$lesson_id)->where('status',Lesson::ENABLED)->first();
			$lessonuser = LessonUser::where('user_id', $user_id)->where('lesson_id', $lesson_id)->first();  
			if ($lesson!= null){
				if ($lessonuser->answer == 0) {
					$lesson->collectAnswer($letter);
					$lessonuser->setAnswer($letter); 
					return JsonResponse::HTTP_CREATED;
				}							
				if ($lessonuser->answer == 1){
					$letter2 = $lessonuser->last_answer;
					$lesson->changeAnswer($letter, $letter2);
					$lessonuser->setAnswer($letter);         
					return Response::json(new \stdClass(), JsonResponse::HTTP_OK);                   
				}			    
			} else {
				return Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);     
				
			}                                             
        });
        return $response;
	}
    
	
    public function answerQuestionOld($user_id, $lesson_id, $letter) {
        $response = DB::connection()->transaction(function() use ($user_id, $lesson_id, $letter){ 
            $lesson = Lesson::where('id',$lesson_id)->where('status',Lesson::ENABLED)->first();
			$lessonuser = LessonUser::where('user_id', $user_id)->where('lesson_id', $lesson_id)->first();  
			if ($lesson!= null){				         
				switch($letter) {
                    case "A":
                        $lesson->ans1 = $lesson->ans1 + 1;
                        break;
                    case "B":
                        $lesson->ans2 = $lesson->ans2 + 1;
                        break;
                    case "C":
                        $lesson->ans3 = $lesson->ans3 + 1;
                        break;
                    case "D":
                        $lesson->ans4 = $lesson->ans4 + 1;
                        break;
                    case "E":
                        $lesson->ans5 = $lesson->ans5 + 1;
                        break;
                    case "F":
                        $lesson->ans_yes = $lesson->ans_yes + 1;
                        break;
                    case "G":
                        $lesson->ans_no = $lesson->ans_no + 1;
                        break;
                    case "H":
                        $lesson->ans_na = $lesson->ans_na + 1;
                        break;
                    case "Z":
                        break;
                }
				if ($lessonuser->answer == 0){
					if ($lesson->ansnn > 0){
						$lesson->ansnn = $lesson->ansnn-1;
					}
					$lessonuser->answer = 1;
					$lessonuser->last_answer = $letter;
					$lessonuser->save();
					$lesson->save();
					return JsonResponse::HTTP_CREATED;
				}
				if ($lessonuser->answer == 1){
					switch($lessonuser->last_answer) {
                    case "A":
                        if ($lesson->ans1 > 0) { 
                            $lesson->ans1 = $lesson->ans1 - 1;
                        }
                        break;
                    case "B":
                        if ($lesson->ans2 > 0) {
                            $lesson->ans2 = $lesson->ans2 - 1;
                        }
                        break;
                    case "C":
                        if ($lesson->ans3 > 0) {
                            $lesson->ans3 = $lesson->ans3 - 1;
                        }
                        break;
                    case "D":
                        if ($lesson->ans4 > 0) { 
                            $lesson->ans4 = $lesson->ans4 - 1;
                        }
                        break;
                    case "E":
                        if ($lesson->ans5 > 0) {
                        $lesson->ans5 = $lesson->ans5 - 1;
                        }
                        break;
                    case "F":
                        if ($lesson->ans_yes > 0) {
                        $lesson->ans_yes = $lesson->ans_yes - 1;
                        }
                        break;
                    case "G":
                        if ($lesson->ans_no > 0) {
                        $lesson->ans_no = $lesson->ans_no - 1;
                        }
                        break;
                    case "H":
                        if ($lesson->ans_na > 0) {
                        $lesson->ans_na = $lesson->ans_na - 1;
                        }
                        break;
                    case "Z":
                        break;
					} 
				}
				$lessonuser->last_answer = $letter;
				$lessonuser->save();            
				$lesson->save();  
				return Response::json(new \stdClass(), JsonResponse::HTTP_OK);     
			} else {
				return Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);     
				
			}                                             
        });
        return $response;
	}
    
      
    public function answerSchoolQuestion($accesscode, $run, $letter, $old) {
        $response = DB::connection()->transaction(function() use ($accesscode, $run, $letter, $old){                  
            $lesson = Lesson::where( 'id', $accesscode)->where('run', $run)->where(function ($query) {$query->where('status', '=', 0);})->first();          
             switch($letter) {
                case "A":
                    $lesson->ans1 = $lesson->ans1 + 1;
                    break;
                case "B":
                    $lesson->ans2 = $lesson->ans2 + 1;
                    break;
                case "C":
                    $lesson->ans3 = $lesson->ans3 + 1;
                    break;
                case "D":
                    $lesson->ans4 = $lesson->ans4 + 1;
                    break;
                case "E":
                    $lesson->ans5 = $lesson->ans5 + 1;
                    break;
                case "F":
                    $lesson->ans_yes = $lesson->ans_yes + 1;
                    break;
                case "G":
                    $lesson->ans_no = $lesson->ans_no + 1;
                    break;
                case "H":
                    $lesson->ans_na = $lesson->ans_na + 1;
                    break;
                case "Y":
                    break;
            }
            switch($old) {
                case "A":
                    if ($lesson->ans1 > 0) { 
                        $lesson->ans1 = $lesson->ans1 - 1;
                    }
                    break;
                case "B":
                    if ($lesson->ans2 > 0) {
                        $lesson->ans2 = $lesson->ans2 - 1;
                    }
                    break;
                case "C":
                    if ($lesson->ans3 > 0) {
                        $lesson->ans3 = $lesson->ans3 - 1;
                    }
                    break;
                case "D":
                    if ($lesson->ans4 > 0) { 
                        $lesson->ans4 = $lesson->ans4 - 1;
                    }
                    break;
                case "E":
                    if ($lesson->ans5 > 0) {
                    $lesson->ans5 = $lesson->ans5 - 1;
                    }
                    break;
                case "F":
                    if ($lesson->ans_yes > 0) {
                    $lesson->ans_yes = $lesson->ans_yes - 1;
                    }
                    break;
                case "G":
                    if ($lesson->ans_no > 0) {
                    $lesson->ans_no = $lesson->ans_no - 1;
                    }
                    break;
                case "H":
                    if ($lesson->ans_na > 0) {
                    $lesson->ans_na = $lesson->ans_na - 1;
                    }
                    break;
                case "Y":
                    break;
            } 
            if ($old == "Y" && $letter != "Y"){
                if ($lesson->ansnn > 0) {
                    $lesson->ansnn = $lesson->ansnn - 1;
                }                  
            }        
            $lesson->save();          
            return Response::json(new \stdClass(), JsonResponse::HTTP_OK);                
        });
        return $response;
	}
	
	
	public function getLiveInfoLesson($user_id, $accesscode, $lessonid){
		$student = User::find($user_id);
		if ( $student != null ) {
            $time = 0;
			$response  = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
			do {
				sleep(2);
				$time += 2;
				$lesson = Lesson::where('accesscode', $accesscode)->where('status', Lesson::ENABLED)->first();
				if ($lesson->id != $lessonid) {
					return Response::json(array('id'=>$lesson->id,'updated'=>1), JsonResponse::HTTP_OK);
				}
				if ($time >= 100){
					return Response::json(array('id'=>$lesson->id,'updated'=>0), JsonResponse::HTTP_NOT_FOUND);
				}				
			} while ($lesson->id == $lessonid);
        } else {
            return Response::json(new \stdClass(), JsonResponse::HTTP_BAD_REQUEST);
        }
	}
    
        
        
    /* Este método funcionará correctamente con un usuario guest si 
     * el usuario guest ha cambiado su modo previamente*/
    public function getLessonDetails($user_id, $owner, $accesscode, $previous_answer, $student_appmode) {  
        $student = User::find($user_id);
        Log::info($student);
        if ( $student != null ) {
            //Evaluacion Calificada y FCI
            $lesson = Lesson::hasEvaluation($accesscode)->first();
            Log::info($lesson);
            if ($lesson != null){
                $exam = $lesson->evaluation()->data()->first();
                $examinado = EvaluationStudent::findExaminado($user_id, $exam->id)->first();
                if ( $examinado == null ) {
                    $lesson->addStudent();
                    $examinado = new EvaluationStudent(array(
                      'evaluation_id'=>$exam->id,
                      'status'=> EvaluationStudent::INCOMPLETE,
                      'solutions' => $this->initAnswers($exam->questions),
                    ));
                    $student->evaluationstudents()->save($examinado);
                    $response = Response::json($exam, JsonResponse::HTTP_OK);
                } else if ( $examinado['status'] != EvaluationStudent::DONE){
                    $response = Response::json($exam, JsonResponse::HTTP_OK);
                    //$response  = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
                }   
            }
            else{
                //Otros
                $lesson = Lesson::where( 'accesscode', $accesscode)->where(function ($query) {$query->where('status', '=', 0);})->first();
                if ($lesson != null && $lesson->question_type != 5)
                    //&& $lesson->app_mode == $student_appmode ) 
                {
    				$response = $this->normalLessonDetails($user_id, $owner, $lesson, $previous_answer); 
    			} else {
                                //Log::info($lesson);
    				//$details =array('lesson'=>$lesson->app_mode, 'student'=>$student->appmode);
                    $response  = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
                }
            }
        } else {
            $response  = Response::json(new \stdClass(), JsonResponse::HTTP_BAD_REQUEST);
        }
        return $response;
	}

    
    public function evaluationLessonDetails($user_id, $lesson, $previous_answer){
        $student = User::find($user_id);
		$evaluation = Evaluation::where('id',$lesson->evaluation_id)
						->where('status',StudentLessonController::ACTIVE)
						->where('statusLesson',StudentLessonController::ACTIVE)
						->first();
		if ( $evaluation != null){
			$numQuestion = $evaluation->number_question;
			$sols = '';
			for ($x = 0; $x < $numQuestion-1; $x++){
					$sols = $sols.'0,';
			} 
			$sols = $sols.'0';
			$evaluser = EvaluationStudent::where('user_id', $user_id)
							->where('lesson_id', $lesson->id)
							->first();
			if ($evaluser == null) {
				$evaluser = new EvaluationStudent(array(
					'lesson_id' => $lesson->id,
					'evaluation_id'=>$lesson->evaluation_id,
					'solutions'=>$sols,
					'status'=>StudentLessonController::ACTIVE,
					'score'=>0,
				));
				$student->evaluationstudents()->save($evaluser);
				$lesson->inlesson = $lesson->inlesson+1;
				$lesson->save();
				$details = array(
					'id' => $lesson->id,
					'subject' => $lesson->subject,
					'exercise' => $lesson->exercise,
					'run' => $lesson->run,
					'survey' => $lesson->survey,
					'question_type' => $lesson->question_type,
					'question_mode' => $lesson->question_mode,   
					'check' => 0,
					'last_answer' => $previous_answer,
					'evaluation_id' => $lesson->evaluation_id,
					'solutions'=>$sols,
					'duration'=>$evaluation->duration,
					//'updated'=>$evaluation->updated_at->toDateTimeString(),
					'updated' => $evaluation->start_time,
				);      
				$response = Response::json($details, JsonResponse::HTTP_OK);
			} else if ( $evaluser != null && $evaluser->status != StudentLessonController::INACTIVE){           
				$details = array(
					'id' => $lesson->id,
					'subject' => $lesson->subject,
					'exercise' => $lesson->exercise,
					'run' => $lesson->run,
					'survey' => $lesson->survey,
					'question_type' => $lesson->question_type,
					'question_mode' => $lesson->question_mode,   
					'check' => 0,
					'last_answer' => $previous_answer,
					'evaluation_id' => $lesson->evaluation_id,
					'solutions' => $evaluser->solutions,
					'duration'=>$evaluation->duration,
					//'updated'=>$evaluation->updated_at->toDateTimeString(),
					'updated' => $evaluation->start_time,
				);      
				$response = Response::json($details, JsonResponse::HTTP_OK);
			} else {
				$response  = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
			}
		} else {
			$response  = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
		}		
        return $response;
        
    }

	
    public function normalLessonDetails ($user_id, $owner, $lesson, $previous_answer){
        $student = User::find($user_id);
        $students = LessonUser::where('user_id', $user_id)->where('lesson_id', $lesson->id)->first();
        if ($students == null){ 
            $value = 0;                       
            $lessonuser = new LessonUser(array(
                    'lesson_id' => $lesson->id,
                    'run'=>$lesson->run,
                    'answer' => 0,
                    'last_answer' => $previous_answer,
					'owner' => $owner
            ));
            $student->lessonsusers()->save($lessonuser);
            $lesson->inlesson = $lesson->inlesson+1;
            $lesson->ansnn = $lesson->ansnn+1;
            $lesson->save();
            $details = array(
                'id' => $lesson->id,
                'subject' => $lesson->subject,
                'exercise' => $lesson->exercise,
                'run' => $lesson->run,
                'survey' => $lesson->survey,
                'question_type' => $lesson->question_type,
                'question_mode' => $lesson->question_mode,
                'evaluation_id' => 0,                
                'check' => $value,
                'last_answer' => $previous_answer,
				'evaluation_id' => 0,
				'solutions' => '0,0,0',
				'duration'=> 0,
				'updated'=> '',				
            );      
            $response = Response::json($details, JsonResponse::HTTP_OK);           
        } else {
            $value = $students->answer;
            $last_answer = 'Z';
            if ($students->last_answer == null){
                $last_answer = 'Z';
            } else {
                $last_answer = $students->last_answer;
            }
            $details = array(
                'id' => $lesson->id,
                'subject' => $lesson->subject,
                'exercise' => $lesson->exercise,
                'run' => $lesson->run,
                'survey' => $lesson->survey,
                'evaluation_id' => 0,    
                'question_type' => $lesson->question_type,
                'question_mode' => $lesson->question_mode,  
                'check' => $value,
                'last_answer' => $last_answer,
				'evaluation_id' => 0,
				'solutions' => '0,0,0',
				'duration'=> 0,
				'updated'=>'',
            );      
            $response = Response::json($details, JsonResponse::HTTP_OK); 
        }
        return $response;
    }
       
       
    public function getSchoolLessonDetails($accesscode, $id, $check, $previous_answer) {  
        $response = DB::connection()->transaction(function() use ($accesscode, $id, $check, $previous_answer) {
        $lesson = Lesson::where( 'accesscode', $accesscode)->where(function ($query) {$query->where('status', '=', 0);})->first();
        if ($id != $lesson->id){
            $previous_answer = "Z";        
            $check = 0;                 
        } 
        if ($previous_answer == "Z") {
            $lesson->inlesson = $lesson->inlesson+1;
            $lesson->ansnn = $lesson->ansnn+1;
            $previous_answer = "Y";
        }      
        $lesson->save();        
        $details = array(
                'id' => $lesson->id,
                'subject' => $lesson->subject,
                'exercise' => $lesson->exercise,
                'run' => $lesson->run,
                'survey' => $lesson->survey,
                'check' => $check,
                'question_type' => $lesson->question_type,
                'question_mode' => $lesson->question_mode,
                'last_answer' => $previous_answer,    
            );      
        return Response::json($details, JsonResponse::HTTP_OK);
        });       
        return $response;      
    }

    
    public function checkIn($user_id, $lesson_id) {
		$student = User::find($user_id);
		$data = Input::json()->all();
        if ($student != null) {
            $lessonuser = new LessonUser(array(
                    'lesson_id' => $lesson_id,
                    'run'=>$run,
                    'answer' => $data['answer']
            ));
            $student->lessonsusers()->save($lessonuser);
            $lesson = Lesson::find($lesson_id);
            $lesson->inlesson = $lesson->inlesson+1;
            $lesson->ansnn = $lesson->ansnn+1;
            $lesson->save();
            $response = Response::json(array(), JsonResponse::HTTP_CREATED);
        } else {
            $response = Response::json(array(), JsonResponse::HTTP_BAD_REQUEST);
        }
        return $response;
	}

    
	public function checkOut($user_id,$lesson_id) {
        $student = User::find($user_id);
		$data = Input::json()->all();	
        if ($student != null){
            $lessonuser = User::find($user_id)->lessonsusers()->where( 'lesson_id', $lesson_id)
                    ->where(function ($query) {$query->where('answer', '=', 0);})->first();
            $lessonuser->answer = $data['answer'];
            $lessonuser->save();
            $response = Response::json(array(), JsonResponse::HTTP_OK);
        } else {
            $response = Response::json(array(), JsonResponse::HTTP_BAD_REQUEST);
        }
        return $response;
	}

    
    public function lookUp($user_id,$lesson_id) {
		$student = User::find($user_id);
        if ($student != null) {
            $students = LessonUser::where('user_id', $user_id)->where('lesson_id', $lesson_id)->first();
            if ($students == null){
                $value = 2;
            } else {
                $value = $students->answer;
            }
            $response = Response::json(array('answer' => $value), JsonResponse::HTTP_OK);
        } else {
            $response = Response::json(array(), JsonResponse::HTTP_BAD_REQUEST);
        }
        return $response;
	}

    
    public function submitEvaluation($user_id,$lesson_id,$eval_id) {

        $evaluser = EvaluationStudent::where('user_id', $user_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('status',StudentLessonController::ACTIVE)
                        ->first();
        $eval = Evaluation::find($eval_id);
        
        $questions = $eval->number_question;
        $data = Input::json()->all();        
        $sols = $data['solutions'];
        $weights = $eval->answer_weights;
        $keys = $eval->answer_keys;
        //str_replace("\[","",$weights);
        //str_replace("\]","",$weights);
        $v_sols = explode(",",$sols);
        $v_weights = explode(",",$weights);
        $v_keys = explode(",",$keys);
        $sol = array();
        $weight = array();      
        $key = array();
        foreach ($v_sols as $x1){
            $sol[] = (int) $x1;
        }
        foreach ($v_weights as $x2){
            $weight[] = (double) $x2;   
        }
        foreach ($v_keys as $x3){
            $key[] = (int) $x3;            
        }  
        
        $score = 0;
        if ($evaluser != null) {
            for ($x = 0; $x < $questions; $x++){
                if ($sol[$x] == $key[$x]){
                    $score = $score + $weight[$x];
                }
            }           
			$evaluser->solutions = $sols;				
            $evaluser->score = $score;
            $evaluser->save();
            $response = Response::json(array(), JsonResponse::HTTP_OK);
        } else {
            $response = Response::json(array(), JsonResponse::HTTP_NOT_FOUND);
        }
        return $response;
	}
    
    
    public function finishEvaluation($user_id,$lesson_id,$eval_id) {

        $evaluser = EvaluationStudent::where('user_id', $user_id)
                        ->where('lesson_id', $lesson_id)
                        ->where('status',StudentLessonController::ACTIVE)
                        ->first();
        $eval = Evaluation::find($eval_id);
        
        $questions = $eval->number_question;
        $data = Input::json()->all();        
        $sols = $data['solutions'];
        $weights = $eval->answer_weights;
        $keys = $eval->answer_keys;
        //str_replace("\[","",$weights);
        //str_replace("\]","",$weights);
        $v_sols = explode(",",$sols);
        $v_weights = explode(",",$weights);
        $v_keys = explode(",",$keys);
        $sol = array();
        $weight = array();      
        $key = array();
        foreach ($v_sols as $x){
            $sol[] = (int) $x;            
        }
        foreach ($v_weights as $x){
            $weight[] = (double) $x;            
        }
        foreach ($v_keys as $x){
            $key[] = (int) $x;            
        }  
        
        $score = 0;
        if ($evaluser != null) {
            for ($x = 0; $x < $questions; $x++){
                if ($sol[$x] == $key[$x]){
                    $score = $score + $weight[$x];
                }
            } 
			$evaluser->solutions = $sols;	
            $evaluser->score = $score;
            $evaluser->status = StudentLessonController::INACTIVE;
            $evaluser->save();
            $response = Response::json(array(), JsonResponse::HTTP_OK);
        } else {
            $response = Response::json(array(), JsonResponse::HTTP_NOT_FOUND);
        }
        return $response;
	}

    private function initAnswers($num){
        $sols = array();
        for ($x = 0; $x < $num; $x++){
          $sols[$x] = 0;            
        }
        //Log::info($sols);
        return implode(",",$sols);
      }
    
        
}

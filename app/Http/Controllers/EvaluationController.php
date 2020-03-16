<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Validator, Input, Redirect, Response, DB, Mail; 
use Carbon\Carbon;
use App\User;
use App\Lesson;
use App\Evaluation;
use App\EvaluationStudent;
use App\RandonNumber;
use App\Rands;


class EvaluationController extends Controller {
    
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
    
    
    public function storeNewEvaluation($user_id) {
        $response = DB::connection()->transaction(function(){
        // start a new lesson
		$data = Input::json()->all();
        $teacher = User::find($data['user_id']);
		$duration = $data['duration'];
		$evaluation = new Evaluation(array(
				'user_id' => $data['user_id'],
                'number_question' => $data['number_question'],
				'overall_score' => $data['overall_score'],
				'start_time' => Carbon::now(),
				//'end_time' => date('Y-m-d H:i'),
				'end_time' => Carbon::now()->addMinutes($duration),
				'date' => date('Y-m-d'),
				'duration' => $duration,
				'course_name' => $data['course_name'],
				'speciality' => $data['speciality'],
				'institution' => $data['institution'],
                'exam_title' => $data['exam_title'],
                'materials' => $data['materials'],
                'answer_keys' => $data['answer_keys'],            
				'answer_weights' => $data['answer_weights'],
				'observations' => $data['observations'],
                'statusLesson' => $data['statusLesson'],
                'lesson_id' => $data['lesson_id'],
                'status' => $data['status'],
		));
        // save lesson to get ID
        $teacher->evaluations()->save($evaluation);    
		$evals = DB::table('profeplus_evaluations')
                        ->whereRaw('profeplus_evaluations.date > DATE_SUB(now(), INTERVAL 1 DAY)')
                        ->where('profeplus_evaluations.status',EvaluationController::ACTIVE)
                        ->where('profeplus_evaluations.user_id',$evaluation->user_id)
                        ->count();
		$details = array(
			'evalId' => $evaluation->id,
			'evaluations' => $evals,
		);
		return Response::json($details, JsonResponse::HTTP_CREATED);
        });
        return $response;
	}
	
	public function saveNewEvaluation($user_id) {
        $response = DB::connection()->transaction(function(){
        // start a new lesson
		$data = Input::json()->all();
		$start = Carbon::createFromFormat('Y-m-d H:i:s', $data['start_time']);
		$end = Carbon::createFromFormat('Y-m-d H:i:s', $data['end_time']);
		$duration = $start->diffInMinutes($end); 
        $teacher = User::find($data['user_id']);
		$evaluation = new Evaluation(array(
				'user_id' => $data['user_id'],
                'number_question' => $data['number_question'],
				'overall_score' => $data['overall_score'],
				//'start_time' => $data['start_time'],
				//'end_time' => $data['end_time'],
				'start_time' => $start->toDateTimeString(),
				'end_time' => $end->toDateTimeString(),
				'date' => $data['date'],
				//'duration' => $data['duration'],
				'duration' => $duration,
				'course_name' => $data['course_name'],
				'speciality' => $data['speciality'],
				'institution' => $data['institution'],
                'exam_title' => $data['exam_title'],
                'materials' => $data['materials'],
                'answer_keys' => $data['answer_keys'],            
				'answer_weights' => $data['answer_weights'],
				'observations' => $data['observations'],
                'statusLesson' => $data['statusLesson'],
                'lesson_id' => $data['lesson_id'],
                'status' => $data['status'],
		));
        // save lesson to get ID
        $teacher->evaluations()->save($evaluation);    
		$evals = DB::table('profeplus_evaluations')
                        ->whereRaw('profeplus_evaluations.date > DATE_SUB(now(), INTERVAL 1 DAY)')
                        ->where('profeplus_evaluations.status',EvaluationController::ACTIVE)
                        ->where('profeplus_evaluations.user_id',$evaluation->user_id)
                        ->count();
		$details = array(
			'evalId' => $evaluation->id,
			'evaluations' => $evals,
		);
		return Response::json($details, JsonResponse::HTTP_CREATED);
        });
        return $response;
	}
    
    public function connectedStudents($eval_id,$lesson_id){
        $data = EvaluationStudent::where('evaluation_id',$eval_id)
                            ->where('lesson_id',$lesson_id)
                            ->where('status',EvaluationController::ACTIVE)
                            ->count();
        $num = Lesson::find($lesson_id)->inlesson;
        return Response::json(array('connected' => $num), JsonResponse::HTTP_OK);
    }
    
    public function teachersEvaluations($user_id){
        $evaluations = User::find($user_id)->evaluations()
                        //->whereRaw('profeplus_evaluations.date <= DATE_SUB(now(), INTERVAL 1 DAY)')
                        ->where('status',EvaluationController::ACTIVE)
                        ->get();
        $evaluations = DB::table('profeplus_evaluations')
						->join('profeplus_lessons', 'profeplus_evaluations.lesson_id', '=', 'profeplus_lessons.id')
                        ->select(DB::raw('profeplus_lessons.accesscode as code, profeplus_evaluations.id as id, profeplus_evaluations.course_name as course, profeplus_evaluations.lesson_id as lesson, profeplus_evaluations.speciality as speciality, profeplus_evaluations.institution as institution, profeplus_evaluations.exam_title as name'))                       
                        ->where('status',EvaluationController::ACTIVE)
                        ->where('statusLesson',EvaluationController::INACTIVE)
						->where('profeplus_evaluations.user_id',$user_id)
						->orderBy('id', 'desc')
                        ->get();
        return Response::json($evaluations, JsonResponse::HTTP_OK);
    }
    
    public function teachersActiveEvaluations($user_id){     
        $evaluations = DB::table('profeplus_evaluations')
						->join('profeplus_lessons', 'profeplus_evaluations.lesson_id', '=', 'profeplus_lessons.id')
                        ->select(DB::raw('profeplus_lessons.accesscode as code, profeplus_evaluations.id as id, profeplus_evaluations.course_name as course, profeplus_evaluations.lesson_id as lesson, profeplus_evaluations.speciality as speciality, profeplus_evaluations.institution as institution, profeplus_evaluations.exam_title as name'))                       
                        ->where('status',EvaluationController::ACTIVE)
                        ->where('statusLesson',EvaluationController::ACTIVE)
						->where('profeplus_evaluations.user_id',$user_id)
						->orderBy('id', 'desc')						
                        ->get();
        return Response::json($evaluations, JsonResponse::HTTP_OK);
    }
    
    public function deactivateLessonEvaluation($user_id, $lesson_id, $eval_id){
        $ev = Evaluation::find($eval_id); 
        $ev->status = EvaluationController::INACTIVE;
        $ev->statusLesson = EvaluationController::INACTIVE;
        $ev->save();
        $lesson = Lesson::find($lesson_id);
        $lesson->inactive = 1;
        $lesson->save();
		$evals = DB::table('profeplus_evaluations')
			->whereRaw('profeplus_evaluations.date > DATE_SUB(now(), INTERVAL 1 DAY)')
			->where('profeplus_evaluations.status',self::ACTIVE)
			->where('profeplus_evaluations.user_id',$user_id)
			->count();
        return Response::json(array('evals'=>$evals), JsonResponse::HTTP_OK);
    }
    
    public function deactivateEvaluation($user_id, $eval_id){
        $ev = Evaluation::find($eval_id); 
        $ev->status = EvaluationController::INACTIVE;
        $ev->statusLesson = EvaluationController::INACTIVE;
        $ev->save();
		$evals = DB::table('profeplus_evaluations')
			->whereRaw('profeplus_evaluations.date > DATE_SUB(now(), INTERVAL 1 DAY)')
			->where('profeplus_evaluations.status',self::ACTIVE)
			->where('profeplus_evaluations.user_id',$user_id)
			->count();
        return Response::json(array('evals'=>$evals), JsonResponse::HTTP_OK);
    }
    
    public function evaluationDetails($user_id, $eval_id) {  
        $eval = Evaluation::find($eval_id);
        if ( $eval != null ) {          
            $details = array(
                'id' => $eval->id,
                'speciality' => $eval->speciality,
                'institution' => $eval->institution,
                'course_name' => $eval->course_name,                          
            );      
            $response = Response::json($details, JsonResponse::HTTP_OK);                       
        } else {
            $response  = Response::json(array(), JsonResponse::HTTP_NOT_FOUND);
        }       
        return $response;
	}
    
    public function evaluationFullDetails($user_id, $eval_id) {  
        $eval = Evaluation::find($eval_id);
        if ( $eval != null ) {                       
            $response = Response::json($eval, JsonResponse::HTTP_OK);                       
        } else {
            $response  = Response::json(array(), JsonResponse::HTTP_NOT_FOUND);
        }       
        return $response;
	}
    
    public function evaluationUpdate($user_id, $eval_id) {  
        $eval = Evaluation::find($eval_id);
		$data = Input::json()->all();
		$duration = $data['duration'];
		if ( $duration == ""){
			$start = Carbon::createFromFormat('Y-m-d H:i:s', $data['start_time']);
			$end = Carbon::createFromFormat('Y-m-d H:i:s', $data['end_time']);
			$duration = $start->diffInMinutes($end); 
		} else {
			$duration = $data['duration'];
			$start = Carbon::now();
			$end = Carbon::now()->addMinutes($duration);
		}
        if ( $eval != null ) {
            $eval->number_question = $data['number_question'];
            $eval->overall_score = $data['overall_score'];
            $eval->duration = $duration;
            $eval->start_time = $start->toDateTimeString();
            $eval->end_time = $end->toDateTimeString();
            $eval->date = $data['date'];
            $eval->course_name = $data['course_name'];
            $eval->speciality = $data['speciality'];
            $eval->institution = $data['institution'];
            $eval->exam_title = $data['exam_title'];
            $eval->materials = $data['materials'];
            $eval->answer_keys = $data['answer_keys'];
            $eval->answer_weights = $data['answer_weights'];
            $eval->status = $data['status'];
			$eval->statusLesson = $data['statusLesson'];
			$eval->lesson_id = $data['lesson_id'];
            $eval->save();
			$evals = DB::table('profeplus_evaluations')
                        ->whereRaw('profeplus_evaluations.date > DATE_SUB(now(), INTERVAL 1 DAY)')
                        ->where('profeplus_evaluations.status',EvaluationController::ACTIVE)
                        ->where('profeplus_evaluations.user_id',$eval->user_id)
                        ->count();
			$details = array(
				'evalId' => $eval->id,
				'evaluations' => $evals,
			);
            $response = Response::json($details, JsonResponse::HTTP_OK);
        } else {
            $response  = Response::json(array(), JsonResponse::HTTP_NOT_FOUND);
        }       
        return $response;
	}
       	   
   public function autoMailEvaluation($user_id, $lesson_id, $eval_id){
        $ev = Evaluation::find($eval_id); 
        $ev->status = EvaluationController::INACTIVE;
        $ev->statusLesson = EvaluationController::INACTIVE;
        $ev->save();
        $lesson = Lesson::find($lesson_id);
        $lesson->inactive = 1;
        $lesson->save();
		$evals = DB::table('profeplus_evaluations')
			->whereRaw('profeplus_evaluations.date > DATE_SUB(now(), INTERVAL 1 DAY)')
			->where('profeplus_evaluations.status',self::ACTIVE)
			->where('profeplus_evaluations.user_id',$user_id)
			->count();
		$this->mailEvaluations($user_id,$eval_id);
        return Response::json(array('evals'=>$evals), JsonResponse::HTTP_OK);
    }
		
	public function mailEvaluations($user_id,$eval_id){
		$teacher = User::find($user_id); 
		$evalusers = array();
		$evals = DB::table('profeplus_evaluations')
					->where('profeplus_evaluations.user_id',$user_id)
					->where('profeplus_evaluations.eval_id',$eval_id)
					->get();
		foreach ($evals as $eval){
			
			$evaldata = DB::table('profeplus_student_evaluation')
                        ->select(DB::raw('profeplus_student_evaluation.score, profeplus_users.first_name, profeplus_users.last_name'))
                        ->join('profeplus_users', 'profeplus_users.id', '=', 'profeplus_student_evaluation.user_id')                  
                        ->where('profeplus_student_evaluation.evaluation_id',$eval->id)
                        ->get();
			$lessondata = DB::table('profeplus_lessons')
                        ->select(DB::raw('profeplus_lessons.inlesson'))                                      
                        ->where('profeplus_lessons.evaluation_id',$eval->id)
                        ->first();
			$evalusers[] = array (
					'data' => $eval,
					'users' => $evaldata,
					'lessons' => $lessondata
					); 	 			
		}
              
        $data = array(
            'evals' => $evalusers,
			'teacher' => $teacher,
        ); 
		Mail::send('emails.eval-es', $data, 
        function($message) use ($teacher) {
            $message->to($teacher->email, $teacher->first_name.' '.$teacher->last_name)->subject('Evaluación ProfePlus');
        });		
	}
    
   	
}

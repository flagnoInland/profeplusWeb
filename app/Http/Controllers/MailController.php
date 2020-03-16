<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Validator, Input, Redirect, Response, DB, Mail; 
use Carbon\Carbon;
use App\User;
use App\Lesson;
use App\Evaluation;
use App\QuestionType;
use App\Survey;

class MailController extends Controller {
    
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
    
    
    public function mailResults($user_id){  
        
        $teacher = User::find($user_id); 
        $surveys = Survey::all();        
        $questions = QuestionType::all();
		$rdata = array();
		$lids = DB::table('profeplus_lessons')->select(DB::raw('profeplus_lessons.id'))
				->whereRaw('updated_at > DATE_SUB(now(), INTERVAL 1 DAY)')
				->where('profeplus_lessons.user_id',$user_id)
				//->whereRaw('inlesson > 0')
				->get();
		foreach ($lids as $lid){
			$lusers = DB::table('profeplus_lessonsusers')
						->select(DB::raw('profeplus_users.institution_name, profeplus_users.speciality, profeplus_users.studentid, profeplus_users.first_name, profeplus_users.last_name, profeplus_lessonsusers.user_id,
						profeplus_lessonsusers.answer, profeplus_lessonsusers.owner, 
						owner.first_name as owner_name, owner.last_name as owner_surname'))
						->leftJoin('profeplus_users', 'profeplus_users.id', '=', 'profeplus_lessonsusers.user_id')    
						->leftJoin('profeplus_users as owner', 'owner.id', '=', 'profeplus_lessonsusers.owner') 
                        ->where('profeplus_lessonsusers.lesson_id',$lid)
                        ->get();
			$ldata = DB::table('profeplus_lessons')
                        ->select(DB::raw('profeplus_lessons.*, profeplus_survey.name_es as surv, profeplus_questiontypes.name_es as qt, profeplus_survey.opt1_name_es, profeplus_survey.opt2_name_es, profeplus_survey.opt3_name_es, profeplus_survey.opt4_name_es, profeplus_survey.opt5_name_es'))
                        ->join('profeplus_survey', 'profeplus_lessons.survey', '=', 'profeplus_survey.id')
                        ->join('profeplus_questiontypes', 'profeplus_lessons.question_type', '=', 'profeplus_questiontypes.id')
                        ->where('profeplus_lessons.id',$lid)
                        ->first();
			$rdata[] = array (
				'data' => $ldata,
				'users' => $lusers,
			); 	 
		}
        $data = array(
            'teacher' => $teacher,
            'lessons' => $rdata,
            'questions' => $questions,
            'surveys' => $surveys,
        );
		return Response::json($lids, JsonResponse::HTTP_CREATED);        
		Mail::send('emails.report-es', $data, 
        function($message) use ($teacher) {
            $message->to($teacher->email, $teacher->first_name.' '.$teacher->last_name)->subject('Report ProfePLUS');
        });
        
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
    
    
	
	public function mailAllEvaluations($user_id,$eval_id){
		$teacher = User::find($user_id); 
		$evalusers = array();
		$evals = DB::table('profeplus_evaluations')
					->whereRaw('profeplus_evaluations.date > DATE_SUB(now(), INTERVAL 1 DAY)')			
					->where('profeplus_evaluations.user_id',$user_id)
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
            $message->to($teacher->email, $teacher->first_name.' '.$teacher->last_name)->subject('Evaluación ProfePLUS');
        });		
	}
    
	
    public function testMail($user_id){     
        $teacher = User::find($user_id); 
        $surveys = Survey::all();        
        $questions = QuestionType::all();
        $lessons = DB::table('profeplus_lessons')
                        ->select(DB::raw('profeplus_lessons.*, profeplus_survey.name_es as surv, profeplus_questiontypes.name_es as qt, profeplus_survey.opt1_name_es, profeplus_survey.opt2_name_es, profeplus_survey.opt3_name_es, profeplus_survey.opt4_name_es, profeplus_survey.opt5_name_es'))
                        ->join('profeplus_survey', 'profeplus_lessons.survey', '=', 'profeplus_survey.id')
                        ->join('profeplus_questiontypes', 'profeplus_lessons.question_type', '=', 'profeplus_questiontypes.id')
                        ->whereRaw('updated_at > DATE_SUB(now(), INTERVAL 1 DAY)')
						->whereRaw('inlesson > 0')
                        ->where('profeplus_lessons.user_id',$user_id)
                        ->get();
       
        $data = array(
            'teacher' => $teacher,
            'lessons' => $lessons,
            'questions' => $questions,
            'surveys' => $surveys,
        );               
        return View::make('emails.report-es', $data);
        //return Response::json($data, JsonResponse::HTTP_OK);
        
    }
	
	public function testEval($user_id){     
        $teacher = User::find($user_id); 
		$evalusers = array();
		$evals = DB::table('profeplus_evaluations')
					->whereRaw('profeplus_evaluations.date > DATE_SUB(now(), INTERVAL 1 DAY)')			
					->where('profeplus_evaluations.user_id',$user_id)
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
        return View::make('emails.eval-es', $data);
        //return Response::json($data, JsonResponse::HTTP_OK);
        
    }
	
	public function makeReport($userid, $lessonid){
		// Send Email
		$teacher = User::find($userid); 
        $surveys = Survey::all();        
        $questions = QuestionType::all();
		/*
        $lessons = DB::table('profeplus_lessons')
                        ->select(DB::raw('profeplus_lessons.*, profeplus_survey.name_es as surv, profeplus_questiontypes.name_es as qt, profeplus_survey.opt1_name_es, profeplus_survey.opt2_name_es, profeplus_survey.opt3_name_es, profeplus_survey.opt4_name_es, profeplus_survey.opt5_name_es'))
                        ->join('profeplus_survey', 'profeplus_lessons.survey', '=', 'profeplus_survey.id')
                        ->join('profeplus_questiontypes', 'profeplus_lessons.question_type', '=', 'profeplus_questiontypes.id')
                        ->where('profeplus_lessons.id',$lessonid)
                        ->where('profeplus_lessons.user_id',$userid)
						//->whereRaw('inlesson > 0')
                        ->get();
						*/
		$rdata = array();
		$lids = array($lessonid);
		foreach ($lids as $lid){
			$lusers = DB::table('profeplus_lessonsusers')
						->select(DB::raw('profeplus_users.institution_name, profeplus_users.speciality, profeplus_users.studentid, profeplus_users.first_name, profeplus_users.last_name, profeplus_lessonsusers.user_id,
						profeplus_lessonsusers.answer, profeplus_lessonsusers.owner, 
						owner.first_name as owner_name, owner.last_name as owner_surname'))
						//->join('profeplus_users', 'profeplus_users.id', '=', 'profeplus_lessonsusers.user_id')
						->leftJoin('profeplus_users', 'profeplus_users.id', '=', 'profeplus_lessonsusers.user_id')    
						->leftJoin('profeplus_users as owner', 'owner.id', '=', 'profeplus_lessonsusers.owner') 						
                        ->where('profeplus_lessonsusers.lesson_id',$lid)
                        ->get();
			$ldata = DB::table('profeplus_lessons')
                        ->select(DB::raw('profeplus_lessons.*, profeplus_survey.name_es as surv, profeplus_questiontypes.name_es as qt, profeplus_survey.opt1_name_es, profeplus_survey.opt2_name_es, profeplus_survey.opt3_name_es, profeplus_survey.opt4_name_es, profeplus_survey.opt5_name_es'))
                        ->join('profeplus_survey', 'profeplus_lessons.survey', '=', 'profeplus_survey.id')
                        ->join('profeplus_questiontypes', 'profeplus_lessons.question_type', '=', 'profeplus_questiontypes.id')
                        ->where('profeplus_lessons.id',$lid)
                        ->first();
			$rdata[] = array (
				'data' => $ldata,
				'users' => $lusers,
			); 	 
		}				       
        $data = array(
            'teacher' => $teacher,
            'lessons' => $rdata,
            'questions' => $questions,
            'surveys' => $surveys,
        );            
		Mail::send('emails.report-es', $data, 
        function($message) use ($teacher) {
            $message->to($teacher->email, $teacher->first_name.' '.$teacher->last_name)->subject('Informe ProfePlus');
        });
		return Response::json(array(), JsonResponse::HTTP_OK);
	}

    
}

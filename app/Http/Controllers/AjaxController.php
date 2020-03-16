<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Validator, Request, Input, Redirect, Response, DB, Hash, Mail;
use Carbon\Carbon;
use App\User;
use App\Lesson;
use App\Survey;
use App\QuestionType;

class AjaxController extends BaseController {
    
    
    const S_NONE = 1;
    const S_SATISFACTION = 2;
    const S_AGREEMENT = 3;
    const S_QUALIFICATION = 4;
    const S_SPEAKER = 5;

    const Q_NORMAL = 1;
    const Q_FREE = 2;
    const Q_TRUE = 3;
    const Q_SURVEY = 4;

    const M_INDIVIDUAL = 1;
    const M_PEER = 2;

    const TEACHER = 1; 
    const STUDENT = 0;

    const MOD_SCHOOL = 2;
    const MOD_UNI = 1;

    public $log;

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
     
    public function __construct() {
       //$this->log = new Logger('my_logger');    
       //$this->log->pushHandler(new StreamHandler(storage_path().'/logs/custom.log', Logger::INFO));
    }
	
	public function recover(){
		$response = DB::connection()->transaction(function() {
			$data = Input::json()->all();
			$email = $data['email'];
			//$nationid = $data['nationid'];
			$postedDate = $data['birthdate'];
			$postedDate = str_replace('-', '/', $postedDate);
			$postedDate = str_replace('/ ', '/', $postedDate);
			$postedDate = str_replace(' /', '/', $postedDate);
			$postedDate = str_replace(' ', '/', $postedDate);
			try {
				$birthdate = Carbon::createFromFormat('d/m/Y', $postedDate)->toDateString();
			} catch (InvalidArgumentException $e ){ 
				$birthdate = "1990-06-15";
			}
			//Log::info($birthdate);
			$yourpass = $data['password'];
			//$user = User::where('email', $email)->where('birthdate',$birthdate)->first();
			$user = User::where('email', $email)->first();
			//$yourpass = $this->generateRandomString(6);
			if( $user == null){
				return Response::json(new \stdClass(), JsonResponse::HTTP_BAD_REQUEST);
			} else {
				$user->password = Hash::make($yourpass);
				$user->save();
				return Response::json(new \stdClass(),JsonResponse::HTTP_OK);
			}
		});
        return $response;
	}
    
	public function authenticate() {
        $email = Input::get('email');
        $yourpass = Input::get('password');
		$user = User::where('email',$email)->first();
		$data = array(
			'email'=>$email,
		);
		//Log::info('email --> '.$email);
		//error_log('email --> '.$email);
		//error_log('user --> '.$user);
		//error_log('pass 1 --> '.$user->password);
		//error_log('pass 2 --> '.Hash::make($yourpass));
		//error_log('pass 3 --> '.bcrypt($yourpass));
		if ($user != null){
			//if (Hash::check($yourpass, $user->password)) {
			if (true) {
				//error_log($user->appmode);
				#$response = Response::json(array('user_id'=>$user->id), JsonResponse::HTTP_OK);
				return Redirect::to('web/board/'.$user->id.'/'.$user->appmode.'/0000/'.$user->teacher);
			} else {
				//error_log('sorry! you are not registered');
				return $response = Response::json($data, JsonResponse::HTTP_NO_CONTENT);
				#return $response = Response::json($data, JsonResponse::HTTP_NOT_FOUND);
			}
		} else {
			return $response = Response::json($data, JsonResponse::HTTP_NO_CONTENT);
		}
			
	}
	
	public function guestLogin() {
        $email = Input::get('email');
        //$yourpass = Input::get('password');
		$user = User::where('email', $email)->first();
		//if (Hash::check($yourpass, $user->password)) {
		if ($user != null) {
			$data = array(
				'user_id'=>$user->id,
			);
			return $response = Response::json($data, JsonResponse::HTTP_OK);
		} else {
			//Log::info($email);
			return $response = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
		}
	}
	
	public function guestSchoolLogin() {
        $email = Input::get('email');
        //$yourpass = Input::get('password');
		$user = User::where('email',$email)->first();
		$data = array(
			'user_id'=>$user->id,
		);
		if ($user!=null) {
			return $response = Response::json($data, JsonResponse::HTTP_OK);
		} else {
			return $response = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
		}
	}
	
	public function register($mode, $type){
		//$data = Input::all();
		$response = DB::connection()->transaction(function() use ($mode, $type){
			if (Request::ajax()){
				$data = Input::all();
				$birth = '';
				if ($data['birthdate'] != null){
					$postedDate = $data['birthdate'];
					$postedDate = str_replace('-', '/', $postedDate);
					$postedDate = str_replace('/ ', '/', $postedDate);
					$postedDate = str_replace(' /', '/', $postedDate);
					$postedDate = str_replace(' ', '/', $postedDate);
					try {
						$birth = Carbon::createFromFormat('d/m/Y', $postedDate)->toDateString();
					} catch (InvalidArgumentException $e ){ 
						$birth = "1990-06-15";
					}
				}
				try {
					if ($data['studentid'] == ""){
						$data['studentid'] = "0000";
					}
					if ($data['speciality'] == ""){
						$data['speciality'] = "no definido";
					}
					if ($data['institution_name'] == ""){
						$data['institution_name'] = "no definido";
					}
					if ($data['phone'] == ""){
						$data['phone'] = "123456";
					}
					if ($data['nationid'] == ""){
						$data['nationid'] = "0";
					}
					$user = User::create(array(			
						'last_name' => $data['last_name'],
						'first_name' => $data['first_name'],
						'email' => $data['email'],
						'password' => Hash::make($data['password']),
						'nationid' => $data['nationid'],
						'gender' => $data['gender'],
						'birthdate' => $birth,
						'country' => $data['country'],
						'city' => $data['city'],
						'phone' => $data['phone'],
						'studentid' =>  $data['studentid'],
						'speciality' => $data['speciality'],
						'institution_name' => $data['institution_name'],
						'teacher' => $type,
						'appmode' => $mode,				
					));
					return Response::json(array("user_id"=>$user->id), JsonResponse::HTTP_CREATED);
				} catch (QueryException $e ){
					Log::error($e->getMessage());
					//error_log($e->getMessage());
					return Response::json(new \stdClass(), JsonResponse::HTTP_BAD_REQUEST);
				}
				
			} else {
				return Response::json(array(), JsonResponse::HTTP_METHOD_NOT_ALLOWED);
			}
		});
		return $response;
	}
	
	public function updateMode($user, $mode, $type) {
		$account = User::find($user);
		$account->appmode = $mode;
		$account->teacher = $type;
		$account->save();
		return Redirect::to('web/board/'.$account->id.'/'.$account->appmode.'/0000/'.$account->teacher);
	}
	
	public function update($user, $mode, $type){
		$account = User::find($user);
		if (Request::ajax()){
			$data = Input::all();
			$account->last_name = $data['last_name'];
			$account->first_name = $data['first_name'];
			$account->nationid = $data['nationid'];
			$account->gender = $data['gender'];
			$account->birthdate = Carbon::createFromFormat('d/m/Y', $data['birthdate']);
			$account->country = $data['country'];
			$account->city = $data['city'];
			$account->phone = $data['phone'];
			$account->studentid =  $data['studentid'];
			$account->speciality = $data['speciality'];
			$account->institution_name = $data['institution_name'];
			$account->save();
			return Response::json(new \stdClass(), JsonResponse::HTTP_CREATED);
		} else {
			return Response::json(new \stdClass(), JsonResponse::HTTP_METHOD_NOT_ALLOWED);
		}
	}
	
	public function disableOldLessons($userid){
		$ulessons = Lesson::where('user_id',$userid)->where('status',0)->get();
		foreach ($ulessons as $ulesson) {        
			$ulesson->status = Lesson::DISABLED;		
			$ulesson->save();
		}
		return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
	}
	
	public function updateLesson($id) {
        $response = DB::connection()->transaction(function() use($id) {
		$data = Input::json()->all();
		$lesson = Lesson::find($id);
		$lesson->run = $data['run'];		
		$lesson->status = Lesson::ENABLED;
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
	
	public function checkLesson($id){
		$lesson = Lesson::find($id);
		return Response::json(array('inactive'=>$lesson->status), JsonResponse::HTTP_OK);
	}
	
	public function getReportData($lessonid){
		$lesson = Lesson::find($lessonid);
		$details = array(
			'level'=>$lesson->level,
			'grade'=>$lesson->grade,
			'observation'=>$lesson->observations,
			'classroom'=>$lesson->classroom,
			'institution'=>$lesson->institution,
			'speciality'=>$lesson->speciality,
			'course'=>$lesson->course_name,
			'keys'=>$lesson->answer_keys,
		);
		return Response::json($details, JsonResponse::HTTP_OK);
	}
	
	public function shareReportData($lessonid, $previous){
		$lesson0 = Lesson::find($previous);
		$lesson = Lesson::find($lessonid);
		$lesson->level = $lesson0->level;
        $lesson->grade = $lesson0->grade;
        $lesson->observations = $lesson0->observations;
        $lesson->classroom = $lesson0->classroom;
        $lesson->institution = $lesson0->institution;
        $lesson->speciality = $lesson0->speciality;
        $lesson->course_name = $lesson0->course_name;
		$lesson->answer_keys = $lesson0->answer_keys;
		$lesson->save();
		return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
	}
	
	
	
	public function updateAnswerLesson($lessonid){
		// Update lesson
		$data = Input::json()->all();
		$lesson = Lesson::find($lessonid);
        $lesson->answer_keys = $data['answer_keys'];
		$lesson->save();
		return Response::json(array(), JsonResponse::HTTP_OK);
	}
	
	
	public function updateReportLesson($lessonid){
		// Update lesson
		$data = Input::json()->all();
		$lesson = Lesson::find($lessonid);
        $lesson->level = $data['level'];
        $lesson->grade = $data['grade'];
        $lesson->observations = $data['observation'];
        $lesson->classroom = $data['classroom'];
        $lesson->institution = $data['institution'];
        $lesson->speciality = $data['speciality'];
        $lesson->course_name = $data['course_name'];
		$lesson->save();
		return Response::json(array(), JsonResponse::HTTP_OK);
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
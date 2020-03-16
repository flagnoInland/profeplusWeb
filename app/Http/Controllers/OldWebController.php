<?php

use Illuminate\Http\JsonResponse;
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;
use AuthenticateController as AC;
use RegisterUserController as RUC;
use CourseController as CC;
use LessonController as LC;
use LessonUserController as LUC;

class WebController extends BaseController {
    
    
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

    const SCHOOL_TEACHER = 1;
    const UNI_TEACHER = 2;
    const SCHOOL_STUDENT = 3;
    const UNI_STUDENT = 4;

    const A_SIGNUP = 1;
    const A_TEACHER = 2;
    const A_STUDENT = 3;
    const A_QUESTION = 4;
    const A_SESSION = 5;
    const A_RESULT = 6;
    
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
    
	public function authenticate() {
        $email = Input::get('email');
        $password = Input::get('password');       
        $ac = AC::getInstance();
        $response = $ac->authenticate2();
        $content = json_decode($response->getContent());
        $statusCode = $response->getStatusCode();
        if ($statusCode == 403){
            //return View::make('error', array('details' => $content));   
            return Redirect::to('/');
        } else {$id = $content->user_id;
            if ($content->teacher==1){
                $id = $content->user_id;
                //$courses = User::find($id)->courses()->orderBy('id','desc')->get();
                //$response = Response::view('course-list', array('courses' => $courses, 'id' => $id));
                $response = Response::view('session-list', array('id'=>$id));
            } else {             
                $response = Response::view('student-board', array('user_id'=>$id));
            }
            return $response->withCookie(Cookie::make('Amautic', array($content->token),360));
        }       		
	}
    
    public function signUp($opt) {
        return View::make('signup', array('teacher' => $opt)); 		
	}
    
    public function chooseUser() {
        return View::make('choose-user', array()); 		
	}
    
    
    public function signUpAction() {
        $data = array(			
				'last_name' => Input::get('last_name'),
				'first_name' => Input::get('first_name'),
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'nationid' => Input::get('nationid'),
				'birthdate' => Input::get('birthdate'),
				'country' => Input::get('country'),
				'city' => Input::get('city'),
				'phone' => Input::get('phone'),
				'studentid' =>  Input::get('studentid'),
				'teacher' =>  Input::get('teacher'),
		);
        Request::instance()->headers->set('Content-type', 'application/json');
        Request::instance()->merge($data);
        $ruc = new RUC();
        $response = $ruc->store();
        $content = json_decode($response->getContent());
        if ($content->token != null){
            if ( $data['teacher'] == 1 ){
                $response = Response::view('course-list', array('courses' => null));
                return $response;    	
            }
        }       
	}
    
    public function editUser($id) {
        $user = User::find($id);
        $data = array(
                'user_id' => $id,        
				'last_name' => $user->last_name,
				'first_name' => $user->first_name,		
				'nationid' => $user->nationid,
				'birthdate' => $user->birthdate,
				'country' => $user->country,
				'city' => $user->city,
				'phone' => $user->phone,
				'studentid' =>  $user->studentid,
				'teacher' =>  $user->teacher,
		);
        
        return View::make('profile', $data); 		
	}
    
    public function editUserAction($id) {
        $token = Cookie::get('Amautic')[0];
        $data = array(			
				'last_name' => Input::get('last_name'),
				'first_name' => Input::get('first_name'),
				'nationid' => Input::get('nationid'),
				'birthdate' => Input::get('birthdate'),
				'country' => Input::get('country'),
				'city' => Input::get('city'),
				'phone' => Input::get('phone'),
				'studentid' =>  Input::get('studentid'),
				'teacher' =>  Input::get('teacher'),
		);
        Request::instance()->headers->set('Content-type', 'application/json');
        Request::instance()->merge(array('auth_token' => $token));
        Request::instance()->merge($data);
        $ruc = new RUC();
        $ruc->update($id);
        if ( $data['teacher'] == 1 ){
            $courses = User::find($id)->courses()->orderBy('id','desc')->get();
            $response = Response::view('course-list', array('courses' => $courses, 'user_id' => $id));    
        } else {
            $response = Response::view('student-board', array('user_id'=>$id));            
        }  
        return $response;    	
	}
    
    
    public function recover() {
        return View::make('recover', array()); 		
	}
    
    
    public function recoverAction() {
        $email = Input::get('email');
        $nationid = Input::get('nationid');
        $birthdate = Input::get('birthdate');
        $yourpass = Input::get('password');
        $ruc = new RUC();
        $response = $ruc->recover($email,$nationid,$birthdate,$yourpass);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 201){
            $response = Response::view('login');
            return $response; 
        }       
	}
    
    public function userBoard($user_id){
        $user = User::find($user_id);
        if ($user->teacher == 1) {
            $courses = User::find($user_id)->courses()->orderBy('id','desc')->get();
            return Response::view('course-list', array('courses' => $courses, 'user_id' => $user_id));
        } else {
            return Response::view('student-board', array('user_id'=>$user_id));
        }
    }
    
    public function studentTask($id, $previous) {
        $code = Input::get('code');
        $lesson = Lesson::where( 'accesscode', $code)->where(function ($query) {$query->where('inactive', '=', 0);})->first();
        if ( !is_null($lesson) ) {
            $token = Cookie::get('Amautic')[0];
            $user = AuthToken::validate($token);
            $name = $user->first_name.' '.$user->last_name;
            Request::instance()->merge(array('auth_token' => $token));
            $lc = new LC();
            $response = $lc->super_getid($code, $id, $previous);
            //$statusCode = $response->getStatusCode();
            $content = json_decode($response->getContent());
            $lesson = Lesson::find($content->id);
            $survey = $lesson->survey;
            $details = array(
                    'user' => $user->id,
                    'code' => $code,
                    'name' => $name,
                    'id' => $lesson->id,
                    'run' => $lesson->run,
                    'exercise' => $lesson->exercise,
                    'subject' => $lesson->subject,
                    'previous' => $content->last_answer,
                    'label1' => Survey::find($survey)->opt1_name_en,
                    'label2' => Survey::find($survey)->opt2_name_en,
                    'label3' => Survey::find($survey)->opt3_name_en,
                    'label4' => Survey::find($survey)->opt4_name_en,
                    'label5' => Survey::find($survey)->opt5_name_en,
                    'label6' => 'True',
                    'label7' => 'False',
                    'label8' => "Don't know",
            ); 
            $details2 = array(
                    'user' => $user->id,
                    'code' => $code,
                    'name' => $name,
                    'id' => $lesson->id,
                    'run' => $lesson->run,
                    'exercise' => $lesson->exercise,
                    'subject' => $lesson->subject,
                    'previous' => $content->last_answer,
                    'label1' => "A",
                    'label2' => "B",
                    'label3' => "C",
                    'label4' => "D",
                    'label5' => "E",
                    'label6' => 'True',
                    'label7' => 'False',
                    'label8' => "Don't know",
            ); 
            $type = $content->question_type;
            if ($type == self::Q_TRUE){
                $response = Response::view('student-square-2', $details);
            } else if ($type == self::Q_SURVEY){
                $response = Response::view('student-square', $details);
            } else {
                $response = Response::view('student-round', $details2);
            }
        } else {
            $response = Response::view('student-board', array('user_id'=>$id));
        }
        return $response; 
	}
   
    public function refreshQuestion($id, $code, $previous){
        $lesson = Lesson::where( 'accesscode', $code)->where(function ($query) {$query->where('inactive', '=', 0);})->first();
        //$this->log->addInfo('Controller refreshQuestion: '.$lesson);
        $token = Cookie::get('Amautic')[0];
        $user = AuthToken::validate($token);     
        $user_id = $user->id;
        if (! is_null($lesson)){
            if ($lesson->id != $id) {
                return Redirect::route('student-task', array('previous' => 'Z', 'id' => $user_id, 'code'=>$code));
            } else {             
                //$this->log->addInfo('Controller refreshQuestion: '.$token);
                //Request::instance()->merge(array('auth_token' => $token));
                return Redirect::route('student-task', array('previous' => $previous, 'id' => $user_id, 'code'=>$code));
            }
        } 
    }
   
    public function answerQuestion($id,$code,$answer) {
        //$code = Input::get('code');
        //$this->log->addInfo('Controller answerQuestion: '.$code.' '.$id.' '.$answer);
        $token = Cookie::get('Amautic')[0];
        $user = AuthToken::validate($token);
        $lesson = Lesson::find($id);
        //$this->log->addInfo('Controller user: '.$token);        
        $user_id = $user->id;
        Request::instance()->merge(array('auth_token' => $token));
        $lc = new LC();
        $response = $lc->super_answer($id, $user_id, $lesson->run, $answer);
        //$statusCode = $response->getStatusCode();
        //$content = json_decode($response->getContent());
        return Redirect::route('student-task', array('previous' => $answer, 'id' => $user_id, 'code'=>$code));           
	}
  
    public function courseList() {
        $token = Cookie::get('Amautic')[0];
        $user = AuthToken::validate($token);
        $id = $user->id;
        $courses = User::find($user['id'])->courses()->orderBy('id','desc')->get();
        $response = Response::view('course-list', array('courses' => $courses, 'user_id' =>$id));
        return $response;     	
    }
    
    public function newCourse($user) {
        $token = Cookie::get('Amautic');
        $details = array(
                'user_id' => $user,
                'id' => 0,
                'edit' => false,
				'name' => Input::old('name'),
				'courseid' => Input::old('courseid'),
				'institution' => "PUCP",
				'countryid' => "Perú",
				'speciality' => Input::old('speciality'),
				'term' => Input::old('term'),
				'timeload' => Input::old('timeload'),
				'students' => Input::old('students'),
                'countries' => Country::all(),
                'universities' => University::all(),
		);
        $response = Response::view('course', $details);
        return $response; 		
	}
    
    public function editCourse($user, $id) {
        $token = Cookie::get('Amautic');
        $course = Course::find($id);
        $details = array(
                'user_id' => $user,
                'course_id' => $id,
                'edit' => true,
				'name' => $course->name,
				'courseid' => $course->courseid,
				'institution' => $course->institution,
				'countryid' => $course->country,
				'speciality' => $course->speciality,
				'term' => $course->term,
				'timeload' => $course->timeload,
				'students' => $course->students,
                'countries' => Country::all(),
                'universities' => University::all(),
		);
        $response = Response::view('course', $details);
        return $response; 		
	}
    
    public function newCourseAction() {
        $token = Cookie::get('Amautic')[0];
        $label = Input::get('name').' - '.Input::get('institution');
        $data = array(			
				'name' => Input::get('name'),
				'courseid' => Input::get('courseid'),
				'institution' => Input::get('institution'),
				'country' => Input::get('country'),
				'speciality' => Input::get('speciality'),
				'term' => Input::get('term'),
				'timeload' => Input::get('timeload'),
				'students' => Input::get('students'),
                'label' => $label,
		);                    
        Request::instance()->headers->set('Content-type', 'application/json');
        Request::instance()->merge(array('auth_token' => $token));
        Request::instance()->merge($data);            
        $cc = new CC();
        $response = $cc->store();
        $statusCode = $response->getStatusCode();
        $user = AuthToken::validate($token);
        if ($statusCode == 201){
            $id = $user->id;
            $courses = User::find($user['id'])->courses()->orderBy('id','desc')->get();
            $response = Response::view('course-list', array('courses' => $courses));
            return $response;
        }    
               
	}
    
    public function editCourseAction($id) {
        $token = Cookie::get('Amautic')[0];
        $label = Input::get('name').' - '.Input::get('institution');
        /*
        $course = Course::find($id);
        $course->name = Input::get('name');
        $course->courseid = Input::get('courseid');
        $course->institution = Input::get('institution'),
        $course->country = Input::get('country'),
        $course->speciality = Input::get('speciality'),
        $course->term = Input::get('term'),
        $course->timeload = Input::get('timeload'),
        $course->students = Input::get('students'),
        $course->label = $label;
        */
        $data = array(			
				'name' => Input::get('name'),
				'courseid' => Input::get('courseid'),
				'institution' => Input::get('institution'),
				'country' => Input::get('country'),
				'speciality' => Input::get('speciality'),
				'term' => Input::get('term'),
				'timeload' => Input::get('timeload'),
				'students' => Input::get('students'),
                'label' => $label,
		);          
        Request::instance()->headers->set('Content-type', 'application/json');
        Request::instance()->merge(array('auth_token' => $token));
        Request::instance()->merge($data);            
        $cc = new CC();
        $response = $cc->update($id);
        $statusCode = $response->getStatusCode();
        $user = AuthToken::validate($token);
        if ($statusCode == 201){
            $id = $user->id;
            $courses = User::find($user['id'])->courses()->orderBy('id','desc')->get();
            $response = Response::view('course-list', array('courses' => $courses));
            return $response;
        }                   
	}
    
    public function schedule() {
        $response = Response::view('schedule', array('timeloads' => null));
        return $response; 		
	}
    
    public function newTimeloadAction() {
        	
	}
    
    public function newLesson($user,$id) {      
        //return View::make('question-list-1', $details); 		
        return Redirect::route('question-list', array('user_id' => $user, 'course_id' => $id));
	}
    
    public function questionList($user,$id) {
        $details = array(
            'courseid' => $id,
            'user_id' => $user,
        );
        if ($id==-1){
            return View::make('question-list-1', $details); 
        } else {
            return View::make('question-list-2', $details); 
        }
	}
    
    public function createLesson($user,$id,$questiontype,$survey) {
        $token = Cookie::get('Amautic')[0];
        $data = array(			
				'course_id' => $id,
				'accesscode' => 0,
				'subject' => 0,
				'exercise' => 0,
				'ans1' => 0,
				'ans2' => 0,
				'ans3' => 0,
				'ans4' => 0,
				'ans5' => 0,
                'ans_yes' => 0,
                'ans_no' => 0,
                'ans_na' => 0,            
				'ansnn' => 0,
				'inlesson' => 0,
				'inactive' => 0,
                'run' => 1,
                'survey' => $survey,
                'question_type' => $questiontype,
                'question_mode' => self::M_INDIVIDUAL,
		);                    
        if( $questiontype==self::Q_SURVEY && $survey==1 ){
            return Redirect::route('question-survey', array('user' => $user, 'id' => $id, 'questiontype' => $questiontype));
        } else { 
            Request::instance()->headers->set('Content-type', 'application/json');
            Request::instance()->merge(array('auth_token' => $token));
            Request::instance()->merge($data);            
            $lc = new LC();
            $response = $lc->super_store();
            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getContent());
            if ($statusCode==201){
                return Redirect::route('code-screen', array('id' => $content->id));
            } else {
                return View::make('error', array('details' => $content));   
            }
        }	
	}
    
    public function surveyList($user,$id,$questiontype) {
        $details = array(
            'courseid' => $id,
            'user_id' => $user,
        );
        return View::make('survey-list', $details); 		
	}

    public function codeScreen($id) {
        $lesson = Lesson::find($id);
        if ($lesson->course_id == -1){
            $coursename = "Free";
            $term = "None";
            $timecode = "None";
        } else {
            $course = Course::find($lesson->course_id);
            $coursename = $course->name;
            $term = $course->term;
            $timecode = $course->timeload;
        }
        $details = array(
                'id' => $id,
                'accesscode' => $lesson->accesscode,
                'course' => $coursename,
                'term' => $term,
                'timecode' => $timecode,
            );
        return View::make('code-screen', $details); 		
	}
    
    
    public function disableSession($id){
        $lesson = Lesson::find($id);        
        $run = $lesson->run;
        if ($lesson->inactive == 0){
            $lesson->inactive = 1;
            $lesson->accesscode = $lesson->accesscode.'R';
            $lesson->save();
        }
        $token = Cookie::get('Amautic')[0];
        $user = AuthToken::validate($token);
        $user_id = $user->id;
        $courses = User::find($user['id'])->courses()->orderBy('id','desc')->get();
        $response = Response::view('course-list', array('courses' => $courses, 'user_id' =>$user_id));
        return $response;  
    }
    
    
    public function results($id,$subject,$exercise) {
        $lesson = Lesson::find($id);
        if($lesson->question_type==self::Q_NORMAL && $exercise==0 && $subject==0){
            $response = Response::view('new-exercise', array('id' => $id));
        } else {
            $response = Redirect::route('results', array('id'=>$id,'code'=>$lesson->accesscode));   
        }
        return $response;      
	}
    
    public function newExercise($id) {
        $response = Response::view('new-exercise', array('id' => $id));
        return $response; 		
	}
    
    public function newExerciseAction($id) {
        $lesson = Lesson::find($id);
        $token = Cookie::get('Amautic')[0];
        $data = array(			
				'course_id' => $lesson->course_id,
				'accesscode' => $lesson->accesscode,
				'subject' => Input::get('subject'),
				'exercise' => Input::get('exercise'),		
				'inactive' => 0,
                'run' => 1,
		);
        Request::instance()->headers->set('Content-type', 'application/json');
        Request::instance()->merge(array('auth_token' => $token));
        Request::instance()->merge($data);            
        $lc = new LC();
        $response = $lc->update($id);
        $statusCode = $response->getStatusCode();
        if ($statusCode==200){
            return Redirect::route('results', array('id' => $id,'code'=>$lesson->accesscode));   
        }       
	}
    
    public function endRun($id,$code) {
        $lesson = Lesson::find($id);        
        $run = $lesson->run;
        $lesson->inactive = 1;
        $lesson->accesscode = $code.'R';
        $lesson->save();
        $response = Redirect::route('results', array('id'=>$id,'code'=>$code));        
        if ( $run == 1 ){
            //$response = Response::view('results-2', array('id'=>$id));
            //$response = Response::route('results', array('id'=>$id));
        } else {
            //$response = Response::view('results-4', array('id'=>$id, 'run'=>$run+1));
            //$response = Response::route('results', array('id'=>$id));
        }
        return $response; 		
	}
    
    public function startRun($id,$code) {
        $token = Cookie::get('Amautic')[0];
        $lesson = Lesson::find($id); 
        $run = $lesson->run;
        $data = array(			
				'course_id' => $lesson->course_id,
				'accesscode' => $code,
				'subject' => $lesson->subject,
				'exercise' => $lesson->exercise,
				'ans1' => 0,
				'ans2' => 0,
				'ans3' => 0,
				'ans4' => 0,
				'ans5' => 0,
                'ans_yes' => 0,
                'ans_no' => 0,
                'ans_na' => 0,            
				'ansnn' => 0,
				'inlesson' => 0,
				'inactive' => 0,
                'run' => $run+1,
                'survey' => $lesson->survey,
                'question_type' => $lesson->question_type,
                'question_mode' => self::M_INDIVIDUAL,
		);
        Request::instance()->headers->set('Content-type', 'application/json');
        Request::instance()->merge(array('auth_token' => $token));
        Request::instance()->merge($data);            
        $lc = new LC();
        $response = $lc->disableandstart();
        $statusCode = $response->getStatusCode();
        $content = json_decode($response->getContent());
        if ($statusCode==201){
            $response = Redirect::route('results', array('id'=>$content->id,'code'=>$code)); 
            //$response = Response::view('results-3', array('id'=>$content->id, 'run'=>$run+1));
        } else {
            //$response = Response::view('error', array('details' => $content));   
        }
        return $response; 		
	}
    
    public function graph($id,$code){
        $lesson = Lesson::find($id);
        $inactive = $lesson->inactive;
        $run = $lesson->run;
        if ( $run == 1 && $inactive == 0){
            $response = Response::view('results-1', array('id'=>$id, 'code'=>$code));
        } else if ( $run == 1 && $inactive == 1 ) {
            $response = Response::view('results-2', array('id'=>$id, 'run'=>2, 'code'=>$code));
        } else if ( $run != 1 && $inactive == 0) {
            $response = Response::view('results-3', array('id'=>$id, 'run'=>$run, 'code'=>$code));
        } else if ( $run != 1 && $inactive == 1) {
            $response = Response::view('results-4', array('id'=>$id, 'run'=>$run+1, 'code'=>$code));
        }
        return $response;
    }
    
    public function graphFromCode($user_id){
        $token = Cookie::get('Amautic')[0];
        $user = AuthToken::validate($token);
        $code = Input::get('code');
        //$this->log->addInfo($code.' '.$token.' '.$user['id']);
        $lesson = Lesson::where('accesscode', $code)->where('user_id',$user['id'])->orderBy('created_at', 'desc')->first();
        $run = $lesson->run;
        $inactive = $lesson->inactive;
        
        $id = $lesson->id;
        if ( $run == 1 && $inactive == 0){
            $response = Response::view('results-1', array('id'=>$id, 'code'=>$code));
        } else if ( $run == 1 && $inactive == 1 ) {
            $response = Response::view('results-2', array('id'=>$id, 'run'=>2, 'code'=>$code));
        } else if ( $run != 1 && $inactive == 0) {
            $response = Response::view('results-3', array('id'=>$id, 'run'=>$run, 'code'=>$code));
        } else if ( $run != 1 && $inactive == 1) {
            $response = Response::view('results-4', array('id'=>$id, 'run'=>$run+1, 'code'=>$code));
        }
        return $response;
    }
    
    public function students($id,$code) {
        $token = Cookie::get('Amautic')[0];
        Request::instance()->merge(array('auth_token' => $token));
        $lesson = Lesson::find($id);
        $lc = new LUC();
        $response = $lc->index($id,$lesson->run);
        $params = array(
            'students' => $response,
            'id' => $id,
            'code' => $code,
        );
        return View::make('students', $params); 		
	}
    
    public function graphData(){     
        $lesson_id = Input::get('lesson_id'); 
        $lesson = Lesson::find($lesson_id);
        $code = $lesson->accesscode;
        if ($lesson->question_type == self::Q_TRUE){
            $binary = 1;
        } else {
            $binary = 0;
        }
        if ($lesson->run > 1) {
            $code0 = $code.'R';
            $run0 = $lesson->run - 1;
            $lesson0 = Lesson::where('accesscode', $code0)->where('run',$run0)->orderBy('created_at', 'desc')->first();
            if (!is_object($lesson0) ){
                $lesson0 = Lesson::where('accesscode', $code)->where('run',$run0)->orderBy('created_at', 'desc')->first();
            }
            $ans10 = $lesson0->ans1;
            $ans20 = $lesson0->ans2;
            $ans30 = $lesson0->ans3;
            $ans40 = $lesson0->ans4;
            $ans50 = $lesson0->ans5;
            $ans_yes0 = $lesson0->ans_yes;
            $ans_no0 = $lesson0->ans_no;
            $ans_na0 = $lesson0->ans_na;            
            $ansnn0 = $lesson0->ansnn;
            $inlesson0 = $lesson0->inlesson;
        }
		$actual = array(           
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
        if ($lesson->run > 1) {
            $compare = 1;
            $previous = array(           
                'ans10' => $ans10,
                'ans20' => $ans20,
                'ans30' => $ans30,
                'ans40' => $ans40,
                'ans50' => $ans50,
                'ans_yes0' => $ans_yes0,
                'ans_no0' => $ans_no0,
                'ans_na0' => $ans_na0,            
                'ansnn0' => $ansnn0,
                'inlesson0' => $inlesson0,
            );
        } else {
            $compare = 0;
            $previous = null;
        }
        $answers = array( 'compare'=>$compare, 'binary'=>$binary, 'actual'=>$actual, 'previous'=>$previous );
		return Response::json($answers, JsonResponse::HTTP_OK);
        
    }
    
    
    public function report($id,$code) {
        date_default_timezone_set("America/Lima");
        $token = Cookie::get('Amautic')[0]; 
        $user = AuthToken::validate($token);
        $teacher = User::find($user['id']) ;       
        $lesson = Lesson::find($id);
        $survey = Survey::find($lesson->survey);
        $mode = QuestionMode::find($lesson->question_mode);
        $type = QuestionType::find($lesson->question_type);
        $course_name = 'None';
        if ($lesson->course_id != -1){
            $course = Course::find($lesson->course_id);
            $course_name = $course->name;
        }
        if ($lesson->run > 1) {
            $accesscode = $code.'R';
            $run0 = $lesson->run - 1;
            $lesson0 = Lesson::where('accesscode', $accesscode)->where('run',$run0)->orderBy('created_at', 'desc')->first();
            $inlesson0 = $lesson0->inlesson;
            $ans_yes0 = $lesson0->ans_yes;
            $ans_no0 = $lesson0->ans_no;
            $ans_na0 = $lesson0->ans_na; 
            $ans10 = $lesson0->ans1;
            $ans20 = $lesson0->ans2;
            $ans30 = $lesson0->ans3;
            $ans40 = $lesson0->ans4;
            $ans50 = $lesson0->ans5;                     
            $ansnn0 = $lesson0->ansnn;
                       
        } else {
            $ans_yes0 = 0;
            $ans_no0 = 0;
            $ans_na0 = 0; 
            $ans10 = 0;
            $ans20 = 0;
            $ans30 = 0;
            $ans40 = 0;
            $ans50 = 0;               
            $ansnn0 = 0;           
            $inlesson0 = 0;
        }
        
        $data = array(
        'id' => $lesson->id,
        'teacher' => $teacher->first_name.' '.$teacher->last_name,
        'code' => $code,
        'coursename' => $course_name,
        'questiontype' => $type->name_en,    
        'questionmode' => $mode->name_en,                
        'subject' => $lesson->subject,
        'exercise' => $lesson->exercise,
        'run' => $lesson->run,
        'students' => $lesson->inlesson,
        'ans1' => $lesson->ans1,
		'ans2' => $lesson->ans2,
		'ans3' => $lesson->ans3,
		'ans4' => $lesson->ans4,
		'ans5' => $lesson->ans5,
        'ans_yes' => $lesson->ans_yes,
        'ans_no' => $lesson->ans_no,
        'ans_na' => $lesson->ans_na,            
		'ansnn' => $lesson->ansnn,
        'opinion' => $survey->name_en,
        'ans1_name' => $survey->opt1_name_en,
		'ans2_name' => $survey->opt2_name_en,
		'ans3_name' => $survey->opt3_name_en,
		'ans4_name' => $survey->opt4_name_en,
		'ans5_name' => $survey->opt5_name_en, 
        'ans10' => $ans10,
		'ans20' => $ans20,
		'ans30' => $ans30,
		'ans40' => $ans40,
		'ans50' => $ans50,
        'ans_yes0' => $ans_yes0,
        'ans_no0' => $ans_no0,
        'ans_na0' => $ans_na0,            
		'ansnn0' => $ansnn0,
        'students0' => $inlesson0,
        /*'date' => date('Y-m-d H:i:s'),*/
        'date' => date('d-m-Y'),
        );
                
        if (App::getLocale() == 'es'){
            $data['opinion'] = $survey->name_es;
            $data['ans1_name'] = $survey->opt1_name_es;
            $data['ans2_name'] = $survey->opt2_name_es;
            $data['ans3_name'] = $survey->opt3_name_es;
            $data['ans4_name'] = $survey->opt4_name_es;
            $data['ans5_name'] = $survey->opt5_name_es;   
            $data['questiontype'] = $type->name_es;
            $data['questionmode'] = $mode->name_es;            
        }
       
        return View::make('report', $data);
        
    }

    
    
    
    
}
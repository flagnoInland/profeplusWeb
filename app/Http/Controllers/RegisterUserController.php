<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Log, Auth, Validator, Input, Redirect, Response, DB, Hash; 
use Carbon\Carbon;
use App\User;
use App\UserToken;
use App\Concurso;

class RegisterUserController extends BaseController {
    

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
    
    public $log;
	
     
    public function __construct()
    {
       //$this->log = new Logger('my_logger');    
       //$this->log->pushHandler(new StreamHandler(storage_path().'/logs/custom.log', Logger::INFO));
    } 

    function generateRandomString($length)
    {
            return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function recover()
    {
        $response = DB::connection()->transaction(function() {
            $data = Input::json()->all();
            $email = $data['email'];
            //$nationid = $data['nationid'];
            $postedDate = $data['birthdate'];
            /*
            $postedDate = str_replace('-', '/', $postedDate);
            $postedDate = str_replace('/ ', '/', $postedDate);
            $postedDate = str_replace(' /', '/', $postedDate);
            $postedDate = str_replace(' ', '/', $postedDate);
            try {
                //$birthdate = Carbon::createFromFormat('d/m/Y', $postedDate)->toDateString();
                $birthdate = Carbon::createFromFormat('Y/m/d', $postedDate)->toDateString();
            } catch (Exception $e ){ 
                $birthdate = "1990-06-15";
            }
            */
            $yourpass = $data['yourpass'];
            Log::error($email.'-->'.$postedDate);
            //$user = User::where('email', $email)->where('birthdate',$postedDate)->first();
            $user = User::where('email', $email)->first();
            //$yourpass = $this->generateRandomString(6);
            if( $user == null){
                    return Response::json(array(), JsonResponse::HTTP_BAD_REQUEST);
            } else {
                $user->password = Hash::make($yourpass);
                $user->save();
                return Response::json(new \stdClass(),JsonResponse::HTTP_CREATED);
            }
        });
        return $response;
		
		/*
		$to = $email;
		$subject = "Contraseña Olvidada";
		$txt = "Tu contraseña es:\r\n".$yourpass."\r\nCambia la clave en tu perfil";
		$headers = "From: masterequipu@e-quipu.pe";
		mail($to,$subject,$txt,$headers);
		*/
    }

    public function index($user_id)
    {
        //$token = Input::get('auth_token');
        //$data = AuthToken::validate($token);
		$data = User::find($user_id);
        if ($data != null){
            $hasVoted = 0;
            $userid = $data['id'];
            $concurso = Concurso::where('user_id', $userid)->first();
            if ($concurso != null){
                $hasVoted = 1;
            }
            $details = array(
                'id' => $data['id'],		
                'last_name' => $data['last_name'],
                'first_name' => $data['first_name'],
                'email' => $data['email'],
                'nationid' => $data['nationid'],
                'gender' => $data['gender'],
                'birthdate' => $data['birthdate'],
                'country' => $data['country'],
                'city' => $data['city'],
                'phone' => $data['phone'],
                'teacher' => $data['teacher'],
                'studentid' =>  $data['studentid'],
                'speciality' => $data['speciality'],
                'institution' => $data['institution_name'],
                'appmode' => $data['appmode'],
                'concurso' => $hasVoted,
            );
            $response = Response::json($details, JsonResponse::HTTP_OK);
        } else {
            $response = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
        }
        return $response;
    }

    public function store()
    {
        $response = DB::connection()->transaction(function() { 
            $data = Input::json()->all();
            $validator = Validator::make($data, array(			
                            'first_name' => 'required|max:255',
                            'last_name' => 'required|max:255',
                            'email' => 'required|email|max:255|unique:profeplus_users',
                            'password' => 'required',
                            //'birthdate' => 'date',
                            //'country' => 'required',
                            //'city' => 'required',
                            //'phone' => 'required',			
            ));

            if ($validator->passes()) {
                $postedDate = $data['birthdate'];
                $birthdate = $data['birthdate'];
                /*
                $postedDate = str_replace('-', '/', $postedDate);
                $postedDate = str_replace('/ ', '/', $postedDate);
                $postedDate = str_replace(' /', '/', $postedDate);
                $postedDate = str_replace(' ', '/', $postedDate);
                try {
                    if (strlen($postedDate)>0 && $postedDate[2]=='/'){
                        $birthdate = Carbon::createFromFormat('d/m/Y', $postedDate)->toDateString();
                    } else if (strlen($postedDate)>0 && $postedDate[4]=='/'){
                        $birthdate = Carbon::createFromFormat('Y/m/d', $postedDate)->toDateString();
                    } else {
                        $birthdate = "1990-06-15";
                    }
                } catch (Exception $e ){
                    $birthdate = "1990-06-15";
                }
                */
                Log::error($data['email'].'-->'.$birthdate);
                Log::error($data);
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
                    if (array_key_exists('description', $data)){
                        if ($data['description'] == ""){
                            $data['description'] = "none";
                        }
                    } else {
                        $data['description'] = "none";
                    }
                    User::create(array(			
                        'last_name' => $data['last_name'],
                        'first_name' => $data['first_name'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                        'nationid' => $data['nationid'],
                        'gender' => $data['gender'],
                        'birthdate' => $birthdate,
                        'country' => $data['country'],
                        'city' => $data['city'],
                        'phone' => $data['phone'],
                        'teacher' => $data['teacher'],
                        'studentid' =>  $data['studentid'],
                        'appmode' => $data['appmode'], 
                        'speciality' => $data['speciality'],
                        'institution_name' => $data['institution_name'],				
                        'description' => $data['description'],				
                    ));
                    
                    $credentials = array('email' => $data['email'],'password' => $data['password']);
                    //if(Auth::attempt($credentials)){
                    if($data['email'] != null){
                        //$authToken = AuthToken::create(Auth::user());
                        //$token = AuthToken::publicToken($authToken);
                        $token = "none";
                        //$user = AuthToken::user($authToken);              
                        $user = User::where('email',$data['email'])->first();              
                        //$user->save();
                        /*
                        UserToken::create(array(
                            'user_id' => $user->id,
                            'remember_token' => $token,
                            'device' => 1,
                        ));
                        if ($data['concurso_group'] != null && $data['concurso_group'] != ""){
                            DB::table('profeplus_concurso')->insert(array(
                                'user_id' => $user->id,
                                'team' => $data['concurso_group'],
                                'institute' => $data['concurso_institute'],
                            ));
                        }*/
                    }           
                    $details = array(
                        'token' => $token,
                        'user_id' => $user->id,
                        'teacher' => $user->teacher,
                        'appmode' => $user->appmode,
                        'country' => $user->country,
                        'document_id' => "$user->nationid",
                        'name' => $user->first_name.' '.$user->last_name
                    );
                    return Response::json($details, JsonResponse::HTTP_CREATED);
                } catch (\Illuminate\Database\QueryException $e ){
                        Log::error($e->getMessage());
                        return Response::json(new \stdClass(), JsonResponse::HTTP_BAD_REQUEST);
                }
            } else {
                return Response::json(new \stdClass(), JsonResponse::HTTP_BAD_REQUEST);
            }
        });
        return $response;
    }

    public function update($user_id)
    {       
        //$token = Input::get('auth_token');
        //$user = AuthToken::validate($token);
		$user = User::find($user_id);
        if ($user != null){
            $data = Input::json()->all();
            $user->last_name = $data['last_name'];
            $user->first_name = $data['first_name'];
            $user->nationid = $data['nationid'];
            $user->birthdate = $data['birthdate'];
            $user->country = $data['country'];
            $user->city = $data['city'];
            $user->phone = $data['phone'];
            $user->studentid =  $data['studentid'];
            $user->teacher =  $data['teacher'];
            $user->appmode =  $data['appmode'];
            $user->gender =  $data['gender'];
            $user->speciality = $data['speciality'];
            $user->institution_name = $data['institution_name'];
            $user->save();
            if ($data['concurso_group'] != null && $data['concurso_group'] != ""){
                DB::table('profeplus_concurso')->insert(array(
                    'user_id' => $user->id,
                    'team' => $data['concurso_group'],
                    'institute' => $data['concurso_institute'],
                ));
            }
            $response = Response::json(new \stdClass(), JsonResponse::HTTP_OK);
        } else {
            $response = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
        }
        return $response;
    }
    
    public function changeMode($user_id) 
    {       
        //$token = Input::get('auth_token');
        //$user = AuthToken::validate($token);
		$user = User::find($user_id);
        if ($user != null){
            $data = Input::json()->all();
            $user->teacher =  $data['teacher'];
            $user->appmode =  $data['appmode'];
            $user->save();
            $response = Response::json(new \stdClass(), JsonResponse::HTTP_OK);
        } else {
            $response = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
        }
        return $response;
    }
	
    public function changeModeNew($user_id, $app, $teacher) 
    {       
        $user = User::find($user_id);
        if ($user != null){
            $user->teacher =  $teacher;
            $user->appmode =  $app;
            $user->save();
            $response = Response::json(new \stdClass(), JsonResponse::HTTP_OK);
        } else {
            $response = Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
        }
        return $response;
    }


}

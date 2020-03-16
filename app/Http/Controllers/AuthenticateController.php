<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Auth, Validator, Input, Redirect, Response, DB, Hash; 
use Carbon\Carbon;
use App\User;
use App\UserToken;
use App\Concurso;

class AuthenticateController extends BaseController {
    
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
    
    private static $instance;
    
    public static function getInstance() {
        if (null === static::$instance) {
            static::$instance = new static();
        }        
        return static::$instance;
    }
    
    public function authenticate()
	{
		$credentials = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
		);
		$email = Input::get('email');
		$user = User::where('email',$email)->first();
		//if( !Auth::attempt($credentials)){
		if( $user == null ){
            //return response()->json(array('error' => 'invalid_credentials'), 401);
			return Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
		} else {     
            //$authToken = AuthToken::attempt($credentials);
            //$token = AuthToken::publicToken($authToken);
            //$token = AuthToken::publicToken($authToken);

            // all good so return the token
            //$user = AuthToken::user($authToken);
            //$user = User::find($user_id);
			//$token = $user->createToken('laravel-api')->accessToken;
			$token = "none";
            $utoken = UserToken::where('user_id',$user->id)->first();
			if($utoken != null){
				$utoken->remember_token = $token;
				$utoken->save();
			}
			/*
            $evals = DB::table('profeplus_evaluations')
                        ->whereRaw('profeplus_evaluations.date <= DATE_SUB(now(), INTERVAL 1 DAY)')
                        ->where('profeplus_evaluations.status',self::ACTIVE)
                        ->where('profeplus_evaluations.user_id',$user->id)
                        ->get();
            foreach ($evals as $eval){
                $ev = Evaluation::find($eval->id); 
                $ev->status = self::INACTIVE;
                $ev->save();
            }
            $evals = DB::table('profeplus_evaluations')
                        ->whereRaw('profeplus_evaluations.date > DATE_SUB(now(), INTERVAL 1 DAY)')
                        ->where('profeplus_evaluations.status',self::ACTIVE)
                        ->where('profeplus_evaluations.user_id',$user->id)
                        ->count();
						*/
            $details = array(
                    'token' => $token,
                    'user_id' => (int)$user->id,
                    'teacher' => (int)$user->teacher,
                    'appmode' => (int)$user->appmode,
                    'country' => $user->country,
                    'document_id' => "$user->nationid",
                    'name' => $user->first_name.' '.$user->last_name,
                    //'evaluations' => $evals,
					'gender' => $user->gender,
            );
            return Response::json($details, JsonResponse::HTTP_OK);
        }
	}
	
	public function guestLogin() {
        $email = Input::get('email');
        $yourpass = Input::get('password');
		$user = User::where('email',$email)->first();		
		if ($user != null) {
			$data = array(
				'token' => "none",
				'user_id' => (int)$user->id,
				'teacher' => (int)$user->teacher,
				'appmode' => (int)$user->appmode,
				'country' => $user->country,
				'document_id' => "$user->nationid",
				'name' => $user->first_name.' '.$user->last_name,
				'evaluations' => 0,
				'gender' => $user->gender,
			);
			return $response = Response::json($data, JsonResponse::HTTP_OK);
		} else {
			return Response::json(new \stdClass(), JsonResponse::HTTP_NOT_FOUND);
		}
	}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Guard;
use Validator, Input, Redirect, Response, DB, Hash, Mail, Auth, Log;
use Carbon\Carbon;
use App\User;
use App\Concurso;
use App\Lesson;
use App\Evaluation;
use App\Role;
use App\Survey;
use App\QuestionType;

class AdminController extends Controller {
    
  public function isAdmin(){

    $email = Input::get('email');
    $pass = Input::get('password');
    $credentials = array(
        'email' => Input::get('email'),
        'password' => Input::get('password')
    );

	 
    if( Auth::attempt($credentials)){
      $user = Auth::user();
      $rol = $user->roles()->first();
      if ($rol->role > Role::USER){
        return Response::json( array('userId' => $user->id), 
                JsonResponse::HTTP_OK);
      }
    }

      /*
      $user = User::where('email',$email)->first();        		
      if ($user != null){
          if (Hash::check($pass, $user->password)) {
              $rol = $user->roles()->first();
              //Log::info($rol);
              if ($rol->role > Role::USER){
                  return Response::json( array('userId' => $user->id), 
                          JsonResponse::HTTP_OK);
              }
          } 
      } 
      */
    return Response::json( new \stdClass(), JsonResponse::HTTP_BAD_REQUEST);
  }
    
  public function getUserData(){
    $userId = Input::get("id");
    $role = Role::where('userId',$userId)->first();
    $user = User::find($userId)
            ->select('id','first_name','last_name')
            ->first();
    $data = array (
        'fullname' => $user->first_name.' '.$user->last_name,
        'rol' => $role->role,
    );
    if ($user != null){
      return Response::json($data, JsonResponse::HTTP_OK);
    }
    return Response::json( new \stdClass(), JsonResponse::HTTP_BAD_REQUEST);
  }
    
  public function getStats(){
    $users = User::select('id')->count();
    $date = User::select('id','created_at')->orderBy('id', 'desc')->first();
    $dateUser = $date['created_at']->format('d-m-Y');
    //Log::info($dateUser);
    $leccs = Lesson::select('id')->count();
    if ($leccs > 0 ){
      $date = Lesson::all()->last();
      $dateLecc = $date['created_at']->format('d-m-Y');
    } else {
      $dateLecc = 'Indeterminado';
    }
    $exams = Evaluation::select('id')->count(); 
    if ($exams > 0){
      $date = Evaluation::select('id','created_at')->orderBy('id', 'desc')->first();
      $dateExam = $date['created_at']->format('d-m-Y');
    } else {
      $dateExam = 'Indeterminado';
    }
    $nusers = User::usersByMonth();
    $cusers = User::usersByCountry();
    $pusers = User::nationalUsers();
    $concurso = Concurso::concursoByGroup();
    //Log::info($nusers);
    $data = array(
        'users' => $users,
        'dateUser' => $dateUser,
        'leccs' => $leccs,
        'dateLecc' => $dateLecc,
        'exams' => $exams,
        'dateExam' => $dateExam,
        'nusers' => $nusers,
        'cusers' => $cusers,
        'pusers' => $pusers,
        'concurso' => $concurso,
    );
    return Response::json($data, JsonResponse::HTTP_OK);
  }
    
  public function getUserInfo(){
    $email = Input::get('email');
    //Log::info($email);
    $user = User::where('email',$email)->first();
    if ($user != null){
      $rols = $user->roles()->first();
      if ($rols == null){
        $rol = 0;
      } else {
        $rol = $rols->role;
      }
      return Response::json( array(
              'user' => $user->toArray(), 
              'rol' => $rol ), 
          JsonResponse::HTTP_OK);    
    } 
    return Response::json( new stdClass(), JsonResponse::HTTP_BAD_REQUEST);
  }
    
  public function changeRole(){
    $data = Input::json()->all();
    $userId = $data['userId'];
    $role = $data['rol'];
    $rols = Role::where('userId',$userId)->first();
    if ($rols == null){
      $rols = Role::create(array(
          'role' => $role,
      ));
      $user = User::find($userId);
      $user->roles()->save($rols);
    }
    $rols->role = $role;
    $rols->save();
    return Response::json( new \stdClass(), JsonResponse::HTTP_OK);
  }
    
  // Modify Guard in Laravel/Auth
  public function logout(){
    Auth::logout();
    return Redirect::to('/admin');
  }
    
  // Send Log file to Admin
  public function mailLog(){
    $admin = User::find(1);
    $pathToLog = storage_path().'/logs/laravel.log';
    Mail::send('emails.log', array('admin'=>$admin), function($message) use ($admin, $pathToLog) {
      $message->to('herbertacg@gmail.com', $admin->first_name.' '.$admin->last_name)
          ->subject('Laravel Log File')
          ->attach($pathToLog);
    });
    return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
  }
    
}


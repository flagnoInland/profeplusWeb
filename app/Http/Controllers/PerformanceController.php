<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Guard;

class PerformanceController extends Controller {
    
    
    public function getSummary(){
        $myKey = "lessons";
        $minutes = 60;
        /*
        if (Cache::has($myKey)){
            $value = Cache::get($myKey);
        } else {
            $value = Lesson::all();
            Cache::add($myKey, $value, $minutes);
        }
         */
        $value = Cache::remember($myKey, $minutes, function() {
            return Lesson::all();
        });
        //$value2 = Lesson::all();
        return Response::json( $value, JsonResponse::HTTP_OK);
    }
    
    public function addStudent($id){
        $response = DB::transaction( function() use ($id) {
            DB::table('profeplus_lessons')->where('id',$id)
                    ->lockForUpdate()->first();
            $lesson = Lesson::find($id);
            $lesson->ans1 = $lesson->ans1 + 1;
            $lesson->inlesson = $lesson->inlesson + 1;
            $lesson->save();   
            return Response::json(array('students'=>$lesson->inlesson), JsonResponse::HTTP_OK);
        });
        return $response;
    }

}


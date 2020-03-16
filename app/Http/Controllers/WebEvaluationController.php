<?php


namespace App\Http\Controllers;

//require __DIR__.'/../../../vendor/autoload.php';

use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Jenssegers\Agent\Agent;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

use Validator, Input, Redirect, Response, DB, Mail, Excel, Log; 
use Carbon\Carbon;
use App\User;
use App\Lesson;
use App\Evaluation;
use App\EvaluationStudent;
use App\RandomNumber;
use App\Rands;

class WebEvaluationController extends BaseController {
	
  const ACTIVE = 1;
  const INACTIVE = 0;

  // Comienza en 8950
  public function getCustomRandom($index){
    $myrandoms = array("4641","5155","5922","2228","3675","2003","5982",
    "4986","8012","9998","9073","2851");
    //$myrandoms = array("2851","3019","9737","8054","9073","4641","8407","5155","9998",
    //"1893","3677","8012","4865","4986","5982","9202","2003","3675","2228","5922");
    return $myrandoms[$index];
  }

  public function getCustomExamWeight($index){
    $vals = "[1,1,1,1,1,0,0,0,0,0]";
    return $vals;
  }

  public function getCustomExamTypes($index){
    $vals = "[1,1,1,1,1,1,1,1,1,1]";
    return $vals;
    
  }

  public function getCustomExamAnswer($random){
    $vals = "[5,5,2,4,5,1,1,1,1,1]";
    switch ($random) {
      case 4641:
          $vals = "[5,5,2,4,5,1,1,1,1,1]";
          break;
      case 5155:
          $vals = "[3,5,4,3,4,1,1,1,1,1]";
          break;
      case 5922:
          $vals = "[3,2,5,5,4,1,1,1,1,1]";
          break;
      case 2228:
          $vals = "[1,3,2,5,5,1,1,1,1,1]";
          break;
      case 3675:
          $vals = "[1,3,2,5,5,1,1,1,1,1]";
          break;
      case 2003:
          $vals = "[5,2,3,1,4,1,1,1,1,1]";
          break;
      case 5982:
          $vals = "[2,2,1,5,5,1,1,1,1,1]";
          break;
      case 4986:
          $vals = "[1,3,2,5,1,1,1,1,1,1]";
          break;
      case 8012:
          $vals = "[2,5,4,4,3,1,1,1,1,1]";
          break;
      case 9998:
          $vals = "[4,5,3,2,2,1,1,1,1,1]";
          break;
      case 9073:
          $vals = "[3,1,2,5,5,1,1,1,1,1]";
          break;
      case 2851:
          $vals = "[5,1,3,4,5,1,1,1,1,1]";
          break;
      default:
          break;
    }
    return $vals;
  }

  public function getEmpty(){
    return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
  }
	
  public function testLogin(){
    $email = Input::get('email');
    $user = User::where('email',$email)->first();
    return Response::json(array('id'=>$user->id), JsonResponse::HTTP_OK);
  }
	
  public function create(){
    $response = DB::connection()->transaction(function(){
      $data = Input::json()->all();
      $teacher = User::find($data['user_id']);
      $lesson = new Lesson(array(
          'question_type' => Lesson::Q_EVAL,
          'observations' => $data['observations'],
          'institution' => $data['institution'],
          'speciality' => $data['speciality'],
          'course_name' => $data['course_name'],
          'status' => Lesson::DISABLED,
      ));
      $teacher->lessons()->save($lesson);
      $code = RandomNumber::find($lesson->id % 7999 + 1)->random;
      $evaluation = new Evaluation(array(
          'number_question' => $data['number_question'],
          'overall_score' => $data['overall_score'],
          'eval_type' => $data['eval_type'],
          'visibility' => Evaluation::INVISIBLE,
          'start_time' => Carbon::now()->format('H:i:s'),
          'end_time' => Carbon::now()->addMinutes($data['duration'])->format('H:i:s'),
          'date' => date('Y-m-d'),
          'duration' => $data['duration'],
          'exam_title' => $data['exam_title'],
          'materials' =>  $data['materials'],
          'answer_keys' => $data['answer_keys'],            
          'answer_weights' => $data['answer_weights'],
          'answer_types' => preg_replace('/\[|\]/', "", $data['answer_types']),
      ));
      // save lesson to get ID
      $teacher->evaluations()->save($evaluation);
      $lesson->evaluation()->save($evaluation);
      $lesson->accesscode = $code;
      $lesson->save();  
      $evals = $teacher->evaluations()->count();
      $details = array(
          'lesson_id' => $lesson->id,
          'code' => $lesson->accesscode,
          'eval_id' => $evaluation->id
      );
      return Response::json($details, JsonResponse::HTTP_CREATED);
    });
    return $response;
  }

  public function createCustomEval($user_id, $custom_eval_id){
    $response = DB::connection()->transaction(function() use ($user_id, $custom_eval_id){
      $data = Input::json()->all();
      $teacher = User::find($user_id);
      $custom_eval_id = $custom_eval_id;
      Log::info($custom_eval_id);
      $myrandom = WebEvaluationController::getCustomRandom($custom_eval_id-1);
      $lesson = new Lesson(array(
          'question_type' => Lesson::Q_EVAL,
          'observations' => "Responda todas las preguntas de manera individual.",
          'institution' => "Profeplus",
          'speciality' => "Innovación",
          'course_name' => "Programa de Co-Innovación para el Desarrollo Emprendedor",
          'status' => Lesson::ENABLED,
          'accesscode' => $myrandom,
      ));
      $teacher->lessons()->save($lesson);
      //$code = RandomNumber::find($lesson->id % 999 + 8001)->random;
      $evaluation = new Evaluation(array(
          'lesson_id' => $lesson->id,
          'number_question' => 10,
          'overall_score' => 20,
          'eval_type' => 3,
          'visibility' => Evaluation::VISIBLE,
          'start_time' => Carbon::now(),
          'end_time' => Carbon::now()->addDays(7),
          'date' => date('Y-m-d'),
          'duration' => 7,
          'exam_title' => "Evaluación",
          'materials' =>  "",
          'answer_keys' => WebEvaluationController::getCustomExamAnswer($myrandom),         
          'answer_weights' => WebEvaluationController::getCustomExamWeight($custom_eval_id-1),
          'answer_types' => preg_replace('/\[|\]/', "", WebEvaluationController::getCustomExamTypes($custom_eval_id-1)),
      ));
      // save lesson to get ID
      $teacher->evaluations()->save($evaluation);
      $lesson->evaluation()->save($evaluation);
      $lesson->accesscode = $myrandom;
      $lesson->save();  
      $evals = $teacher->evaluations()->count();
      $details = array(
          'lesson_id' => $lesson->id,
          'code' => $lesson->accesscode,
          'eval_id' => $evaluation->id
      );
      return Response::json($details, JsonResponse::HTTP_CREATED);
    });
    return $response;
  }

  public function startExam($user_id, $lesson_id){
    //Log::info('startExam');
    $response  = Response::json(new \stdClass(), JsonResponse::HTTP_OK);
    $lesson = Lesson::find($lesson_id);
    if ($lesson != null){           
      $lesson->status = Lesson::ENABLED;
      $lesson->save();
      //Log::info($lesson);
      $exam = Evaluation::where('lesson_id', $lesson->id)->first();
      if ($exam != null){
        $duration = $exam->duration;
        $exam->start_time = Carbon::now()->format('H:i:s');
        $exam->end_time = Carbon::now()->addMinutes($duration)->format('H:i:s');
        $exam->visibility = Evaluation::VISIBLE;
        $exam->save();
        //Log::info($exam);
        $response  = Response::json(array('id'=>$exam->id,'lesson_id'=>$lesson->id), JsonResponse::HTTP_OK);
      }
    }
    return $response;
  }

  public function statusCustomEval($user_id, $custom_eval_id){
    Log::info($custom_eval_id);
    $myrandom = WebEvaluationController::getCustomRandom($custom_eval_id-1);
    $response  = Response::json(array('status'=>Lesson::DISABLED,'accesscode'=>$myrandom), JsonResponse::HTTP_OK);
    $lesson = Lesson::where('accesscode', $myrandom)->first();
    if ($lesson != null){           
        $response  = Response::json(array('status'=>$lesson->status,'accesscode'=>$lesson->accesscode), JsonResponse::HTTP_OK);
      }
    return $response;
  }
	
  public function index($user_id){
    $data = (array) User::lessonEvaluations($user_id);
    return Response::json($data, JsonResponse::HTTP_OK);
  }
  
  public function indexEval($user_id, $lessonId){
    $data = (array) User::lessonOneEvaluation($user_id, $lessonId);
    return Response::json($data, JsonResponse::HTTP_OK);
  }

  public function examIndex($user_id, $lesson_id){
    $data = Lesson::connectedToExam($lesson_id)->first();
    return Response::json($data, JsonResponse::HTTP_OK);
  }

  public function destroy($user_id, $lesson_id){
    $lesson = Lesson::find($lesson_id);
    //$lesson->switchOff();
    return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
  }

  public function remove($user_id, $eval_id){
    $exam = Evaluation::where('id',$eval_id)->first();
    $exam->visibility = Evaluation::INVISIBLE;
    $exam->save();
    $lesson = Lesson::find($lesson_id);
    $lesson->status = Lesson::DISABLED;
    $lesson->save();
    //$lesson->switchOff();
    return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
  }

  public function removeByLesson($user_id, $lesson_id){
    $exam = Evaluation::where('lesson_id',$lesson_id)->first();
    $exam->visibility = Evaluation::INVISIBLE;
    $exam->save();
    $lesson = Lesson::find($lesson_id);
    $lesson->status = Lesson::DISABLED;
    $lesson->save();
    $lesson->switchOff();
    return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
  }

  public function removeCustomEval($user_id, $custom_eval_id){
    $myrandom = WebEvaluationController::getCustomRandom($custom_eval_id-1);
    $lesson = Lesson::where('accesscode', $myrandom)->first();
    Log::info($myrandom);
    if ($lesson != null){
      $exam = Evaluation::where('lesson_id',$lesson->id)->first();
      $exam->visibility = Evaluation::INVISIBLE;
      $exam->save();
      $lesson->status = Lesson::DISABLED;
      $lesson->save();
      $lesson->switchOff();
    }
    return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
  }
    
  public function cleanExam($user_id){
    //Log::info('cleanExam');
    $user = User::find($user_id);
    $now = Carbon::now();
    //Log::info($now);
    $exams = $user->evaluations()->get();
      if ($exams != null){
        foreach ( $exams as $exam ){
          $eval = Evaluation::find($exam['id']);            
          $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $eval->date.' '.$eval->end_time);
          $endTime->setTimezone('America/Lima');
          $elapsed = $endTime->diffInMinutes($now,false);
          $lesson = Lesson::find($eval->lesson_id);
          //Log::info($lesson);
          //Log::info($endTime);
          //Log::info($elapsed);
          if ($lesson != null && $elapsed > 240 ){
            $lesson->status = Lesson::DISABLED;
            $lesson->save();
            $eval->visibility = Evaluation::INVISIBLE;
            $eval->save();
          } else if ($elapsed > 0){
            $lesson->status = Lesson::DISABLED;
            $lesson->save();
          }
          //Log::info($lesson);
        }
      }
    }
	

  // DEPRECATED: SEE StudentLessonController@getLessonDetails
  public function takeExam($user_id, $code){
    $response  = Response::json(new \stdClass(), JsonResponse::HTTP_BAD_REQUEST);
    $student = User::find($user_id);
    if ($student != null){
      //Log::info($student);
      $lesson = Lesson::hasEvaluation($code)->first();
      if ($lesson != null){
        //Log::info($lesson);
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
          //Log::info($examinado);
          $response = Response::json($exam, JsonResponse::HTTP_OK);
        } else if ( $examinado['status'] != EvaluationStudent::DONE){
          //Log::info($examinado);
          $response = Response::json($exam, JsonResponse::HTTP_OK);
        }   
      }
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

  public function getStatus($lesson_id){
    $lesson = Lesson::find($lesson_id);
    $data = array(
      'status' => $lesson->status
    );
    return Response::json($data, JsonResponse::HTTP_OK);
  }
	
  public function getExam($lesson_id){
    $lesson = Lesson::getExamHeader($lesson_id)->first();
    $exam = $lesson->evaluation()->data()->first();
    $details = array(
      'lesson' => $lesson->toArray(),
      'exam' => $exam->toArray(),
    );
    return Response::json($details, JsonResponse::HTTP_OK);
  }
	
  public function getExamStudent($eval_id, $user_id){
    $examinado = EvaluationStudent::findExaminado($user_id, $eval_id)->first();
    return Response::json(array('solutions'=>$examinado->solutions), JsonResponse::HTTP_OK);
  }
	
  public function sendExam($user_id,$eval_id){
    $examinado = EvaluationStudent::findExaminado($user_id, $eval_id)->first();
    $data = Input::json()->all();
    $answers = $data['answers'];
    $status = $data['status'];
    $lesson_id = $examinado->lesson_id;
    $examinado->solutions = implode(",",$answers);
    $examinado->score = $this->setScore($eval_id, $answers);
    $examinado->status = $status;//EvaluationStudent::DONE;
    $examinado->save();
    $exam = Evaluation::find($eval_id);
    $lesson = Lesson::find($exam->lesson_id);
    if ($status==1){
      $lesson->addFinished();
    }
    return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
  }
	
  private function setScore($eval_id, $answers){
    $exam = Evaluation::where('id',$eval_id)->first();
    $num = $exam->number_question;
    $weight = explode(",", $exam->answer_weights);
    $key = explode(",", $exam->answer_keys);
    $score = 0.0;
    for ($x = 0; $x < $num; $x++){
      if ($answers[$x] == $key[$x]){
        $score = $score + 1.0*$weight[$x];
      }
    }
    return $score;
  }
	
  public function mailExam($user_id, $eval_id){
    $localPath = public_path().'/';
    $teacher = User::find($user_id);
    $exam = Evaluation::find($eval_id);
    $lesson = Lesson::find($exam->lesson_id);
    $lesson->switchOff();
    $users = array();
    $users = DB::table('profeplus_student_evaluation AS pse')
            ->select(DB::raw('pse.score, pse.solutions, pu.first_name, pu.last_name, pu.studentid'))
            ->join('profeplus_users AS pu', 'pu.id', '=', 'pse.user_id')                  
            ->where('pse.evaluation_id',$eval_id)
            ->get();
    $filename = $user_id.'_'.$teacher->last_name.'_'.$eval_id.'.xlsx';
	  
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setTitle('General');

  	$spreadsheet = WebEvaluationController::generalReport($spreadsheet, $exam, $lesson, $users);
	
	$spreadsheet->createSheet();
	$sheet1 = $spreadsheet->getSheet(1);
	$sheet1->setTitle('Estudiantes');
	if ($exam->eval_type == 2){
		$spreadsheet = WebEvaluationController::detailReportFCI($spreadsheet, $exam, $lesson, $users);
	} else {
		$spreadsheet = WebEvaluationController::detailReport($spreadsheet, $exam, $lesson, $users);
	}

	  $localPathToFile = $localPath.$filename;
	$writer = new Xlsx($spreadsheet);
	$writer->save($filename);

    
    //$contents = "abcdefghijkl";
    //File::put($localPathToFile, $contents);
    $data = array('teacher' => $teacher);
    $reportTemplate = 'emails.informe';
    $agent = new Agent();
	if ($agent->isMobile()) {
      $reportTemplate = 'informe';
    }
    Mail::send($reportTemplate, $data, function($message) use ($teacher, $localPathToFile) {
      $message->to($teacher->email, $teacher->first_name.' '.$teacher->last_name)
          ->subject('Evaluación ProfePLUS')
          ->attach($localPathToFile);
    });

    return Response::json(new \stdClass(), JsonResponse::HTTP_OK);			
  }
	
	public static function generalReport($spreadsheet, $exam, $lesson, $users){
	  	$sheet = $spreadsheet->getSheetByName('General');
	  
	  	$column_number = Coordinate::columnIndexFromString('A') + ($exam->number_question + 2);
		$last_column = $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
		$sheet->mergeCells('A1:'.$column_letter.'1');
		$sheet->getStyle('A1:'.$column_letter.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('54be7a');
		$sheet->getStyle('A1:'.$column_letter.'1')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);

		$header = '';
		$header .= isset($lesson->institution)? $lesson->institution. "\n":'';
		$header .= isset($lesson->speciality)? strtoupper($lesson->speciality). "\n":'';
		if ($exam->eval_type == 2){
		  $header .= 'Resultados del "Force Concept Inventory" - FCI [1]'."\n\n";
		} else{
		  $header .= isset($exam->exam_title)? $exam->exam_title. "\n":'';
		  $header .= isset($lesson->course_name)? $lesson->course_name. "\n":'';
		}

		$sheet->setCellValue('A1', $header);

		$sheet->getColumnDimension("A")->setAutoSize(true);
		$sheet->getColumnDimension("B")->setAutoSize(true);

		$sheet->setCellValue('B3', 'Respuesta correcta:');
		$sheet->setCellValue('B4', 'Puntaje asignado:');

		$keys = explode(",", $exam->answer_keys);
		$weight = explode(",", $exam->answer_weights);
		$num = $exam->number_question;

		$column = 'C';

		for ($z=0; $z<$num; $z++){
		  $column_number = Coordinate::columnIndexFromString($column) + $z;
		  $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
		  $sheet->setCellValue( $column_letter.'3', 
				  WebEvaluationController::getLetter($keys[$z]));
		  $sheet->setCellValue( $column_letter.'4', $weight[$z]);
		}

		$column_number = Coordinate::columnIndexFromString($column) + $num;
		$column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
		$sheet->setCellValue($column_letter.'3', 'Total');
		$sheet->setCellValue($column_letter.'4', $exam->overall_score);

		$sheet->setCellValue('A5', 'Nombres');
		$sheet->setCellValue('B5', 'Apellidos');
		$sheet->setCellValue($column_letter.'5', 'Calificación');

		$sheet->getStyle('A3:'.$last_column.'3')->getFont()->setBold(true);
		$sheet->getStyle('A4:'.$last_column.'4')->getFont()->setBold(true);
		$sheet->getStyle('A5:'.$last_column.'5')->getFont()->setBold(true);

		$sheet->getStyle('A3:'.$last_column.'3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
		$sheet->getStyle('A4:'.$last_column.'4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
		$sheet->getStyle('A5:'.$last_column.'5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');

		$jump = 6;
		for ($q=$jump; $q<count($users)+$jump; $q++){
		  $user = $users[$q-$jump];
		  //$sheet->setCellValue('A'.$q, $user->studentid);
		  $sheet->setCellValue('A'.$q, $user->first_name);
		  $sheet->setCellValue('B'.$q, $user->last_name);
		  $sheet->setCellValue($last_column.$q, $user->score);
		  $sols = explode(",", $user->solutions);
		  $detscore = WebEvaluationController::getDetailScore($exam->id, $sols);
		  for ($z=0; $z<$num; $z++){
			$column_number = Coordinate::columnIndexFromString($column) + $z;
			$column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
			$sheet->setCellValue($column_letter.$q, $detscore[$z]);
		  }
		}
	  
	  	if ($exam->eval_type == 2){
		  $sheet->mergeCells('A'.(count($users)+$jump+2).':'.$last_column.(count($users)+$jump+2));
		  $sheet->setCellValue('A'.(count($users)+$jump+2), '[1] Hestenes, D., Wells, M., & Swackhamer, G. (Marzo de 1992). '
			. 'Force Concept Inventory. (T. P. Teacher, Ed.) Obtenido de http://www.phystec.org/items/detail.cfm?ID=2641');
		  $sheet->getStyle('A'.(count($users)+$jump+2))->getFont()->setSize(8)->setBold(true);
		  $sheet->getStyle('A'.(count($users)+$jump+2))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
		}
	  
	  return $spreadsheet;
  }
    
  public static function detailReportFCI($spreadsheet, $exam, $lesson, $users){
 
	  $sheet = $spreadsheet->getSheetByName('Estudiantes');
      $column_number = Coordinate::columnIndexFromString('A') + ($exam->number_question + 3);
      $last_column = $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
      $sheet->mergeCells('A1:'.$column_letter.'1');
      $sheet->getStyle('A1:'.$column_letter.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('54be7a');
      $sheet->getStyle('A1:'.$column_letter.'1')->getFont()->setBold(true);
      $sheet->getStyle('A1')->getAlignment()->setWrapText(true);

      $header = '';
      $header .= isset($lesson->institution)? $lesson->institution. "\n":'';
      $header .= isset($lesson->speciality)? strtoupper($lesson->speciality). "\n":'';
      //$header .= isset($lesson->course_name)? $lesson->course_name. "\n":'';
      $header .= 'Resultados del "Force Concept Inventory" - FCI [1]'."\n\n";

      $sheet->setCellValue('A1', $header);

      $sheet->mergeCells('A2:'.$column_letter.'2');
      $sheet->getStyle('A2:'.$column_letter.'2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('54be7a');
      $sheet->getStyle('A2:'.$column_letter.'2')->getFont()->setBold(true);
      $sheet->getStyle('A2')->getAlignment()->setWrapText(true);         
      //Log::info($exam->start_time);
      //Log::info($mydate);
      //$miFecha = $mydate->formatLocalized('%A %d %B de %Y');

      setlocale(LC_ALL, 'es_ES');
      //Carbon::setLocale('es');
      $mydate = DateTime::createFromFormat('Y-m-d H:i:s', $exam->date.' '.$exam->start_time);
      $header_date = $mydate->format('l j \\d\\e F \\d\\e Y'). "\n";
      $header_date.='Inicio del test '. $mydate->format('H:i \\h\\r\\s');
      $sheet->setCellValue('A2', $header_date);

      $column_number = Coordinate::columnIndexFromString('D') + ($exam->number_question - 1);
      $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
      $sheet->mergeCells('D4:'.$column_letter.'4');
      
      $sheet->setCellValue('D4', 'Alternativas correctas / respuestas obtenidas');
      $sheet->getStyle('D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
	  
		$styleArray = [
			'borders' => [
				'outline' => [
					'borderStyle' => Border::BORDER_THICK,
					'color' => ['argb' => 'FF000000'],
				],
			],
		];

	  $sheet->setCellValue('A6', 'Código universitario');
	  $sheet->getStyle('A6')->applyFromArray($styleArray);

	  $sheet->setCellValue('B6', 'Nombres');
	  $sheet->getStyle('B6')->applyFromArray($styleArray);
	  
      $sheet->setCellValue('C6', 'Apellidos');
	  $sheet->getStyle('C6')->applyFromArray($styleArray);


      $column_number = Coordinate::columnIndexFromString('C') + $exam->number_question + 1;
      $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
	  $sheet->setCellValue($column_letter.'6', 'N° de respuestas correctas');
      $sheet->getStyle($column_letter.'6')->applyFromArray($styleArray);
           
      $column = 'D';

      $keys = explode(",", $exam->answer_keys);
      for ($z=0; $z<30; $z++){
        $column_number = Coordinate::columnIndexFromString($column) + $z;
        $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
        $sheet->setCellValue($column_letter.'5', WebEvaluationController::getLetter($keys[$z]));
		$sheet->setCellValue($column_letter.'6', 'P'.($z+1));
      	$sheet->getStyle($column_letter.'6')->applyFromArray($styleArray);
      }
      
      $jump = 7;
      for ($q=$jump; $q<count($users)+$jump; $q++){
		$user = $users[$q-$jump];
		$sheet->setCellValue('A'.$q, $user->studentid);
		$sheet->getStyle('A'.$q)->applyFromArray($styleArray);

		$sheet->setCellValue('B'.$q, $user->first_name);
		$sheet->getStyle('B'.$q)->applyFromArray($styleArray);

		$sheet->setCellValue('C'.$q, $user->last_name);
		$sheet->getStyle('C'.$q)->applyFromArray($styleArray);

		$sheet->setCellValue($last_column.$q, $user->score);
		$sheet->getStyle($last_column.$q)->applyFromArray($styleArray);
           

        $sols = explode(",", $user->solutions);
        for ($z=0; $z<30; $z++){
			$column_number = Coordinate::columnIndexFromString($column) + $z;
			$column_letter = Coordinate::stringFromColumnIndex($column_number - 1);

			$sheet->setCellValue($column_letter.$q, WebEvaluationController::getLetter($sols[$z]));
			$sheet->getStyle($column_letter.$q)->applyFromArray($styleArray);
        }
      }

      $column_number = Coordinate::columnIndexFromString('A') + ($exam->number_question + 3);
      $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
      $sheet->mergeCells('A'.(count($users)+$jump+2).':'.$column_letter.(count($users)+$jump+2));
      $sheet->setCellValue('A'.(count($users)+$jump+2), '[1] Hestenes, D., Wells, M., & Swackhamer, G. (Marzo de 1992). '
        . 'Force Concept Inventory. (T. P. Teacher, Ed.) Obtenido de http://www.phystec.org/items/detail.cfm?ID=2641');
      $sheet->getStyle('A'.(count($users)+$jump+2))->getFont()->setSize(8)->setBold(true);
      $sheet->getStyle('A'.(count($users)+$jump+2))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');

      $sheet->getColumnDimension("A")->setAutoSize(true);
      $sheet->getColumnDimension("B")->setAutoSize(true);
      $sheet->getColumnDimension("C")->setAutoSize(true);

      $sheet->getStyle('A4:'.$column_letter.'4')->getFont()->setBold(true);
      $sheet->getStyle('A5:'.$column_letter.'5')->getFont()->setBold(true);
      $sheet->getStyle('A6:'.$column_letter.'6')->getFont()->setBold(true);

      $sheet->getStyle('A4:'.$column_letter.'4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
      $sheet->getStyle('A5:'.$column_letter.'5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
      $sheet->getStyle('A6:'.$column_letter.'6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
	  return $spreadsheet;
  }
    
  public static function detailReport($spreadsheet, $exam, $lesson, $users){
      
	  $sheet = $spreadsheet->getSheetByName('Estudiantes');
      $column_number = Coordinate::columnIndexFromString('A') + ($exam->number_question + 3);
      $last_column = $column_letter = Coordinate::stringFromColumnIndex($column_number - 1); 
      $sheet->mergeCells('A1:'.$column_letter.'1');
      $sheet->getStyle('A1:'.$column_letter.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('54be7a');
      $sheet->getStyle('A1:'.$column_letter.'1')->getFont()->setBold(true);
      $sheet->getStyle('A1')->getAlignment()->setWrapText(true);

      $header = '';
      $header .= isset($lesson->institution)? strtoupper($lesson->institution). "\n":'';
      $header .= isset($lesson->speciality)? strtoupper($lesson->speciality). "\n":'';
      $header .= isset($lesson->course_name)? $lesson->course_name. "\n":'';
      $header .= isset($exam->exam_title)? $exam->exam_title. "\n\n":'';

      $sheet->setCellValue('A1', $header);
      /*$sheet->cell('E3', function($cell) use ($lesson) {
        $cell->setValue(strtoupper($lesson->institution));
        $cell->setFontWeight('bold');
      });
      $sheet->setCellValue('E4', strtoupper($lesson->speciality));
      $sheet->setCellValue('E5', $lesson->course_name);
      $sheet->setCellValue('E6', $exam->exam_title);*/

      $sheet->mergeCells('A2:'.$column_letter.'2');
      $sheet->getStyle('A2:'.$column_letter.'2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('54be7a');
      $sheet->getStyle('A2:'.$column_letter.'2')->getFont()->setBold(true);
      $sheet->getStyle('A2')->getAlignment()->setWrapText(true);

      //$mydate = Carbon::createFromFormat('Y-m-d H:i:s', $exam->date.' '.$exam->start_time);

      //$sheet->setCellValue('F8', 'Inicio del test '.$mydate->format('H:i \\h\\r\\s'));

      setlocale(LC_TIME, 'Spanish');
      $mydate = DateTime::createFromFormat('Y-m-d H:i:s', $exam->date.' '.$exam->start_time);
      $header_date = $mydate->format('l j \\d\\e F \\d\\e Y'). "\n";
      $header_date.='Inicio del test '. $mydate->format('H:i \\h\\r\\s');
      $sheet->setCellValue('A2', $header_date);

      //$miFecha = $mydate->formatLocalized('%A %d %B de %Y');
      //$sheet->setCellValue('D8', utf8_encode($miFecha));
      //Log::info($miFecha);
      $sheet->getStyle('A4:'.$last_column.'4')->getFont()->setBold(true);
      $sheet->getStyle('A4:'.$last_column.'4')->getFont()->setBold(true);
      $sheet->getStyle('A5:'.$last_column.'5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
      $sheet->getStyle('A5:'.$last_column.'5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');

      $sheet->setCellValue('B5', 'Nombres');
      $sheet->setCellValue('C5', 'Apellidos');
      $sheet->setCellValue($last_column.'4', 'Calificación');
      $sheet->setCellValue($last_column.'5', $exam->overall_score);
      
      $column = 'D';
      $jump = 6;
      $keys = explode(",", $exam->answer_keys);
      $num = $exam->number_question;

      //correct answers
      for ($z=0; $z<$num; $z++){
        $column_number = Coordinate::columnIndexFromString($column) + $z;
        $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
        $sheet->setCellValue($column_letter.'4', 'R.'.($z+1));
        $sheet->setCellValue($column_letter.'5', WebEvaluationController::getLetter($keys[$z]));
      }

      //students answers
      for ($q=$jump; $q<count($users)+$jump; $q++){
        $sheet->setCellValue('A'.$q, $q-$jump+1);
        $sheet->setCellValue('B'.$q, $users[$q-$jump]->first_name);
        $sheet->setCellValue('C'.$q, $users[$q-$jump]->last_name);
        $sheet->setCellValue($last_column.$q, $users[$q-$jump]->score);
        $sols = explode(",", $users[$q-$jump]->solutions);
        for ($z=0; $z<$num; $z++){
          $column_number = Coordinate::columnIndexFromString($column) + $z;
          $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
          $sheet->setCellValue($column_letter.$q, WebEvaluationController::getLetter($sols[$z]));
        }
      }
	  return $spreadsheet;
  }
	
  public static function getLetter($num){
    $sub = '';
    switch($num){
      case 1:
        $sub = 'A';
        break;
      case 2:
        $sub = 'B';
        break;
      case 3:
        $sub = 'C';
        break;
      case 4:
        $sub = 'D';
        break;
      case 5:
        $sub = 'E';
        break;
      case 6:
        $sub = 'V';
        break;
      case 7:
        $sub = 'F';
        break;
    }
    return $sub;
  }
  
  public static function getDetailScore($eval_id, $answers){
    $exam = Evaluation::where('id',$eval_id)->first();
    $num = $exam->number_question;
    $weight = explode(",", $exam->answer_weights);
    $key = explode(",", $exam->answer_keys);
    $detscore = array();
    $score = 0.0;
    for ($x = 0; $x < $num; $x++){
      if ($answers[$x] == $key[$x]){
        $detscore[$x] = 1.0*$weight[$x];
      } else {
        $detscore[$x] = 0.0;
      }
    }
    return $detscore;
  }

  public function mailCustomEval($user_id, $custom_eval_id){
    $myrandom = WebEvaluationController::getCustomRandom($custom_eval_id-1);
    Log::info($myrandom);
    $lesson = Lesson::hasEvaluation($myrandom)->first();
    Log::info($lesson);
    if ($lesson != null){
      $exam = $lesson->evaluation()->data()->first();
      $eval = Evaluation::where('lesson_id',$lesson->id)->first();
      $eval_id = $eval->id;
      $users = array();
      $users = DB::table('profeplus_student_evaluation AS pse')
            ->select(DB::raw('pse.updated_at, pse.score, pse.solutions, pu.first_name, pu.last_name, pu.studentid'))
            ->join('profeplus_users AS pu', 'pu.id', '=', 'pse.user_id')                  
            ->where('pse.evaluation_id',$eval_id)
            ->get();
      $filename = 'Evaluacion-'.$myrandom.'.xlsx';
	  
	    $spreadsheet = new Spreadsheet();
	    $sheet = $spreadsheet->getActiveSheet();
	    $sheet->setTitle('General');

  	  $spreadsheet = WebEvaluationController::generalCustomReport($spreadsheet, $exam, $lesson, $users);
	
	    $spreadsheet->createSheet();
	    $sheet1 = $spreadsheet->getSheet(1);
      $sheet1->setTitle('Estudiantes');
      $spreadsheet = WebEvaluationController::detailCustomReport($spreadsheet, $exam, $lesson, $users);

      $localPath = public_path().'/';
      $localPathToFile = $localPath.$filename;
      $writer = new Xlsx($spreadsheet);
      $writer->save($filename);
      $reportTemplate = 'emails.informe';
      $agent = new Agent();
	    if ($agent->isMobile()) {
        $reportTemplate = 'informe';
      }
      Log::info($localPathToFile);
      $teacher = User::find(1);
      $data = array('teacher' => $teacher);
      Mail::send($reportTemplate, $data, function($message) use ($localPathToFile) {
        $message->to("herbertacg@gmail.com","Profeplus")
            ->cc("ronnie.guerra@gmail.com")
            ->subject('Evaluación ProfePLUS')
            ->attach($localPathToFile);
      });

      return Response::json(new \stdClass(), JsonResponse::HTTP_OK);
    }
  }
  
  public static function generalCustomReport($spreadsheet, $exam, $lesson, $users){
    $sheet = $spreadsheet->getSheetByName('General');
  
    $column_number = Coordinate::columnIndexFromString('A') + ($exam->number_question + 2);
    $last_column = $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
    $sheet->mergeCells('A1:'.$column_letter.'1');
    $sheet->getStyle('A1:'.$column_letter.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('54be7a');
    $sheet->getStyle('A1:'.$column_letter.'1')->getFont()->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setWrapText(true);

    $header = '';
    $header .= isset($lesson->institution)? $lesson->institution. "\n":'';
    $header .= isset($lesson->speciality)? strtoupper($lesson->speciality). "\n":'';
    $header .= isset($exam->exam_title)? $exam->exam_title. "\n":'';
    $header .= isset($lesson->course_name)? $lesson->course_name. "\n":'';
    $sheet->setCellValue('A1', $header);

    $sheet->getColumnDimension("A")->setAutoSize(true);
    $sheet->getColumnDimension("B")->setAutoSize(true);

    $sheet->setCellValue('B3', 'Respuesta correcta:');
    $sheet->setCellValue('B4', 'Puntaje asignado:');

    $keys = explode(",", $exam->answer_keys);
    $weight = explode(",", $exam->answer_weights);
    $num = $exam->number_question;

    $column = 'C';

    for ($z=0; $z<$num; $z++){
      $column_number = Coordinate::columnIndexFromString($column) + $z;
      $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
      $sheet->setCellValue( $column_letter.'3', WebEvaluationController::getLetter($keys[$z]));
      $sheet->setCellValue( $column_letter.'4', $weight[$z]);
    }

    $column_number = Coordinate::columnIndexFromString($column) + $num;
    $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
    $sheet->setCellValue($column_letter.'3', 'Total');
    $sheet->setCellValue($column_letter.'4', $exam->overall_score);

    $sheet->setCellValue('A5', 'Nombres');
    $sheet->setCellValue('B5', 'Apellidos');
    $sheet->setCellValue($column_letter.'5', 'Calificación');

    $sheet->getStyle('A3:'.$last_column.'3')->getFont()->setBold(true);
    $sheet->getStyle('A4:'.$last_column.'4')->getFont()->setBold(true);
    $sheet->getStyle('A5:'.$last_column.'5')->getFont()->setBold(true);

    $sheet->getStyle('A3:'.$last_column.'3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
    $sheet->getStyle('A4:'.$last_column.'4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
    $sheet->getStyle('A5:'.$last_column.'5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');

    $jump = 6;
    for ($q=$jump; $q<count($users)+$jump; $q++){
      $user = $users[$q-$jump];
      $sheet->setCellValue('A'.$q, $user->first_name);
      $sheet->setCellValue('B'.$q, $user->last_name);
      $sheet->setCellValue($last_column.$q, $user->score);
      $sols = explode(",", $user->solutions);
      $detscore = WebEvaluationController::getCustomDetailScore($exam->id, $sols);
      for ($z=0; $z<$num; $z++){
        $column_number = Coordinate::columnIndexFromString($column) + $z;
        $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
        $sheet->setCellValue($column_letter.$q, $detscore[$z]);
      }
    }

    return $spreadsheet;
  }

  public static function getCustomDetailScore($eval_id, $answers){
    $exam = Evaluation::where('id',$eval_id)->first();
    $num = $exam->number_question;
    $weight = explode(",", $exam->answer_weights);
    $key = explode(",", $exam->answer_keys);
    $detscore = array();
    $score = 0.0;
    for ($x = 0; $x < $num; $x++){
      if ($weight[$x] == 0){
        $detscore[$x] = 1.0;
      } else {
        if ($answers[$x] == $key[$x]){
          $detscore[$x] = 1.0*$weight[$x];
        } else {
          $detscore[$x] = 0.0;
        }
      }
    }
    return $detscore;
  }

  public static function detailCustomReport($spreadsheet, $exam, $lesson, $users){
      
	  $sheet = $spreadsheet->getSheetByName('Estudiantes');
    $column_number = Coordinate::columnIndexFromString('A') + ($exam->number_question + 4);
    $last_column = $column_letter = Coordinate::stringFromColumnIndex($column_number - 1); 
    $sheet->mergeCells('A1:'.$column_letter.'1');
    $sheet->getStyle('A1:'.$column_letter.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('54be7a');
    $sheet->getStyle('A1:'.$column_letter.'1')->getFont()->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setWrapText(true);

    $header = '';
    $header .= isset($lesson->institution)? strtoupper($lesson->institution). "\n":'';
    $header .= isset($lesson->speciality)? strtoupper($lesson->speciality). "\n":'';
    $header .= isset($lesson->course_name)? $lesson->course_name. "\n":'';
    $header .= isset($exam->exam_title)? $exam->exam_title. "\n\n":'';

    $sheet->setCellValue('A1', $header);
    $sheet->mergeCells('A2:'.$column_letter.'2');
    $sheet->getStyle('A2:'.$column_letter.'2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('54be7a');
    $sheet->getStyle('A2:'.$column_letter.'2')->getFont()->setBold(true);
    $sheet->getStyle('A2')->getAlignment()->setWrapText(true);

    setlocale(LC_TIME, 'Spanish');
    Log::info($exam);
    $mydate = DateTime::createFromFormat('Y-m-d H:i:s', $exam->start_time);
    $header_date = $mydate->format('l j \\d\\e F \\d\\e Y'). "\n";
    Log::info($header_date);
    $header_date.='Inicio del test '. $mydate->format('H:i \\h\\r\\s');
    $sheet->setCellValue('A2', $header_date);

    $sheet->getStyle('A4:'.$last_column.'4')->getFont()->setBold(true);
    $sheet->getStyle('A4:'.$last_column.'4')->getFont()->setBold(true);
    $sheet->getStyle('A5:'.$last_column.'5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');
    $sheet->getStyle('A5:'.$last_column.'5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('dddddd');

    $sheet->setCellValue('B5', 'Nombres');
    $sheet->setCellValue('C5', 'Apellidos');
    $sheet->setCellValue('D5', 'Fecha');
    $sheet->setCellValue($last_column.'4', 'Calificación');
    $sheet->setCellValue($last_column.'5', $exam->overall_score);
      
    $column = 'E';
    $jump = 6;
    $keys = explode(",", $exam->answer_keys);
    $num = $exam->number_question;

    //correct answers
    for ($z=0; $z<$num; $z++){
      $column_number = Coordinate::columnIndexFromString($column) + $z;
      $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
      $sheet->setCellValue($column_letter.'4', 'R.'.($z+1));
      $sheet->setCellValue($column_letter.'5', WebEvaluationController::getLetter($keys[$z]));
    }

    //students answers
    for ($q=$jump; $q<count($users)+$jump; $q++){
      $sheet->setCellValue('A'.$q, $q-$jump+1);
      $sheet->setCellValue('B'.$q, $users[$q-$jump]->first_name);
      $sheet->setCellValue('C'.$q, $users[$q-$jump]->last_name);
      $sheet->setCellValue('D'.$q, $users[$q-$jump]->updated_at);
      $sheet->setCellValue($last_column.$q, $users[$q-$jump]->score);
      $sols = explode(",", $users[$q-$jump]->solutions);
      for ($z=0; $z<$num; $z++){
        $column_number = Coordinate::columnIndexFromString($column) + $z;
        $column_letter = Coordinate::stringFromColumnIndex($column_number - 1);
        $sheet->setCellValue($column_letter.$q, WebEvaluationController::getLetter($sols[$z]));
      }
    }
	  return $spreadsheet;
  }

}
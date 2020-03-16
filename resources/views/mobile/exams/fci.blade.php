@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/exam.min.css')}}" rel="stylesheet" type="text/css">
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script-->
<script src="{{asset('js/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{asset('js/additional-methods.js')}}" type="text/javascript"></script>
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container">
<br/>

<div class="container frameqtn" id="step-1"><!--Start step 1-->
	
  <div class="container"><br/>
    <h6>Instrucciones para los alumnos</h6><br/>
    <ul>
      <li>Contesten todas las treinta preguntas.</li>
      <li>Si no conocen la respuesta correcta, marquen las alternativas que reflejen sus pensamientos (lo que ustedes crean).</li>
      <li>No escriban nada en el cuestionario impreso que les brindaré.</li>
      <li>Indiquen sus respuestas en su pantalla ProfePlus.</li>
      <li>La duración de esta evaluación es de 30 minutos.</li>
      <li>La evaluación es personal.</li>
      <li>Por su propio honor, no graben las pantallas de sus respuestas.</li>
      <li>Gracias por su colaboración y mucha suerte.</li>
    </ul>
  </div>

  <div class="container"><br/>
  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <button id="go-code" class="btn btn-lg btn-gopage btn-block">SIGUIENTE</button>
  </div>
  </div>

</div><!--div step 2-->


<div class="container" id="step-2" style="visibility: hidden;"><!--Start step 2-->
    
  <div class="container frameqtn">

    <!--div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <h3><div id="title"></div></h3>
      <div>{{ trans('labels.text_show_code_to_student_board') }}</div>
    </div-->
    
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <!--h5><div id="title" style="margin: auto; width:60%;"></div></h5-->
      <div class="h6" style="color:#f00;">
        Solicite a sus estudiantes que ingresen a “Evaluación calificada” 
        (botón de color naranja). Luego, indíqueles el número de 4 dígitos que aparece 
        debajo para que inicien su evaluación 
        (le recomendamos copiar en la pizarra el número de 4 dígitos).
      </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <div id="accesscode" class="accesscode-box"></div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button id="to-evalList" class="btn btn-lg btn-gopage btn-block">
        INICIAR EVALUACIÓN CALIFICADA
      </button>
      <a href="{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/1') }}" class="btn btn-lg btn-gopage-ii btn-block">
        CANCELAR
      </a>
    </div>

  </div>
	
</div><!--div step 4-->

</div><!--div container-->

<script>
$(document).ready(function(){
	
    $("#exit-icon").attr("href", "{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/1') }}");
    $("#back-icon").click(function(){
      window.history.back();
    });	

    $("#step-1").css("display","block");  
    $("#step-2").css("display","none");
    //$("#step-3").css("display","none");
		
    var nqtns = 30;
    var total = 30;
    var sameScore = true;
    var lessonId = 0;
    var duration = 37;
    var course = "Física";
    var speciality = "Física";
    var institute = "FCI";
    var examen = "FCI";
    var observation = "FCI";
    var mats = "omiso.";
    var typs = [ 1,1,1,1,1, 1,1,1,1,1, 1,1,1,1,1, 1,1,1,1,1, 1,1,1,1,1, 1,1,1,1,1 ];
    var scrs = [ 1,1,1,1,1, 1,1,1,1,1, 1,1,1,1,1, 1,1,1,1,1, 1,1,1,1,1, 1,1,1,1,1 ];
    var ans = [ 3, 1, 3, 5, 2, 2, 2, 2, 5, 1, 4, 2, 4, 4, 1, 1, 2, 2, 5, 4, 5, 2, 2, 1, 3, 5, 3, 5, 2, 3 ];
    var code = 0;

    
    /*$("#go-step2").click(function(){
      institute = $("#institute").text();
      speciality = $("#speciality").text();
      if (hasCourse()) {
        updateUI(1);
      }
    });*/

    $("#go-code").click(function(){
      prepareExam();
    });
	
    $("#to-evalList").click(function(){
      startExam();
    });
	
    function prepareExam(){
      var myExam = {
        'user_id' : {{ $user_id }},
        'number_question' : nqtns,
        'overall_score' : total,
        'duration' : 37,
        //'duration' : 1,//test
        'course_name' : "Física",
        'speciality' : "Física",
        'institution' : "FCI",
        'exam_title' : "Evaluación de Conceptos de Física (FCI)",
        'observations' : "FCI",
        'materials' : mats.toString(),
        'answer_keys' : ans.toString(),            
        'answer_weights' : scrs.toString(),
        'answer_types' : typs.toString(),
        'eval_type' : 2
      };
      $.ajax({
        type: "POST",
        url: "{{url('/web/exam/teacher')}}"+'/'+{{$user_id}}+'/new',
        dataType: "json",
        contentType : 'application/json',
        data: JSON.stringify(myExam),
        success: function(data, status) {
          lessonId = data['lesson_id'];
          code = data['code'];
          preparePageCode();
          updateUI(1);
          $("#exit-icon").hide();
          $("#back-icon").hide();
        }
      });
    }
    
    function startExam(){
      $.ajax({
        type: "POST",
        url: "{{url('/web/exam/teacher')}}"+'/'+{{$user_id}}+'/start/'+lessonId,
        contentType : 'application/json',
        success: function(data, status) {
          window.location.replace("{{ url('web/exam/teacher/'.$user_id.'/'.$mode.'/board/lesson') }}"+'/'+lessonId);
        } 
      });
    }
	
    function updateUI(page){
      //upCourse();
      //upInstitute();
      //upSpeciality();
      $("#back-icon").off();
      var pageUp = page + 1;
      $("#step-"+page).css("visibility","hidden");
      $("#step-"+pageUp).css("visibility","visible");
      $("#step-"+page).css("display","none");
      $("#step-"+pageUp).css("display","block");
      $("#back-icon").click(function(){
        $("#step-"+page).css("visibility","visible");
        $("#step-"+pageUp).css("visibility","hidden");
        $("#step-"+page).css("display","block");
        $("#step-"+pageUp).css("display","none");       
        if (page>0){
          updateUI(page-1)	
        } else {
          window.history.go(-2);
        }			
      });			
      if (page==1){
        //preparePageCode();
      }
    }
		
    function hasCourse(){
      course = $("#course").text();
      if (course != ""){
        return true;
      } else {
        return false;
      }
    }

    function preparePageCode(){
      $("#back-icon").click(function(){});
      //$("#title").html(course);
      $("#accesscode").html(code);
    }
    
    function upInstitute(){
      if (institute != ""){
        $("#institute").text(institute);
      }
    }
    
    function upSpeciality(){
      if (speciality != ""){
        $("#speciality").text(speciality);
      }
    }
    
    function upCourse(){
      if (course != ""){
        $("#course").text(course);
      }
    }
    
	
});
</script>

@stop



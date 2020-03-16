@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/exam.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>
<link href="{{asset('css/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{asset('js/toastr.min.js')}}"></script>
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container"><br/>

  <div class="container frameqtn" id="fci" style="visibility: hidden;"><!--Start FCI-->

    <div class="container"><br/>
      <h6>Instrucciones:</h6><br/>
    <ul>
      <li>Contesta todas las treinta preguntas.</li>
      <li>Si no conoces la respuesta correcta, marca la alternativa que refleje tus pensamientos (lo que creas).</li>
      <li>No escribas nada en el cuestionario impreso que te brinde el o la docente.</li>
      <li>Indica tus respuestas en la pantalla ProfePlus.</li>
      <li>La evaluación es personal.</li>
      <li>Por tu propio honor, no grabes las pantallas de tus respuestas.</li>
      <li>Gracias por tu colaboración y muchos éxitos.</li>
    </ul>
      <h6>Atentamente<br/><br/>Profeplus</h6>
    </div>

    <div class="container"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button id="go-answerSheet" class="btn btn-lg btn-gopage btn-block">INICIAR TEST FCI</button>
    </div>
    </div>

  </div><!--div FCI-->

  <div class="container" id="answerSheet" style="visibility: hidden;">
    <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <div id="sticky-anchor"></div>
      <div id="clock" class="h3 sticky" style="margin-bottom: 20px;">00:00:00</div>
      <!--div id="institution">Exámen</div>
      <div id="speciality">Exámen</div>
      <div id="course">Exámen</div>
      <div id="exam-name">Exámen</div>
      <div id="observation">Exámen</div>
      <div id="list-mats">Indicaciones Materiales</div-->
      <div id="exam-stat" class="error-msg h5">Terminado</div>
    </div>
    </div>

    <div id="ans-sheet" style="visibility: hidden;">
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
    <button id="finish-exam" class="btn btn-lg btn-gopage btn-block">
      TERMINAR
    </button>
    </div><!--end button-->
    
    <div class="col-xs-12 col-sm-12 col-md-12" style="visibility: hidden;">
    <button id="exam-exit" class="btn btn-lg btn-gopage btn-block">
      SALIR
    </button>
    </div><!--end button-->

  </div><!--end frameline-->
    
</div><!--end container-->

<div id="modal-confirm" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="text-center">
          <h5>¿DESEA TERMINAR Y ENVIAR SUS RESPUESTAS?<br/>
        </div>
        <div class="text-center">
          <button id="btn-confirm" type="button" class="btn btn-narrow h6" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-over" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <div class="text-center">
          <h5>Usted ha enviado con éxito sus respuestas.<br/>Éxitos.</h5><br/>
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-narrow h6" id="btn-go-home" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-over2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <div class="text-center">
          <h5>La evaluación ha finalizado.</h5><br/>
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-narrow h6">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-conn" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <div class="text-center">
          <h5>Se ha perdido la conexión a Internet.</h5><br/>
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-narrow h6" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.sticky {
    padding: 0.5ex;
    width: 600px;
    background-color: #74b47c;
    color: #fff;
    font-size: 2em;
    border-radius: 0.5ex;
    width: 100%;
}

.sticky.stick {
    margin-top: 0 !important;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10000;
    border-radius: 0 0 0.5em 0.5em;
}
.btn-group-wrap{
    text-align: center;
    margin: 0 auto;
    display: block;
}
</style>
<script>
$(document).ready(function(){

    function sticky_relocate() {
        var window_top = $(window).scrollTop();
        var div_top = $('#sticky-anchor').offset().top;
        if (window_top > div_top) {
            $('.sticky').addClass('stick');
            $('#sticky-anchor').height($('.sticky').outerHeight());
        } else {
            $('.sticky').removeClass('stick');
            $('#sticky-anchor').height(0);
        }
    }

    $(window).scroll(sticky_relocate);
    sticky_relocate();

    $("#back-icon").hide();
    $("#exit-icon").hide();
  
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-center",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "10000",
      "hideDuration": "1000",
    };
	
    var nqtns = 0;
    var duration = 30;
    var course = "";
    var speciality = "";
    var institute = "";
    var examen = "";
    var observation = "";
    var mats = "";
    var typs = [];
    var scrs = [];
    var answers = [];
    var endTime = 0; 
    var remain = 10800;
    var hours, seconds, minutes;
    var hasFinish = false;
    var stopClock = false;
    var eval_type = 1;
	
    var lessonId = {{$lesson_id}};
    
    $("#fci").css("display","none");
    $("#answerSheet").css("display","none");
    $("#exam-stat").css("display","none");
    $("#ans-sheet").css("display","none");
    $("#exam-exit").css("display","none");
	
    prepareAnswerSheet(lessonId);

    $("#back-icon").click(function(){
      if (!stopClock){
        sendExam(2);
      } else {
        window.history.back();
      }       
    });

    $("#exit-icon").click(function(){
      if (!stopClock){
        sendExam(2);
      } else {
        window.history.back();
      }
    });
    
    $("#exam-exit").click(function(){
      window.history.back();
    });

    $("#btn-go-home").click(function(){
      window.location.href = "{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/0') }}";
    });	
	
    $("#btn-confirm").click(function(){
      $("#modal-confirm").modal("hide");
      if (remain >= 0 && !stopClock){
        window.onbeforeunload = null;
        $("#exam-stat").css("display","block");
        stopClock = true;
        sendExam(1);
      } else {
        $("#modal-over2").modal("show");
      }   
    });
    
    $("#finish-exam").click(function(){
       $("#modal-confirm").modal("show");
    });
    
    
    $("#go-answerSheet").click(function(){
      $("#fci").css("visibility","hidden");
      $("#answerSheet").css("visibility","visible");
      $("#fci").css("display","none");
      $("#answerSheet").css("display","block");

      window.onbeforeunload = function() {
        return 'You have not yet saved your work.Do you want to continue? Doing so, may cause loss of your work' ;
      }
    });
	
    function sendExam(opt){
      console.log(answers);
      var baseUrl = "{{url('/web/exam/student')}}";
      var gotoExam = '/'+{{$user_id}}+'/eval/send/'+{{$eval_id}};
      var mySolution = {
        'answers' : answers,
        'status' : opt
      };
      $.ajax({
        type: "POST",
        url: baseUrl + gotoExam,
        dataType: "json",
        contentType : 'application/json',
        data: JSON.stringify(mySolution),
        success: function(data, status) {
          if (opt==2){
            //window.history.go(-2);
          } else {
            $("#modal-over").modal("show");
          }
        } 
      });
    }
	
    function prepareAnswerSheet(lessonId){
      $.ajax({
        type: "GET",
        url: "{{url('/web/exam/lesson')}}"+'/'+lessonId,
        contentType : 'application/json',
        success: function(data, status) {
          nqtns = data.exam['questions'];
          mats = data.exam['materials'];
          typs = data.exam['types'].split(",");
          scrs = data.exam['weights'].split(",");
          eval = data.exam['eval_type'];
          examen = data.exam['exam_title'];
          course = data.lesson['course_name'];
          institution = data.lesson['institution'];
          speciality = data.lesson['speciality'];
          observation = data.lesson['observations'];
          if ( course != "" ){
            $("#course").html(course);
          } else {
            $("#course").remove();
          }
          if ( institution != "" ){
            $("#institution").html(institution);
          } else {
            $("#institution").remove();
          }
          if ( speciality != "" ){
            $("#speciality").html(speciality);
          } else {
            $("#speciality").remove();
          }
          if ( observation != "" ){
            $("#observation").html("Información adicional: "+observation);
          } else {
            $("#observation").html("Preste atención a las indicaciones del docente");
          }
          $("#exam-name").html(examen);
          if (mats !="") {
            $("#list-mats").html("Puede usarse: " + mats);
          } else {
            $("#list-mats").remove();
          }
          if (eval == 2){
            $("#fci").css("visibility","visible");
            $("#answerSheet").css("visibility","hidden");
            $("#fci").css("display","block");
            $("#answerSheet").css("display","none");
            eval_type = 2;
          } else {
            $("#fci").css("visibility","hidden");
            $("#answerSheet").css("visibility","visible");
            $("#fci").css("display","none");
            $("#answerSheet").css("display","block");
          }
          startTime = Date.now();
          endTime = Date.parse(data.exam['date'].replace(/-/g,'/') + ' ' + data.exam['end_time']+' GMT-0500');
          startCountdown();
          //loadAnswerSheet();
          prepareSolutions();
        } 
      });
    }
	
    function prepareSolutions(){
      var baseUrl = "{{url('/web/exam/eval')}}";
      var forSave = '/'+{{$eval_id}}+'/student/'+{{$user_id}};
      $.ajax({
        type: "GET",
        url: baseUrl + forSave,
        contentType : 'application/json',
        success: function(data, status) {
          answers = data['solutions'].split(",");
          loadAnswerSheet();
          saveQuestions();
        } 
      });
    }

    function saveQuestions(){
      $("label.btn.btn-answer").click(function(){
        btn = $(this);
        if (navigator.onLine){
          window.onbeforeunload = null;
          sendExam(2);
          window.onbeforeunload = function() {
            return 'You have not yet saved your work.Do you want to continue? Doing so, may cause loss of your work' ;
          }
        } else{
          $("#modal-conn").modal("show");
          $('#modal-conn').on('hidden.bs.modal', function () {
            btn.removeClass('active');
          })
        }
      });
    }
	
    function loadAnswerSheet(){
      $("#ans-sheet").css("visibility","visible");
      $("#ans-sheet").css("display","block");
      for (i=0; i<nqtns; i++){
        var myhtml = "";
        if (typs[i]==1){
          myhtml = addNormalQuestion(i, parseFloat(scrs[i]));
        } else {
          myhtml = addTrueQuestion(i, parseFloat(scrs[i]));
        }
        $("#ans-sheet").append(myhtml);
      }
      loadAnswers();
      saveNormalAnswers();
    }
	
    function loadAnswers(){	
      console.log('hi');
      for (i=0; i<nqtns; i++){
        if (typs[i]==2){
          if (answers[i] == 6){
            $('label[for="true'+i+'"]').addClass("active");
          }
          if (answers[i] == 7){
            $("#false"+i).parent().addClass("active");
          }
        } else {
          if (answers[i] == 5){
            $("#ansE"+i).parent().addClass("active");
          }
          if (answers[i] == 4){
            $("#ansD"+i).parent().addClass("active");
          }
          if (answers[i] == 3){
            $("#ansC"+i).parent().addClass("active");
          }
          if (answers[i] == 2){
            $("#ansB"+i).parent().addClass("active");
          }
          if (answers[i] == 1){
            $("#ansA"+i).parent().addClass("active");
            //$('label[for="ansA'+i+'"]').addClass("active");
          }						
        }
      }
    }
	
    function saveNormalAnswers(){
      for (i=0; i<nqtns; i++){
        if (typs[i]==2){
          $("#true"+i).parent().click(function(){
            if (navigator.onLine){
              answers[$(this).find('input').attr('name')]= "6";
              //alert(answers);
            }
          });
          $("#false"+i).parent().click(function(){
            if (navigator.onLine){
              answers[$(this).find('input').attr('name')]= "7";
              //alert(answers);
            }
          });
        } else {
          $("#ansA"+i).parent().click(function(){
            if (navigator.onLine){
              answers[$(this).find('input').attr('name')]= "1";
              //alert(answers);
            }
          });
          $("#ansB"+i).parent().click(function(){
            if (navigator.onLine){
              answers[$(this).find('input').attr('name')]= "2";
              //alert(answers);
            }
          });
          $("#ansC"+i).parent().click(function(){
            if (navigator.onLine){
              answers[$(this).find('input').attr('name')]= "3";
              //alert(answers);
            }
          });
          $("#ansD"+i).parent().click(function(){
            if (navigator.onLine){
              answers[$(this).find('input').attr('name')]= "4";
              //alert(answers);
            }
          });
          $("#ansE"+i).parent().click(function(){
            if (navigator.onLine){
              answers[$(this).find('input').attr('name')]= "5";
              //alert(answers);
            }
          });				
        }
      }
    }

    function addTrueQuestion(num,score){
      var template = '<div class="container frameqtn">'+
          '<div class="col-xs-12 col-sm-12 col-md-12">'+
          '<div class="framenumber">JJJ</div>'+
          '<div class="btn-group btn-group-lg" data-toggle="buttons">'+
          '<label class="btn btn-answer" for="trueZZZ">'+
          '<input type="radio" name="ZZZ" id="trueZZZ" autocomplete="off">V</label>'+
          '<label class="btn btn-answer" for="falseZZZ">'+
          '<input type="radio" name="ZZZ" id="falseZZZ" autocomplete="off">F</label>'+
          '</div></div>'+
          '<div class="col-xs-12 col-sm-12 col-md-12 text-right">Puntaje: QQQ'+
          '</div></div><br/>';
      var res = template.replace(/ZZZ/g, num);
      var res1 = res.replace(/JJJ/g, num+1);
      return res1.replace(/QQQ/g, score.toFixed(1));
    }
	
    function addNormalQuestion(num, score){
      var template = '<div class="container frameqtn">'+
          '<div class="col-xs-12 col-sm-12 col-md-12">'+
          '<div class="col-xs-1 col-sm-1 col-md-1"><div class="framenumber">JJJ</div></div>'+
          '<div class="col-xs-11 col-sm-11col-md-11">'+
          '<div class="btn-group-wrap">'+
          '<div class="btn-group btn-group-lg" data-toggle="buttons">'+
          '<label class="btn btn-answer" for="ansAZZZ">'+
          '<input type="radio" name="ZZZ" id="ansAZZZ" autocomplete="off">A</label>'+
          '<label class="btn btn-answer" for="ansBZZZ">'+
          '<input type="radio" name="ZZZ" id="ansBZZZ" autocomplete="off">B</label>'+
          '<label class="btn btn-answer" for="ansCZZZ">'+
          '<input type="radio" name="ZZZ" id="ansCZZZ" autocomplete="off">C</label>'+
          '<label class="btn btn-answer" for="ansDZZZ">'+
          '<input type="radio" name="ZZZ" id="ansDZZZ" autocomplete="off">D</label>'+
          '<label class="btn btn-answer" for="ansEZZZ">'+
          '<input type="radio" name="ZZZ" id="ansEZZZ" autocomplete="off">E</label>'+
          '</div></div></div></div>';

        if (eval_type =! 2 ){
          template += '<div class="col-xs-12 col-sm-12 col-md-12 text-right puntaje">Puntaje: QQQ</div>';
        }
         template += '</div><br/>';
      var res = template.replace(/ZZZ/g, num);
      var res1 = res.replace(/JJJ/g, num+1);
      return res1.replace(/QQQ/g, score.toFixed(1));
    }
    
    function startCountdown(){
      finishedByTeacher = false;
      var myInterval = setInterval(function() {

        if (!finishedByTeacher){
          $.ajax({
            type: "GET",
            url: "{{url('/web/exam/lesson/')}}"+'/'+lessonId+'/status',
            contentType : 'application/json',
            success: function(data, status) {
              if (data.status == 1){ //DISABLED
                finishedByTeacher = true;
                remain = -1;
                endTime = 0;
                stopClock = false;
                hasFinish = false;
              }
            }
          });
        }

        if (endTime > 0){
          //console.log(endTime);
          remain = (endTime - Date.now())/1000;
        }      
        if (stopClock) {
          $("#clock").html("00 : 00 : 00");
          $("#ans-sheet").css("visibility","hidden");
          $("#ans-sheet").css("display","none");
          $("#finish-exam").css("visibility","hidden");
          $("#finish-exam").css("display","none");
          $("#exam-exit").css("visibility","visible");
          $("#exam-exit").css("display","block");
        } else if (remain < 0 && !hasFinish){
          window.onbeforeunload = null;
          clearInterval(myInterval);
          $("#clock").html("00 : 00 : 00");
          $("#exam-stat").css("display","block");
          $("#finish-exam").css("visibility","hidden");
          $("#finish-exam").css("display","none");
          $("#exam-exit").css("visibility","visible");
          $("#exam-exit").css("display","block");
          stopClock = true;
          hasFinish = true;
          sendExam(1);
          $("#modal-over").modal("show");
        } else if (remain > 0) {
          hours = Math.floor(remain / 3600.);
          minutes = Math.floor((remain % 3600) / 60.);
          seconds = (remain % 3600) % 60;
          var hh =  ('0' + hours.toFixed(0)).slice(-2);
          var mm =  ('0' + minutes.toFixed(0)).slice(-2);
          var ss =  ('0' + seconds.toFixed(0)).slice(-2);
          $("#clock").html(hh+" : "+mm+" : "+ss);
          if ( Math.floor(remain) == 5*60){
            toastr["info"]("Faltan 5 minutos para finalizar la evaluación.")
          }
        }
      }, 1000);
    }
	
});
</script>

@stop



@extends('layouts.layout01')

@section('header')
<meta http-equiv="cache-control" content="no-cache" />
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/exam.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script> 
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container">
<br/>

<div class="container frameqtn">

  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <div id="title" class="h5"></div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <div id="accesscode" class="accesscode-box2 h2 color-title shadow-title"></div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <div id="myTimer">
      <div class="h5">Tiempo Restante</div>
      <div id="clock" class="h3 color-title shadow-title"> - </div>
    </div>
    <div id="exam-stat" class="error-msg h5">Terminado</div>
  </div>
  
  

  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <div class="h5">Número de Conectados</div>
    <div id="connected" class="h3 color-title shadow-title"></div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <div class="h5">Pruebas Finalizadas</div>
    <div id="done" class="h3 color-title shadow-title">0</div>
  </div>

  <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button id="finish" class="btn btn-lg btn-gopage btn-block">TERMINAR AHORA</button>
    </div>
  </div>

  <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <a href="{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/1') }}" id="go-home" class="btn btn-lg btn-gopage btn-block">
        IR A PANTALLA PRINCIPAL
      </a>
    </div>
  </div>
	

</div><!--div step 2-->

</div>

<div id="modal-alert" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <div id="okProcess" class="text-center">
          <h5>Preparando su informe...</h5><br/>
        </div>
        <div id="okMail" class="text-center">
          <h5>Recibirá su informe en breve.</h5><br/>
        </div>
        <div id="okModal" class="text-center">
          <button type="button" class="btn btn-narrow h6" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    var cardLabel = "";
    var evalType = 1;
    var lessonId = {{$lessonId}};
    var examView = null;
    var endTime = "";
    var remain = "";
    var hours, seconds, minutes;
    var hasFinish = false;
    var interval = null;
    
    prepareExamItem(lessonId);
    updateConnections();
    if (!hasFinish) {
      startCountdown();
    } else {
      sendEmail();
    }

    $("#exit-icon").hide();
    $("#back-icon").hide();
        
    $("#finish").css("display","block");
    //$("#email").css("display","none");
    $("#go-home").css("display","none");
    $("#update").css("display","none");
    $("#exam-stat").css("display","none");
    
    /*$("#email").click(function(){
      sendEmail();
    });*/
    
    /*$("#update").click(function(){
      prepareExamItem(lessonId);
    });*/
      
    $("#finish").click(function(){
      finishExam(lessonId);
    });
    
    function sendEmail(){
      $("#modal-alert").modal("show");
      $("#okProcess").css("display","block");
      $("#okMail").css("display","none");
      $("#okModal").css("display","none");
      $.ajax({
        type: "GET",
        url: "{{ url('web/exam/email/'.$user_id.'/eval') }}"+'/'+examView.id,
        dataType: "json",
        success: function(data, status){
          prepareExamItem(lessonId);
          $("#okProcess").css("display","none");
          $("#okMail").css("display","block");
          $("#okModal").css("display","block");
        }
      });
    }

    function finishExam(lessonId){
      $.ajax({
        type: "POST",
        url: "{{url('/web/exam/teacher')}}"+'/'+{{$user_id}}+'/remove/'+lessonId,
        contentType : 'application/json',
        beforeSend: function( xhr ) {
          clearInterval(interval);
        },
        success: function(data, status) {
          examView.status = 1;
          sendEmail();
          //window.location.href = "{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/1') }}";
        } 
      });
    }

    function updateUI(){
      evalType = examView.type;
      endTime = Date.parse(examView.date.replace(/-/g,'/') + ' ' +examView.time+' GMT-0500');
      if (examView.status == 1){
        hasFinish = true;
        $("#myTimer").css("display","none");
        //$("#email").css("display","block");
        $("#go-home").css("display","block");
        $("#exam-stat").css("display","block");
        $("#finish").css("display","none");
        $("#update").css("display","none");
      } else {
        $("#myTimer").css("display","block");
        //$("#email").css("display","none");
        $("#go-home").css("display","none");
        $("#exam-stat").css("display","none");
        $("#finish").css("display","block");
        $("#update").css("display","block");
      }
      /*$("#back-icon").off();
      $("#back-icon").click(function(){   
          window.history.go(-1);
      });*/
      $("#title").html(examView.course_name);
      if (evalType == 2){
        $("#title").html("Evaluación FCI");
      }       
      $("#accesscode").html(examView.accesscode);
      $("#connected").html(examView.inlesson);
      $("#done").html(examView.finished);
      //$("#step-2").css("visibility","visible");
      //$("#step-2").css("display","block");
      //startCountdown();
    }

    function prepareExamItem(lessonId){
      $.ajax({
        type: "GET",
        url: "{{url('/web/exam/teacher')}}"+'/'+{{$user_id}}+'/show/full/'+lessonId,
        contentType : 'application/json',
        success: function(data, status) {
          examView = data;
          updateUI();
        } 
      });
    }
    
    function startCountdown(){
      setInterval(function() {
        remain = (endTime - Date.now())/1000;
        if (remain < 0 && !hasFinish){
          $("#clock").html("");
          $("#update").css("display","none");
          //$("#email").css("display","block");
          $("#go-home").css("display","block");
          $("#myTimer").css("display","none");
          $("#exam-stat").css("display","block");
          $("#finish").css("display","none");
          sendEmail();
          hasFinish = true;
          clearInterval(interval);
        } else if (remain > 0) {
          $("#update").css("display","block");
          hours = Math.floor(remain / 3600.);
          minutes = Math.floor((remain % 3600) / 60.);
          seconds = (remain % 3600) % 60;
          var hh =  hours.toFixed(0).slice(-2);
          var mm =  minutes.toFixed(0).slice(-2);
          var ss =  seconds.toFixed(0).slice(-2);

          var currentTime = '';
          if (hh>0){
            currentTime += hh + 'h ';
          }
          if (mm>0){
            currentTime += mm + 'm ';
          }
          if (ss>0){
            currentTime += ss + 's ';
          }

          //$("#clock").html(hh+" : "+mm+" : "+ss);
          $("#clock").html(currentTime);
        }
      }, 1000);
    }

    function updateConnections(){
      interval = setInterval(function() {
        prepareExamItem(lessonId);
      }, 10000);
    }

		
});
</script>


@stop



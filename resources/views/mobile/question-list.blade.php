@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('js/js.cookie.js')}}"></script>
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="full">
<div class="container wrapper">

  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <button id="simple" class="btn btn-lg btn-green btn-block">
      @lang('labels.text_five_alternatives')
    </button>
  </div>
	
  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <button id="binary" class="btn btn-lg btn-green btn-block">
      @lang('labels.text_false_or_true')
    </button>
  </div>

  <!--div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <a href="{{ url('/web/exercise/'.$userid.'/'.$mode.'/'.$code) }}"  
      class="btn btn-lg btn-green btn-block">
    @lang('labels.text_from_databank')
    </a>
  </div-->
	
  <div class="col-xs-12 col-sm-12 col-md-12 text-center" id ="opinion-box">
    <a href="{{ url('/web/survey/'.$userid.'/'.$mode.'/'.$code) }}"  
      class="btn btn-lg btn-green btn-block">
    @lang('labels.text_get_opinion')
    </a>
  </div>
    
  <div class="col-xs-12 col-sm-12 col-md-12 text-center" id ="exam-box">
    <a href="{{ url('/web/exam/teacher/'.$userid.'/'.$mode) }}"  
      class="btn btn-lg btn-green btn-block">
    Evaluación calificada
    </a>
  </div>
	
</div>
</div>

<div id="modal-answer" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="text-center"><br/><br/>
        ¿Es la misma clase?
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-dialog" id="dlg-send">Sí</button>
          <br/>
          <button type="button" class="btn btn-dialog" id="dlg-cancel">No</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
    $("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
	
    var user = {{$userid}};
    var mode = {{$mode}};
    var lessonid = "0";
    var code = "{{$code}}";
    if (mode == 2){
      $("#opinion-box").css("display","none");
    }

    var nextUrl1, nextUrl2, sub, exr, qst, svy;
    var keepCode = Cookies.getJSON('keepCode');
    var d = new Date();
    var start = keepCode['startTime'];
    var elapsed = (d.getTime()-start)/(60*1000);
    var isZero = (code == "0000");
	

    $("#simple").click(function(){
      sub = 0;
      exr = 0;
      qst = 1;
      svy = 1;
      sameCode();	
    });

    $("#binary").click(function(){
      sub = 0;
      exr = 0;
      qst = 3;
      svy = 1;
      sameCode();	
    });
	
	
    function sameCode(){
      var idxTime = keepCode['idxTime'];
      if (isZero) {
      keepCode['idxTime']=1;
      Cookies.set('keepCode', JSON.stringify(keepCode));
      goToNextUrl();
      } else  if (elapsed > 120 && !isZero){
        keepCode['idxTime']=1;
        keepCode['startTime']=d.getTime();
        keepCode['code']='0000';
        goToNextUrl();
      } else {
        $("#modal-answer").modal("show");
        //getCode();
      }
    };
	
    $("#dlg-send").click(function(){
      $("#modal-answer").modal("hide");
      keepCode['idxTime']=2;
      Cookies.set('keepCode', JSON.stringify(keepCode));
      getCode();
    });
	
    $("#dlg-cancel").click(function(){
      $("#modal-answer").modal("hide");
      keepCode['startTime']=d.getTime();
      keepCode['code']='0000';
      Cookies.set('keepCode', JSON.stringify(keepCode));
      goToNextUrl();
    })
	
	
    function getCode(){
      var vardata = {
        course_id : -1,
        evaluation_id: 0,
        accesscode: code,
        subject : sub,
        exercise : exr,
        inactive: 0,
        app_mode: mode,
        run: 1,
        survey: svy,
        question_type: qst,
        question_mode: 0
      };
      $.ajax({
        type: "POST",
        url: "{{ url('web/code/'.$userid) }}",
        dataType: "json",
        contentType : 'application/json',
        data: JSON.stringify(vardata),
        success: function(data, status) {
          lessonid = data['id'];
          var run = data['run'];
          code = data['accesscode'];
          var forQtn = '/'+qst+'/1/'+svy+'/'+exr+'/'+sub;
          var forUserLesson = '/'+code+'/'+lessonid+'/'+user+'/'+mode;
          myurl = "{{url('/web/result/1/')}}" + forQtn + forUserLesson;
          window.location.replace(myurl);					
        }
      });
    }
	
    function goToNextUrl(){
      var forUserLesson = '/0000/'+lessonid+'/'+user+'/'+mode;
      if (qst==1){
        nextUrl1 = "{{url('/web/session/1/1/0/0/')}}" + forUserLesson;
      } else if (qst==3){
        nextUrl1 = "{{url('/web/session/3/1/0/0/')}}" + forUserLesson;
      }
      window.location.replace(nextUrl1);
    }
	
});
</script>





@stop



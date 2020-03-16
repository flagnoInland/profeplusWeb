@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>
@stop

@section('content')
@include('toolbars.toolbar-3btn')


<div class="full">
<div class="container ">

  <div class="row wrapper">

  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    <h4>{{$welcome}}</h4>

    <p>@lang('labels.msg_type_code_teacher_shows')</p>
    <div class="form-group-lg text-center" id="code-box">
      <input type="text" name="code" id="code" class="form-control text-center" maxlength="4"/>
    </div>

    <!--div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" class="btn btn-lg-2 btn-base btn-block">
          @lang('labels.btn_enter_class')
      </button>
    </div-->

    <br>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <a href="{{ url('/web/student-manual-list/'.$userid.'/2/0000') }}" class="btn btn-lg-2 btn-base btn-block">
        @lang('labels.text_use_manual')
      </a>
    </div>

    <!--div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <a href="{{ url('/web/exam/student/'.$userid.'/2') }}" class="btn btn-lg-2 btn-orange btn-block">
      Evaluación calificada
      </a>
    </div-->
				
  </div>
	</div>
</div>
</div>

<div id="modal-fail" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="text-center">
          <br/>
          Número&nbsp;equivocado&nbsp;o<br/>su&nbsp;lección&nbsp;ha&nbsp;finalizado.
          <br/><br/>
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-narrow" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script> 
$(document).ready(function(){
    
    window.onload = function() { 
      $("#code").val(""); 
    };
    
    $("#back-icon").attr("href", "javascript:void(0)");
    $("#exit-icon").attr("href", "javascript:void(0)");
    
    $("#info-icon").attr("href", "{{ url('/web/info-list/'.$userid.'/2/0/0000') }}");
    $("#mode-icon").attr("href", "{{ url('/web/user/'.$userid) }}");
    $("#profile-icon").attr("href", "{{ url('/web/update/'.$userid.'/2/0/0000') }}");
    
    $("#exit-icon").click(function(){
      window.location.replace("{{ url('/') }}");
    });
    $("#back-icon").click(function(){
      window.location.replace("{{ url('/web/login/2/0') }}");
    });
    var studentData = {
      'id' : {{$userid}},
      'share': 0
    };

    Cookies.set('studentData', JSON.stringify(studentData));
    
    var accesscode; 
    
    $("#code").keyup(function(){
      accesscode = $(this).val();
      var ptn = new RegExp("[0-9][0-9][0-9][0-9]");
      if ( ptn.test(accesscode) ){
        $(".code-error").remove();
        takeQuestion();
      } else {
        $(".code-error").remove();
        $("#code").parent().append('<div class="code-error error-msg h6">Ingrese un número</div>');
        $("#code-box").addClass("has-error");
      }
    });
    
    function takeQuestion(){
      $.ajax({ 
        type: "GET", 
        url: "{{url('/web/student/')}}"+'/'+{{$userid}}+'/'+{{$userid}}+'/'+accesscode+'/Z/2', 
        dataType: 'json', 
        success: function(data, status) { 
          type = data['eval_type'];
          if (type == 1 || type == 2){
            var evalId = data['id'];
            var lessonId = data['lesson_id'];
            url = ("{{url('/web/exam/student/')}}"+'/'+{{$userid}}+'/'+{{$mode}}+'/lesson/'+lessonId+'/eval/'+evalId);
            console.log (url);
            window.location.href = url;
          } else if (type == 3) {
            var evalId = data['id'];
            var lessonId = data['lesson_id'];
            url = ("{{url('/web/exam/student/')}}"+'/'+{{$userid}}+'/'+{{$mode}}+'/lesson/'+lessonId+'/custom/eval/'+evalId);
            console.log (url);
            window.location.href = url;
          } else {
            var type = data['question_type']; 
            var run = data['run']; 
            var lessonid = data['id']; 
            var survey = data['survey']; 
            var check = data['check']; 
            var last = data['last_answer'];
            var forUserLesson = '/'+{{$userid}}+'/'+accesscode+'/'+lessonid;
            var forQtn = '/' +type+'/'+survey+'/'+check+'/2';
            window.location.href = "{{url('/web/answer-board/')}}"
                    + forUserLesson + forQtn; 
          }
        }, 
        statusCode: { 
          404: function() { 
            $("#modal-fail").modal("show"); 
          } 
        } 
      }); 
    }
    
});

</script>

@stop



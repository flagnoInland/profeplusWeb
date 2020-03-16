@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/exam.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="full container">
<br/>
<div class="wrapper container frameline">
  <br/><br/>

  <div class="col-xs-12 col-sm-12 col-md-12 text-center">
  <p>Bienvenido a la evaluación calificada.<br/>
    En esta sección se conocerá tu respuesta individual.<br/>
    Por favor, ingresa el número que te indicará el profesor.</p>
  <div class="form-group-xlg text-center" id="code-box">
  <input type="text" name="code" id="code" class="form-control text-center h2" maxlength="4"/>
  </div>
  <br/>
  <!--button id="takeExam" class="btn btn-lg btn-gopage btn-block">COMENZAR</button-->
  <br/>
  <br/>
  </div><!--end grid-->

</div><!--end frameline-->
</div><!--end container-->

<div id="modal-fail" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="text-center">
        <br/>
        Código&nbsp;equivocado&nbsp;o<br/>su&nbsp;evaluación&nbsp;ha&nbsp;finalizado.
        <br/><br/>
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-narrow h6" data-dismiss="modal">Aceptar</button>
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
    
    window.onunload = function(){}; 
    var evalId, lessonId, accesscode;
    var isNumber = false;
	
    $("#exit-icon").attr("href", "{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/0') }}");
    $("#back-icon").attr("href", "{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/0') }}");
    
    $("#takeExam").click(function(){
      if (isNumber){
        takeExam();
      }
    });
    
    $("#code").keyup(function(){
      accesscode = $(this).val();
      var ptn = new RegExp("[0-9][0-9][0-9][0-9]");
      if ( ptn.test(accesscode) ){
        $(".code-error").remove();
        isNumber = true;
        takeExam();
      } else {
        $(".code-error").remove();
        $("#code").parent().append('<div class="code-error error-msg h6">Ingrese un número</div>');
        $("#code-box").addClass("has-error");
      }
    });
    
    function takeExam(){
      $.ajax({
        type: "GET",
        url: "{{url('/web/exam/student/')}}"+'/'+{{$user_id}}+'/code/'+accesscode,
        contentType : 'application/json',
        success: function(data, status) {
          evalId = data['id'];
          lessonId = data['lesson_id'];
          window.location.href="{{url('/web/exam/student/')}}"+'/'+{{$user_id}}+'/'+{{$mode}}+'/lesson/'+lessonId+'/eval/'+evalId;
        },
        error: function(data, status){
          $("#modal-fail").modal("show");
        }
      });
    }

});
</script>

@stop



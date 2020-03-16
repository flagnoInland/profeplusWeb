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

	<div class="container form-group-lg">
	<div class="col-xs-12 col-sm-12 col-md-12 text-center h6">
	PAGINA DE PRUEBA<br/>(SOLO DESARROLLADORES)<br/><br/>
	Ingrese su correo electrónico</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<input type="text" name="email" id="email" 
			   class="form-control text-center" />
	</div>
	</div>
	
	<div class="container">
	<br/>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="teacher" class="btn btn-tiny btn-gopage btn-block h6">
		COMO PROFESOR
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="student" class="btn btn-tiny btn-gopage-ii btn-block h6">
		COMO ESTUDIANTE
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="report" class="btn btn-tiny btn-gopage-ii btn-block h6">
		EMAIL TO ADMIN
		</button>
	</div>
	
	
	</div>

</div><!--div step 1-->


</div><!--div container-->

<script>
$(document).ready(function(){
	
	
	$("#report").click(function(){
		$.ajax({
			type: "GET",
			url: "{{url('/web/exam/email/1/eval/1')}}",
			success: function(data, status) {
				alert("El correo fue enviado");
			} 
		});
	});
	
	$("#teacher").click(function(){
		$.ajax({
			type: "GET",
			url: "{{url('/web/exam/testLogin')}}"+'?email='+$("#email").val(),
			contentType : 'application/json',
			success: function(data, status) {
				var id = data['id'];
				window.location.href = "{{url('/web/exam/teacher')}}"+'/'+id+'/1';
			} 
		});
	});
	
	$("#student").click(function(){
		$.ajax({
			type: "GET",
			url: "{{url('/web/exam/testLogin')}}"+'?email='+$("#email").val(),
			contentType : 'application/json',
			success: function(data, status) {
				var id = data['id'];
				window.location.href = "{{url('/web/exam/student')}}"+'/'+id+'/1';
			} 
		});
	});	
	
});
</script>

@stop



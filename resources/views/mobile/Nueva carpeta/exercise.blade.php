@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script> 
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container full">

	<form id="exerciseForm">
	<br/>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
	<br/>
		<p>@lang('labels.text_topic_number')</p>
		<div id="tema-box">
		<img src="{{asset('images/icono_t.png')}}" class="img-ex" />
		<input type="text" name="tema" id="tema" 
			   class="form-group-ex text-center"
			   maxlength="2"/>
		</div>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
	<br/>
		<p>@lang('labels.text_exercise_number')</p>
		<div id="ejercicio-box">
		<img src="{{asset('images/icono_e.png')}}" class="img-ex" />
		<input type="text" name="ejercicio" id="ejercicio" 
			   class="form-group-ex text-center"
			   maxlength="2"/>
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
	<br/>
		<p>@lang('labels.text_bank_allow_better_reports')</p>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button type="submit" class="btn btn-lg btn-narrow btn-block">
			@lang('labels.text_next')
		</button>
	</div>
	
	</form>
	

</div>

<script> jQuery.validator.addMethod("greaterThan", function(value, element) { return value > 0; }, "Ingrese un número mayor que cero."); $(document).ready(function(){ $('#exerciseForm').validate({ submitHandler: function(form) { var user = {{$userid}}; var mode = {{$mode}}; var sub = $("#tema").val(); var exe = $("#ejercicio").val(); var vardata = { course_id : -1, evaluation_id: 0, accesscode: '0000', subject : sub, exercise : exe, inactive: 0, app_mode: mode, run: 1, survey: 1, question_type: 2, question_mode: 0 }; $.ajax({ type: "POST", url: "{{ url('web/code/'.$userid) }}", dataType: "json", contentType : 'application/json', data: JSON.stringify(vardata), success: function(data, status) { var lessonid = data['id']; var run = data['run']; var code = data['accesscode']; window.location.replace("{{url('/web/session/2/1/')}}"+'/'+exe+'/'+sub+'/'+code+'/'+lessonid+'/'+user+'/'+mode); } }); }, rules: { tema: { required: true, digits: true, greaterThan: true }, ejercicio: { required: true, digits: true, greaterThan: true } }, messages: { tema: { required: "Ingrese el tema", digits: "Solo números" }, ejercicio: { required: "Ingrese el ejercicio", digits: "Solo números" }, }, errorClass: "has-error", highlight: function(element, errorClass) { $(element.form).find("div[id=" + element.id + "-box]").addClass(errorClass); }, }); }); </script> 


<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/questions/'.$userid.'/'.$mode) }}");
	$("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/1') }}");
});
</script>

@stop



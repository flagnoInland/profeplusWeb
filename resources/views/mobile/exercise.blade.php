@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script>
<script src="{{asset('js/js.cookie.js')}}"></script> 
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="full">
<div class="container wrapper">

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
</div>

<div id="modal-answer" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
			<br/><br/>
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
jQuery.validator.addMethod("greaterThan", function(value, element) {
	return value > 0;
	}, "Ingrese un número mayor que cero.");
$(document).ready(function(){
	
	var user = {{$userid}};
	var mode = {{$mode}};
	var lessonid = "0";
	var code = "{{$code}}";
	
	var nextUrl1, nextUrl2, sub, exr, qst, svy;
	var keepCode = Cookies.getJSON('keepCode');
	var d = new Date();
	var start = keepCode['startTime'];
	var elapsed = (d.getTime()-start)/(60*1000);
	var isZero = (code == "0000");
	
$('#exerciseForm').validate({
    submitHandler: function(form) {
		sub = $("#tema").val();
		exr = $("#ejercicio").val();
		sameCode();	
    },
    rules: {
        tema: {
            required: true,
            digits: true,
			greaterThan: true
        },
		ejercicio: {
            required: true,
            digits: true,
			greaterThan: true
        }
    },
    messages: {
        tema: {
            required: "Ingrese el tema",
			digits: "Solo números"
        },
		ejercicio: {
            required: "Ingrese el ejercicio",
			digits: "Solo números"
        },
    },
    errorClass: "has-error",
    highlight: function(element, errorClass) {
        $(element.form).find("div[id=" + element.id + "-box]").addClass(errorClass);
    },
});

	function sameCode(){
		var idxTime = keepCode['idxTime'];
		if (isZero) {
            keepCode['idxTime']=1;
			Cookies.set('keepCode', JSON.stringify(keepCode));
			goToNextUrl();
			/*
        } else if( elapsed > 30 && !isZero && idxTime == 1 ) {
            $("#modal-answer").modal("show");	
        } else if( elapsed > 30 && !isZero && idxTime == 2 ){
            getCode();
        } else if( elapsed > 60 && !isZero && idxTime == 2 ) {
            $("#modal-answer").modal("show");	
        } else if( elapsed > 60 && !isZero && idxTime == 3 ){
            getCode();
        } else if( elapsed > 90 && !isZero && idxTime == 3 ) {
            $("#modal-answer").modal("show");	
        } else if( elapsed > 90 && !isZero && idxTime == 4 ){
            getCode();
			*/
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
		/*
		if ( elapsed > 30 ){
			keepCode['idxTime']=2;
		} else if ( elapsed > 60 ){
			keepCode['idxTime']=3;
		} else if ( elapsed > 90 ){
			keepCode['idxTime']=4;
		}
		*/
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
				myurl = "{{url('/web/result/1/')}}"+'/'+qst+'/1/'+svy+'/'+exr+'/'+sub+'/'+code+'/'+lessonid+'/'+user+'/'+mode;
				window.location.replace(myurl);					
			}
		});
	}
	
	
	function goToNextUrl(){
		nextUrl1 = "{{url('/web/session/2/1/')}}"+'/'+exr+'/'+sub+'/0000/'+lessonid+'/'+user+'/'+mode;
		window.location.replace(nextUrl1);
	}
	





});
</script>



<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/questions/'.$userid.'/'.$mode.'/'.$code) }}");
	$("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
	
	
});
</script>

@stop



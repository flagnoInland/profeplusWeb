@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/report.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="full">
<div class="container wrapper">

	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
	
		<div>
		<br/>
		<h5>@lang('labels.text_answer_key')</h5>
		</div>
	
		<div class="form-group-lg text-center" id="answer-box">
			<select name="answer" id="answer" 
                   class="form-control text-center">
			</select>
		</div>
		
		<div>
		<br/>
		<h5>@lang('labels.text_choose_type_report')</h5>
		</div>
		
		
		<div class="form-group-lg">
		<button id="simple" class="btn btn-lg btn-orange btn-block">
		<h5>INFORME SENCILLO:</h5>
		<h6>Solo cantidad y proporción que<br/>respondió correctamente.</h6>
		</button>
		</div>
		
		<div class="form-group-lg" id="completo-box">
		<button id="completo" class="btn btn-lg btn-base btn-block">
		<h5>INFORME DETALLADO:</h5>
		<h6>Mayor información que usted<br/> deberá ingresar.</h6>
		</button>
		</div>
		
		
	</div>
	
</div>
</div>

<div id="modal-mail" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
		<h5>¡Listo!<br/>Se le enviará, vía Email, un informe<br/> de todos los pasos que realice de este ejercicio.</h5><br/>
		</div>
		<div class="text-center">
			<button id="btn-return" type="button" class="btn btn-base">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>

<div id="modal-alert" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
		<h5>Debe ingresar la alternativa correcta.</h5><br/>
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" data-dismiss="modal">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    $("#exit-icon").click(function(e){
		e.preventDefault();
		window.history.back();
	});
	
	$("#back-icon").click(function(e){
		e.preventDefault();
		window.history.back();
	});
	
	$("#btn-return").click(function(){
		$("#modal-alert").modal("hide");
		window.history.back();
	});
	
	var answer = [];
	var qsp = '\xa0\xa0\xa0\xa0\xa0\xa0\xa0\xa0'
	if ({{$question}}==3){
		answer = ['','V','F'];
		answerv = ['',qsp+'V',qsp+'F'];
	} else {
		answer = ['','A','B','C','D','E'];
		answerv = ['',qsp+'A',qsp+'B',qsp+'C',qsp+'D',qsp+'E'];
	}
	
	for (i=0; i<answer.length; i++){
	  $('#answer').append($('<option>', {
			value: answer[i],
			text: answerv[i],
		}));
	}
	
	setTimeout(function () {
		$.ajax({
			type: "GET",
			url: "{{ url('web/full-report-data/'.$lessonid) }}",
			dataType: "json",
			success: function(data, status) {
				var keys = data['keys'];
				$("select option[value='"+keys+"']").attr("selected","selected");
			}
		});
	}, 500);
	
	$("#completo").click(function(){
		var ans = $("#answer").val();
		if (ans != ''){
			var vardata = {
			answer_keys: ans
			};
			$.ajax({
				type: "POST",
				url: "{{ url('web/report-answer/'.$lessonid) }}",
				dataType: "json",
				contentType : 'application/json',
				data: JSON.stringify(vardata),
				success: function(data, status) {
					window.location.replace("{{url('/web/report-full/')}}"+'/'+{{$step}}+'/'+{{$question}}+'/'+{{$run}}+'/'+{{$survey}}+'/'
			+{{$exercise}}+'/'+{{$subject}}+'/'+{{$code}}+'/'+{{$lessonid}}+'/'+{{$userid}}+'/'+{{$mode}});
				}
			});
		} else {
			$("#modal-alert").modal("show");
		}
		
	});
	
	$("#simple").click(function(){
		var ans = $("#answer").val();
		if (ans != ''){
			var vardata = {
			answer_keys: $("#answer").val()
			};
			$.ajax({
				type: "POST",
				url: "{{ url('web/report-answer/'.$lessonid) }}",
				dataType: "json",
				contentType : 'application/json',
				data: JSON.stringify(vardata),
				success: function(data, status) {
					sendEmail();
				}
			});
		} else {
			$("#modal-alert").modal("show");
		}
		
	});
	
	
	function sendEmail(){
		$.ajax({
			type: "GET",
			url: "{{ url('web/mail/'.$userid.'/'.$lessonid) }}",
			dataType: "json",
			success: function(data, status){
				$("#modal-mail").modal("show");
			}
		});
	}
	
	
	
	
	
	
});
</script>

@stop



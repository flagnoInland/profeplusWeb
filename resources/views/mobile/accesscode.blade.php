@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script> 
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container">
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<br/>@lang('labels.text_can_start')
		<br/>@lang('labels.text_show_code_to_student_board')
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<div id="accesscode" class="accesscode-box">
		{{$code}}
		</div>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="to-results" class="btn btn-lg btn-orange btn-narrow btn-block">
			@lang('labels.text_next')
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="to-manual" class="btn btn-lg btn-narrow btn-block">
			@lang('labels.text_use_manual')
		</button>
	</div>

</div>


<div id="modal-alert" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
			<br/><br/>
			Seguirá usando el mismo código.
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" data-dismiss="modal">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>
	
<div id="modal-answer" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
			<br/><br/>
			¿Es la misma lección?
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" id="dlg-send">Sí</button>
			<br/>
			<button type="button" class="btn btn-base" id="dlg-cancel">No</button>
		</div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
	
	var usr = {{$userid}};
	var mod = {{$mode}};
	var sub = {{$subject}};
	var exr = {{$exercise}};
	var qst = {{$question}};
	var svy = {{$survey}};
	var code = "{{$code}}";
	var lessonid = {{$lessonid}};
	var myurl = "";
	var sameCode = false;
	
	$("#back-icon").attr("href", "javascript:void(0)");
	$("#exit-icon").attr("href", "javascript:void(0)");
	
	
	$("#exit-icon").click(function(){
		$.ajax({
			type: "POST",
			url: "{{ url('web/disable/') }}"+"/"+lessonid,
			success: function(data, status) {
				window.location.href="{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}";
			}
		});
	});
	
	$("#back-icon").click(function(){
		$.ajax({
			type: "POST",
			url: "{{ url('web/disable/') }}"+"/"+lessonid,
			success: function(data, status) {
				if ({{$question}} == 4){
					window.location.replace("{{ url('/web/survey/'.$userid.'/'.$mode.'/'.$code) }}");
				} else if ({{$question}} == 2) {
					window.location.replace("{{ url('/web/exercise/'.$userid.'/'.$mode.'/'.$code) }}");
				} else {
					window.location.replace("{{ url('/web/questions/'.$userid.'/'.$mode.'/'.$code) }}");
				}
				
			}
		});
	});
	
	
	$("#to-manual").click(function(){
		window.location.href="{{url('/web/manual/teacher/')}}"+'/'+{{$userid}}+'/'+{{$mode}}+'/'+code+'/'
		+lessonid+'/'+{{$question}}+'/'+{{$survey}}+'/'+{{$exercise}}+'/'+{{$subject}}
	});
	
	if (code=='0000'){
		setTimeout(function () { 
			getCode();
		}, 200);
	} else {
		$("#modal-answer").modal("show");
	}
	
	$("#dlg-send").click(function(){
		sameCode = true;
		getCode();
		$("#modal-answer").modal("hide");
	});
	
	$("#dlg-cancel").click(function(){
		sameCode = false;
		code = "0000";
		getCode();
		$("#modal-answer").modal("hide");
	})
	
	
	function getCode(){
		var vardata = {
			course_id : -1,
			evaluation_id: 0,
			accesscode: code,
			subject : sub,
			exercise : exr,
			inactive: 0,
			app_mode: mod,
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
				myurl = "{{url('/web/result/1/')}}"+'/'+{{$question}}+'/1/'+{{$survey}}+'/'+{{$exercise}}+'/'+{{$subject}}
					+'/'+code+'/'+lessonid+'/'+{{$userid}}+'/'+{{$mode}};
				$("#accesscode").text(code);
				if (sameCode){
					$("#modal-alert").modal("show");
				}					
			}
		});
	}
	
	$("#to-results").click(function(){
		var vardata = {
			run: 1,
			level: '',
			grade: '',
			observation: '',
			classroom: '',
			institution: '',
			speciality: '',
			course_name: '',
			answer_keys:'',
		};
		$.ajax({
			type: "POST",
			url: "{{ url('web/session/')}}"+"/"+lessonid,
			dataType: "json",
			contentType : 'application/json',
			data: JSON.stringify(vardata),
			success: function(data, status) {
				window.location.replace(myurl);		
			}
		});
	});
	
});
</script>


@stop



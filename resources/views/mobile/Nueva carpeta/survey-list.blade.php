@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container full">

	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="satisfaction" class="btn btn-lg btn-green btn-block">
			@lang('labels.text_satisfaction_level')
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="qualification" class="btn btn-lg btn-green btn-block">
			@lang('labels.text_qualification')
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="speaker" class="btn btn-lg btn-green btn-block">
			@lang('labels.text_speaker_examination')
		</button>
	</div>
	

</div>

<script> $(document).ready(function(){ $("#back-icon").attr("href", "{{ url('/web/questions/'.$userid.'/'.$mode) }}"); $("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/1') }}");  $("#satisfaction").click(function (){ var user = {{$userid}}; var mode = {{$mode}}; var vardata = { course_id : -1, evaluation_id: 0, accesscode: '0000', subject : 0, exercise : 0, inactive: 0, app_mode: mode, run: 1, survey: 2, question_type: 4, question_mode: 0 }; $.ajax({ type: "POST", url: "{{ url('web/code/'.$userid) }}", dataType: "json", contentType : 'application/json', data: JSON.stringify(vardata), success: function(data, status) { var lessonid = data['id']; var run = data['run']; var code = data['accesscode']; window.location.replace("{{url('/web/session/4/2/0/0/')}}"+'/'+code+'/'+lessonid+'/'+user+'/'+mode); } }); });  $("#qualification").click(function (){ var user = {{$userid}}; var mode = {{$mode}}; var vardata = { course_id : -1, evaluation_id: 0, accesscode: '0000', subject : 0, exercise : 0, inactive: 0, app_mode: mode, run: 1, survey: 4, question_type: 4, question_mode: 0 }; $.ajax({ type: "POST", url: "{{ url('web/code/'.$userid) }}", dataType: "json", contentType : 'application/json', data: JSON.stringify(vardata), success: function(data, status) { var lessonid = data['id']; var run = data['run']; var code = data['accesscode']; window.location.replace("{{url('/web/session/4/4/0/0/')}}"+'/'+code+'/'+lessonid+'/'+user+'/'+mode); } }); });  $("#speaker").click(function (){ var user = {{$userid}}; var mode = {{$mode}}; var vardata = { course_id : -1, evaluation_id: 0, accesscode: '0000', subject : 0, exercise : 0, inactive: 0, app_mode: mode, run: 1, survey: 5, question_type: 4, question_mode: 0 }; $.ajax({ type: "POST", url: "{{ url('web/code/'.$userid) }}", dataType: "json", contentType : 'application/json', data: JSON.stringify(vardata), success: function(data, status) { var lessonid = data['id']; var run = data['run']; var code = data['accesscode']; window.location.replace("{{url('/web/session/4/5/0/0/')}}"+'/'+code+'/'+lessonid+'/'+user+'/'+mode); } }); });  }); </script>  



@stop



@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container full">

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
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/exercise/'.$userid.'/'.$mode) }}"  class="btn btn-lg btn-green btn-block">
			@lang('labels.text_from_databank')
		</a>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center" id ="opinion-box">
		<a href="{{ url('/web/survey/'.$userid.'/'.$mode) }}"  class="btn btn-lg btn-green btn-block">
			@lang('labels.text_get_opinion')
		</a>
	</div>
	

</div>

<script> $(document).ready(function(){ $("#back-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/1') }}"); $("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/1') }}");  var mode = {{$mode}}; if (mode == 2){ $("#opinion-box").css("display","none"); }  $("#simple").click(function(){ var user = {{$userid}}; var mode = {{$mode}}; var vardata = { course_id : -1, evaluation_id: 0, accesscode: '0000', subject : 0, exercise : 0, inactive: 0, app_mode: mode, run: 1, survey: 1, question_type: 1, question_mode: 0 }; $.ajax({ type: "POST", url: "{{ url('web/code/'.$userid) }}", dataType: "json", contentType : 'application/json', data: JSON.stringify(vardata), success: function(data, status) { var lessonid = data['id']; var run = data['run']; var code = data['accesscode']; window.location.replace("{{url('/web/session/1/1/0/0/')}}"+'/'+code+'/'+lessonid+'/'+user+'/'+mode); } }); });  $("#binary").click(function(){ var user = {{$userid}}; var mode = {{$mode}}; var vardata = { course_id : -1, evaluation_id: 0, accesscode: '0000', subject : 0, exercise : 0, inactive: 0, app_mode: mode, run: 1, survey: 1, question_type: 3, question_mode: 0 }; $.ajax({ type: "POST", url: "{{ url('web/code/'.$userid) }}", dataType: "json", contentType : 'application/json', data: JSON.stringify(vardata), success: function(data, status) { var lessonid = data['id']; var run = data['run']; var code = data['accesscode']; window.location.replace("{{url('/web/session/3/1/0/0/')}}"+'/'+code+'/'+lessonid+'/'+user+'/'+mode); } }); });   }); </script>  



@stop



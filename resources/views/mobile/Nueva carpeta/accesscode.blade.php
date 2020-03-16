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
		<div class="accesscode-box">
		{{$code}}
		</div>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="to-results" class="btn btn-lg btn-orange btn-block">
			@lang('labels.text_next')
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="to-manual" class="btn btn-lg btn-narrow btn-block">
			@lang('labels.text_use_manual')
		</button>
	</div>

	

</div>

<script> $(document).ready(function(){  $("#back-icon").attr("href", "javascript:void(0)"); $("#exit-icon").attr("href", "javascript:void(0)");   $("#exit-icon").click(function(){ $.ajax({ type: "POST", url: "{{ url('web/disable/'.$lessonid) }}", success: function(data, status) { window.location.href="{{ url('/web/board/'.$userid.'/'.$mode.'/1') }}"; } }); });  $("#back-icon").click(function(){ $.ajax({ type: "POST", url: "{{ url('web/disable/'.$lessonid) }}", success: function(data, status) { if ({{$question}} == 4){ window.location.replace("{{ url('/web/survey/'.$userid.'/'.$mode) }}"); } else if ({{$question}} == 2) { window.location.replace("{{ url('/web/exercise/'.$userid.'/'.$mode) }}"); } else { window.location.replace("{{ url('/web/questions/'.$userid.'/'.$mode) }}"); }  } }); });  $("#to-manual").click(function(){ window.location.href="{{url('/web/manual/teacher/')}}"+'/'+{{$userid}}+'/'+{{$mode}}+'/'+{{$code}}+'/' +{{$lessonid}}+'/'+{{$question}}+'/'+{{$survey}}+'/'+{{$exercise}}+'/'+{{$subject}} });  $("#to-results").click(function(){ var vardata = { run: 1, level: '', grade: '', observation: '', classroom: '', institution: '', speciality: '', course_name: '', answer_keys:'', }; $.ajax({ type: "POST", url: "{{ url('web/session/'.$lessonid) }}", dataType: "json", contentType : 'application/json', data: JSON.stringify(vardata), success: function(data, status) { window.location.replace("{{url('/web/result/1/')}}"+'/'+{{$question}}+'/1/'+{{$survey}}+'/'+{{$exercise}}+'/'+{{$subject}} +'/'+{{$code}}+'/'+{{$lessonid}}+'/'+{{$userid}}+'/'+{{$mode}}); } }); });  }); </script> 

@stop



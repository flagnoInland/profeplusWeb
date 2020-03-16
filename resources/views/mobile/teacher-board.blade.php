@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('js/js.cookie.js')}}"></script>
@stop

@section('content')
@include('toolbars.toolbar-5btn-student')

<div class="full">
<div class="container wrapper">

	<div class="text-center">
	<h4>{{$welcome}}</h4>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/questions/'.$userid.'/'.$mode.'/'.$code) }}" class="btn btn-lg btn-orange btn-block">
			@lang('labels.text_ask_class')
		</a>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/teacher-manual-list/'.$userid.'/'.$mode.'/'.$code) }}" class="btn btn-lg btn-base btn-block">
			@lang('labels.text_help')
		</a>
	</div>

</div>
</div>
<script>
$(document).ready(function(){
	$("#back-icon").attr("href", "javascript:void(0)");
	$("#exit-icon").attr("href", "javascript:void(0)");
    $("#info-icon").attr("href", "{{ url('/web/info-list/'.$userid.'/'.$mode.'/1/'.$code) }}");
	$("#mode-icon").attr("href", "{{ url('/web/user/'.$userid) }}");
	$("#profile-icon").attr("href", "{{ url('/web/update/'.$userid.'/'.$mode.'/1/'.$code) }}");
	$("#mobile-icon").attr("href", "{{ url('/web/manual/mobile/'.$userid.'/'.$mode.'/1/0000') }}");
	$("#exit-icon").click(function(){
		window.location.replace("{{ url('/') }}");
	});
	$("#back-icon").click(function(){
		window.location.replace("{{ url('/web/login/'.$mode.'/1') }}");
	});
	
	/*setTimeout(function () {
		$.ajax({
			type: "POST",
			url: "{{ url('web/disableOldlessons/'.$userid) }}",
			success: function(data, status) {
			}
		});
	}, 1000);*/
	
	var d = new Date();
	var keepCode = {
		'startTime' : d.getTime(),
		'idxTime': 0,
		'code': '0000'
	};
	Cookies.set('keepCode', JSON.stringify(keepCode));
	
});


</script>

@stop



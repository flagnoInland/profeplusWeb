@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="full">
<div class="container wrapper">

	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/manual/protocol/'.$userid.'/'.$mode.'/'.$code) }}" class="btn btn-lg btn-orange btn-block">
			@lang('labels.text_protocol_teach')
		</a>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/manual/teacher/'.$userid.'/'.$mode.'/0000/0/0/0/0/0') }}" class="btn btn-lg btn-red btn-block">
			@lang('labels.text_use_manual')
		</a>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/manual/question/'.$userid.'/'.$mode.'/'.$code) }}" class="btn btn-lg btn-green btn-block">
			@lang('labels.text_ask_question_manual')
		</a>
	</div>

</div>
</div>

<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
	$("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
});
</script>


@stop



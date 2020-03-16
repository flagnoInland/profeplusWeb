@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container">

	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/manual/how/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}" class="btn btn-lg btn-infos btn-block">
			@lang('labels.text_motivation')
		</a>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/manual/why/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}" class="btn btn-lg btn-infos btn-block">
			@lang('labels.text_why_use')
		</a>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/manual/emprender/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}" class="btn btn-lg btn-infos btn-block">
			¿Quieres<br/>Emprender?
		</a>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/manual/who/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}" class="btn btn-lg btn-infos btn-block">
			Consejo consultivo
		</a>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/manual/thanks/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}" class="btn btn-lg btn-infos btn-block">
			@lang('labels.text_thanks')
		</a>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="{{ url('/web/manual/about/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}" class="btn btn-lg btn-infos btn-block">
			@lang('labels.text_creators_land')
		</a>
	</div>


</div>

<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/'.$type) }}");
	$("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/'.$type) }}");
});
</script>

@stop


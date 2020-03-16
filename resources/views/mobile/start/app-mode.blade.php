@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/app_mode.min.css')}}" rel="stylesheet" type="text/css"> 
@stop

@section('content')
@include('toolbars.toolbar-0')

<div class="full">
<div class="container">
            
    <div class="row wrapper">
    
        <div class="col-xs-12 col-sm-6 col-md-6 text-center">
            <a 	@if ($userid==0) 
					href="{{ url('/web/mode/1')}}" 
				@else 
					href="{{ url('/web/user/'.$userid.'/1')}}" 
				@endif 
				class="btn btn-lg btn-red btn-block">
                @lang('labels.text_uni_education')
            </a>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6  text-center">       
            <a 	@if ($userid==0) 
					href="{{ url('/web/mode/2')}}" 
				@else 
					href="{{ url('/web/user/'.$userid.'/2')}}" 
				@endif
			class="btn btn-lg btn-base btn-block">
            @lang('labels.text_school_education')
            </a>
        </div>
    
    </div>
    
</div>
</div>

@stop

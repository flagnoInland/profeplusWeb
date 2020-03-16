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
            <a @if ($userid==0) 
					href="{{ url('/web/start/'.$mode.'/1') }}" 
			   @else 
					href="{{ url('/web/user/'.$userid.'/'.$mode.'/1') }}" 
			   @endif >
			<img class="img-choose-user" src="{{asset('images/registro_profesor.png')}}"
			onmouseover="this.src='{{asset('images/registro_profesor_gray.png')}}';" 
			onmouseout="this.src='{{asset('images/registro_profesor.png')}}';"/>
			</a>
			<h4>@lang('labels.text_teacher')</h4>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6  text-center">  
            <a @if ($userid==0) 
					href="{{ url('/web/start/'.$mode.'/0') }}" 
			   @else 
					href="{{ url('/web/user/'.$userid.'/'.$mode.'/0') }}" 
			   @endif >
            <img class="img-choose-user" src="{{asset('images/registro_alumno.png')}}"
            onmouseover="this.src='{{asset('images/registro_alumno_gray.png')}}';" 
            onmouseout="this.src='{{asset('images/registro_alumno.png')}}';"/>
            </a>
            <h4>@lang('labels.text_student')</h4>
        </div>
    
    </div>
    
</div>
</div>

@stop
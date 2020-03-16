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
    
        <div class="col-xs-12 col-sm-4 col-md-4 text-center">
            <a href="{{ url('/web/login/'.$mode.'/'.$type) }}" class="btn btn-lg btn-orange btn-block">
                @lang('labels.text_login')
            </a>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4  text-center">       
            <a href="{{ url('/web/register/'.$mode.'/'.$type) }}" class="btn btn-lg btn-base btn-block">
            @lang('labels.text_sign_up')
            </a>
        </div>
        
        <div class="col-xs-12 col-sm-4 col-md-4  text-center">       
            <a href="{{ url('/web/recover/'.$mode.'/'.$type) }}" class="btn btn-lg btn-red btn-block">
            @lang('labels.text_recover_pass')
            </a>
        </div>
    
    </div>
    
</div>
</div>
@stop
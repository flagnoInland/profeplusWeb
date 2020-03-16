@extends('layouts.layout01')

@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/login.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script>  
@stop

@section('content')

<div class="full">
<div class="container">
            
    <div class="row wrapper">
    
        <div class="col-xs-12 col-sm-6 col-md-6 text-center">
            <div class="centering">
            <img class="img-choose-user" 
                 src="{{asset('images/logo.png')}}"
                 alt="logo"/>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 text-center">  
            <div class="centering">
            <form id="login" method="post">
            <div class="form-group-lg" id="email-box">
			<input type="hidden" id="_token" value="{{ csrf_token() }}">
            <input type="text" name="email" id="email" 
                   class="form-control"
                   placeholder="@lang('labels.hint_email')">
            </div> 
                
            <div class="form-group-lg" id="password-box">
            <input type="password" name="password" id="password" 
                   class="form-control" 
                   placeholder="@lang('labels.hint_password')" >
            </div>
                
            <div class="form-group-lg">
            <button type="submit" class="btn btn-lg btn-base btn-block">@lang('labels.text_sign_in')</button>
            </div>
            </form>
            
            </div>
        </div>
    
    </div>
    
</div>
</div>
<script> 
	$(document).ready(function(){ 
		$('#login').validate({ 
			submitHandler: function(form) { 
				form.submit(); 
			}, 
			rules: { 
				email: { required: true, email: true }, 
				password: { required: true, } 
			}, 
			messages: { 
				email: { required: "Ingrese un cuenta de correo correcta", email:"Ingrese un cuenta de correo correcta"}, 
				password: { required: "Ingrese su contraseña", } 
			}, 
			errorClass: "has-error", 
			highlight: function(element, errorClass) { 
				$(element.form).find("div[id=" + element.id + "-box]").addClass(errorClass); 
			}, 
		}); 
	}); 
</script> 

@stop
@extends('admin.layout00')

@section('header')
<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
<link href="{{asset('css/admin.min.css')}}" rel="stylesheet" type="text/css"> 
@stop

@section('content')

<form id="login">
  <div class="overlay">
      <div class="centering h4">
          <div class="chest text-center h3">
              <img src="{{asset('images/favicon.png')}}" class="inline-icon"/>
              Profeplus Admin
          </div>
        <div class="box">
            <div class="chest">
                <input type="text" id="input_1" style="color: #fff"
                       class="with-floating-label h5" required />
            <label for="input_1" class="floating-label h5" 
                   style="color: #fff">Correo Electrónico</label>
            </div>
            <div class="chest">
            <input type="password" id="input_2" style="color: #fff"
                   class="with-floating-label h5" required />
            <label for="input_2" class="floating-label h5" 
                   style="color: #fff">Contraseña</label>
            </div>
            <div class="text-center">
              <input type="submit" class="raised-button block-ctrl h5" value="Ingresar">
            </div>
        </div>
           
      </div>
  </div>
</form>

<div class="reveal" id="unauth" data-reveal>
    <div class="h4" style="color: #000">
        No está autorizado para ingresar en la página.
    </div>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<script>
$(document).ready(function(){
   
   var $modal = new Foundation.Reveal($('#unauth'));;
    $("#login").submit(function(event){
        event.preventDefault();
        var email = $("#input_1").val();
        var pass = $("#input_2").val();
        $.ajax({
            type: "GET",
            url: "{{url('/admin/login')}}"+"?email="+email+"&password="+pass,
            contentType : 'application/json',
            success: function(data) {
                window.location.href = 	"{{url('/admin/')}}"+"/"+data['userId'];
            },
            error: function(){
                $modal.open();
            }
        });
    });
    
});
</script>

<script src="{{asset('js/material-foundation.js')}}"></script> 
@stop

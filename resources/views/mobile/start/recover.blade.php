@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/login.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/register.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script>  
@stop

@section('content')
@include('toolbars.toolbar-0')

<div class="container">
            
	<form id="recover" method="post">
      			
		<!--		
		<div class="form-group-lg btn-width text-center" id="dni-box">
		<input type="number" name="dni" id="dni" 
			   class="form-control"
			   placeholder="@lang('labels.hint_dni')"/>
		</div>-->
		
		<div class="form-group-lg btn-width text-center" id="birthdate-box">
		<input type="text" name="birthdate" id="birthdate" 
			   class="form-control"
			   placeholder="@lang('labels.hint_birthdate')"/>
		</div>

		<div class="form-group-lg btn-width text-center" id="email-box">
		<input type="text" name="email" id="email" 
			   class="form-control"
			   placeholder="@lang('labels.hint_email')"/>
		</div> 
				
		<div class="form-group-lg btn-width text-center" id="password-box">
		<input type="password" name="password" id="password" 
			   class="form-control"
			   placeholder="Escriba su nueva contraseña"/>
		</div>
			
		<div class="form-group-lg btn-width text-center" id="confirm-box">
		<input type="password" name="confirm" id="confirm" 
			   class="form-control"
			   placeholder="Confirme su nueva contraseña"/>
		</div>

			       
    </div>
	
	<div class="container text-center">
	<div class="form-group-lg">
	<button type="submit" class="btn btn-lg btn-base btn-block">CAMBIAR</button>
	</div>
	</div>
	</form>
	</div>
	

    
</div>

<div id="modal-alert" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
			<br/><br/>
			Tu contraseña ha sido renovada.
			<br/><br/>
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" data-dismiss="modal">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>

<div id="modal-alert2" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
			<br/><br/>
			LA CUENTA NO EXISTE.
			<br/><br/>
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" data-dismiss="modal">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>

<script> $( function() { $( "#birthdate" ).datepicker({format: 'dd/mm/yyyy'}); $("#phone-box").css("display","none");} ); </script>
 
<script>
$(document).ready(function(){
	
$("#return").click(function(){
	windows.history.back();
});

$('#recover').validate({
    submitHandler: function(form) {
		var data = {
			email: $("#email").val(),
			password : $("#password").val(),
			nationid : 0,
			birthdate : $("#birthdate").val()
		};
		$.ajax({
			type: "POST",
			url: "{{url('/web/recover-user/')}}",
			dataType: "json",
			contentType : 'application/json',
			data: JSON.stringify(data),
			success: function(data, status) {
				$("#modal-alert").modal("show");	
			},
			error: function(data){
				$("#modal-alert2").modal("show");	
			}
			});
    },
    rules: {
		birthdate: {
			required: true
		},
        email: {
            required: true,
            email: true
        },
        password: {
            required: true,
        },
		confirm : {
			equalTo : "#password"
		}
    },
    messages: {
		birthdate: {
			required: "Ingrese su fecha de nacimiento"
		},
        email: {
            required: "Ingrese un cuenta de correo correcta",
        },
        password: {
            required: "Ingrese su contraseña",
        },
		confirm: {
			equalTo: "Ingrese su contraseña nuevamente"
		}
    },
    errorClass: "has-error",
    highlight: function(element, errorClass) {
        $(element.form).find("div[id=" + element.id + "-box]").addClass(errorClass);
    },

});
});
</script>


@stop

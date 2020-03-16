@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/login.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/register.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js" charset="UTF-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/es.js"></script> 
@stop

@section('content')
@include('toolbars.toolbar-0')

<div class="container">
            
	<form id="register">
    <div class="row">
    
        <div class="col-xs-12 col-sm-6 col-md-6 text-center">
			
            <div class="form-group-lg" id="firstname-box">
            <input type="text" name="firstname" id="firstname" 
                   class="form-control"
                   placeholder="@lang('labels.hint_firstname')"/>
            </div>
			
			<div class="form-group-lg" id="lastname-box">
            <input type="text" name="lastname" id="lastname" 
                   class="form-control"
                   placeholder="@lang('labels.hint_lastname')"/>
            </div>
			
			<div class="form-group-lg" id="gender-box">
			<select name="gender" id="gender" 
                   class="form-control">
			  <option value="Male">Masculino</option>
			  <option value="Female">Femenino</option>
			</select>
            </div>
			
			<div class="form-group-lg" id="birthdate-box">
            <input type="text" name="birthdate" id="birthdate" 
                   class="form-control"
				   placeholder="@lang('labels.hint_birthdate')"/>
            </div>
			
			<!--
			<div class="form-group-lg" id="dni-box">
            <input type="number" name="dni" id="dni" 
                   class="form-control"
                   placeholder="@lang('labels.hint_dni') }}"/>
            </div>
			
			<div class="form-group-lg" id="country-box">
			<select name="country" id="country" 
                   class="form-control">
			</select>
            </div>-->
			
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 text-center">  
			
			<div class="form-group-lg" id="password-box">
            <input type="password" name="password" id="password" 
                   class="form-control"
                   placeholder="@lang('labels.text_write_password')"/>
            </div>
			
			<div class="form-group-lg" id="confirm-box">
            <input type="password" name="confirm" id="confirm" 
                   class="form-control"
                   placeholder="@lang('labels.hint_confirm')"/>
            </div>
			
			<div class="form-group-lg" id="phone-box">
            <input type="text" name="phone" id="phone" 
                   class="form-control"
                   placeholder="@lang('labels.hint_phone')"/>
            </div>
            
            <div class="form-group-lg" id="email-box">
            <input type="text" name="email" id="email" 
                   class="form-control"
                   placeholder="@lang('labels.hint_email')"/>
            </div> 
               
			<!--
            <div class="form-group-lg" id="city-box">
            <input type="text" name="city" id="city" 
                   class="form-control"				 
                   placeholder="@lang('labels.hint_city')" />
            </div>-->
                
        </div>
    
    </div>
	
	<div class="container text-center">
	<div class="form-group-lg">
	<div class="checkbox">
	  <label><input type="checkbox" value="" name="terms"><a data-toggle="modal" href="#myModal">@lang('labels.text_accept_term_conditions')</a></label>
	</div>
	</div>
	</div>
	
	<div class="container text-center">
	<div class="form-group-lg">
	<button type="submit" class="btn btn-lg btn-base btn-block">@lang('labels.text_sign_up')</button>
	</div>
	</div>
	</form>
	

    
</div>

<script>
	
  $( function() {
    $( "#birthdate" ).datepicker({
      format: 'dd/mm/yyyy'
    });
	$("#phone-box").css("display","none");
  } );
</script>

<script>
  $( function() {
	  var lan = 'en'
	  $.ajax({ 
		url: "{{url('/locale')}}", 
		dataType: 'json', 
		success: function(data) {
			lan = data['lan'];
			var countries = [];
			var countries_en = [];
			var countries_es = ["Afganistán", "Akrotiri", "Albania", "Alemania", "Andorra", "Angola", "Anguila", "Antártida", "Antigua y Barbuda", "Antillas Neerlandesas", "Arabia Saudí", "Arctic Ocean", "Argelia", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Islands", "Atlantic Ocean", "Australia", "Austria", "Azerbaiyán", "Bahamas", "Bahráin", "Bangladesh", "Barbados", "Bélgica", "Belice", "Benín", "Bermudas", "Bielorrusia", "Birmania; Myanmar", "Bolivia", "Bosnia y Hercegovina", "Botsuana", "Brasil", "Brunéi", "Bulgaria", "Burkina Faso", "Burundi", "Bután", "Cabo Verde", "Camboya", "Camerún", "Canadá", "Chad", "Chile", "China", "Chipre", "Clipperton Island", "Colombia", "Comoras", "Congo", "Coral Sea Islands", "Corea del Norte", "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dhekelia", "Dinamarca", "Dominica", "Ecuador", "Egipto", "El Salvador", "El Vaticano", "Emiratos Árabes Unidos", "Eritrea", "Eslovaquia", "Eslovenia", "España", "Estados Unidos", "Estonia", "Etiopía", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gabón", "Gambia", "Gaza Strip", "Georgia", "Ghana", "Gibraltar", "Granada", "Grecia", "Groenlandia", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea Ecuatorial", "Guinea-Bissau", "Guyana", "Haití", "Honduras", "Hong Kong", "Hungría", "India", "Indian Ocean", "Indonesia", "Irán", "Iraq", "Irlanda", "Isla Bouvet", "Isla Christmas", "Isla Norfolk", "Islandia", "Islas Caimán", "Islas Cocos", "Islas Cook", "Islas Feroe", "Islas Georgia del Sur y Sandwich del Sur", "Islas Heard y McDonald", "Islas Malvinas", "Islas Marianas del Norte", "Islas Marshall", "Islas Pitcairn", "Islas Salomón", "Islas Turcas y Caicos", "Islas Vírgenes Americanas", "Islas Vírgenes Británicas", "Israel", "Italia", "Jamaica", "Jan Mayen", "Japón", "Jersey", "Jordania", "Kazajistán", "Kenia", "Kirguizistán", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "Líbano", "Liberia", "Libia", "Liechtenstein", "Lituania", "Luxemburgo", "Macao", "Macedonia", "Madagascar", "Malasia", "Malaui", "Maldivas", "Malí", "Malta", "Man, Isle of", "Marruecos", "Mauricio", "Mauritania", "Mayotte", "México", "Micronesia", "Moldavia", "Mónaco", "Mongolia", "Montenegro", "Montserrat", "Mozambique", "Mundo", "Namibia", "Nauru", "Navassa Island", "Nepal", "Nicaragua", "Níger", "Nigeria", "Niue", "Noruega", "Nueva Caledonia", "Nueva Zelanda", "Omán", "Pacific Ocean", "Países Bajos", "Pakistán", "Palaos", "Panamá", "Papúa-Nueva Guinea", "Paracel Islands", "Paraguay", "Perú", "Polinesia Francesa", "Polonia", "Portugal", "Puerto Rico", "Qatar", "Reino Unido", "República Centroafricana", "República Checa", "República Democrática del Congo", "República Dominicana", "Ruanda", "Rumania", "Rusia", "Sáhara Occidental", "Samoa", "Samoa Americana", "San Cristóbal y Nieves", "San Marino", "San Pedro y Miquelón", "San Vicente y las Granadinas", "Santa Helena", "Santa Lucía", "Santo Tomé y Príncipe", "Senegal", "Serbia", "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somalia", "Southern Ocean", "Spratly Islands", "Sri Lanka", "Suazilandia", "Sudáfrica", "Sudán", "Suecia", "Suiza", "Surinam", "Svalbard y Jan Mayen", "Tailandia", "Taiwán", "Tanzania", "Tayikistán", "Territorio Británico del Océano Indico", "Territorios Australes Franceses", "Timor Oriental", "Togo", "Tokelau", "Tonga", "Trinidad y Tobago", "Túnez", "Turkmenistán", "Turquía", "Tuvalu", "Ucrania", "Uganda", "Unión Europea", "Uruguay", "Uzbekistán", "Vanuatu", "Venezuela", "Vietnam", "Wake Island", "Wallis y Futuna", "West Bank", "Yemen", "Yibuti", "Zambia", "Zimbabue"];
			if ( lan =='es'){
				countries = countries_es;
			};
			for (i=0; i<countries.length; i++){
			  $('#country').append($('<option>', {
					value: i,
					text: countries[i],
				}));
			}
			$("select option[value='185']").attr("selected","selected");
		}
	});
	

 });
</script>

<script>
$(document).ready(function(){
jQuery.validator.addMethod("validDate", function(value, element) {
        return this.optional(element) || moment(value,"DD/MM/YYYY").isValid();
    }, "Please enter a valid date in the format DD/MM/YYYY");
$('#register').validate({
    submitHandler: function(form) {
        $.post( "",
		{
			last_name : $("#lastname").val(),
			first_name : $("#firstname").val(),
			email: $("#email").val(),
			password : $("#password").val(),
			nationid : 0,
			gender : $("#gender").val(),
			birthdate : $("#birthdate").val(),
			country : "Perú",
			city : "Lima",
			phone : 0000,
			studentid :  '',
			speciality : '',
			institution_name : ''
		},
		function(data, status) {
			var userid = data['user_id'];
			window.location.replace("{{ url('web/board') }}"+'/'+userid+'/'+{{$mode}}+'/0000/1');		
		}).fail(function(error) { $("#modal-alert2").modal("show")});
    },
    rules: {
		firstname: {
			required: true
		},
		lastname: {
			required: true
		},
		birthdate: {
			required: true,
			validDate:true
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
		},
		terms : {
			required: true
		}
    },
    messages: {
		firstname: {
			required: "Ingrese su nombre"
		},
		lastname: {
			required: "Ingrese sus apellidos"
		},
		birthdate: {
			required: "Ingrese su fecha de nacimiento",
			validDate: "Fecha de nacimiento inválido"
		},
        email: {
            required: "Ingrese un cuenta de correo correcta",
        },
        password: {
            required: "Cree su contraseña para el app",
        },
		confirm: {
			equalTo: "Ingrese su contraseña nuevamente"
		},
		terms: {
			required: ""
		}
    },
    errorClass: "has-error",
    highlight: function(element, errorClass) {
        $(element.form).find("div[id=" + element.id + "-box]").addClass(errorClass);
    },

});
});
</script>


<div id="myModal" class="modal" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content terms">
      <div class="modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		
		<div class="text-center">
			@lang('labels.text_terms_conditions')
		</div>
        
		<div>
		@lang('labels.msg_terms_conditions')
		</div>
		
		<div class="text-center">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
      </div>
      
    </div>

  </div>
</div>

<div id="modal-alert2" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
			<br/><br/>
			EL CORREO YA HA SIDO USADO.
			<br/><br/>
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" data-dismiss="modal">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>

@stop

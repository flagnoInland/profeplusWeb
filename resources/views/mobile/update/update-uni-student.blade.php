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
@include('toolbars.toolbar-2btn')

<div class="container">
            
	<form id="register" method="post" >
    <div class="row">
    
        <div class="col-xs-12 col-sm-6 col-md-6 text-center">
			
            <div class="form-group-lg" id="firstname-box">
            <input type="text" name="firstname" id="firstname" 
                   class="form-control"
				   value="{{ $user['first_name']}}"
                   placeholder="@lang('labels.hint_firstname')"/>
            </div>
			
			<div class="form-group-lg" id="lastname-box">
            <input type="text" name="lastname" id="lastname" 
                   class="form-control"
				   value="{{ $user['last_name']}}"
                   placeholder="@lang('labels.hint_lastname')"/>
            </div>
			
			<div class="form-group-lg" id="gender-box">
			<select name="gender" id="gender" 
                   class="form-control">
			  <option value="Male">@lang('labels.text_male') }}</option>
			  <option value="Female">@lang('labels.text_female')</option>
			</select>
            </div>
			
			<div class="form-group-lg" id="birthdate-box">
            <input type="text" name="birthdate" id="birthdate" 
                   class="form-control"
				   placeholder="@lang('labels.hint_birthdate')"/>
            </div>
			
			<div class="form-group-lg" id="dni-box">
            <input type="number" name="dni" id="dni" 
                   class="form-control"
				   value="{{ $user['nationid']}}"
                   placeholder="@lang('labels.hint_dni')"/>
            </div>
			
			<div class="form-group-lg" id="country-box">
			<select name="country" id="country" 
                   class="form-control">
			</select>
            </div>
			
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 text-center">  
		
			<div class="form-group-lg" id="city-box">
            <input type="text" name="city" id="city" 
                   class="form-control"
				   value="{{ $user['city']}}"
                   placeholder="@lang('labels.hint_city')" />
            </div>
			
			
			<div class="form-group-lg" id="phone-box">
            <input type="text" name="phone" id="phone" 
                   class="form-control"
				   value="{{ $user['phone']}}"
                   placeholder="@lang('labels.hint_phone')"/>
            </div>
            
                
            <div class="form-group-lg" id="institution-box">
            <input type="text" name="institution" id="institution" 
                   class="form-control"
				   value="{{ $user['institution_name']}}"
                   placeholder="@lang('labels.text_where_study')" />
            </div>
			
			<div class="form-group-lg" id="speciality-box">
            <input type="text" name="speciality" id="speciality" 
                   class="form-control"
				   value="{{ $user['speciality']}}"
                   placeholder="@lang('labels.text_what_study')" />
            </div>
			
			<div class="form-group-lg" id="studentid-box">
            <input type="text" name="studentid" id="studentid" 
                   class="form-control"
					value="{{ $user['studentid']}}"				   
                   placeholder="@lang('labels.text_which_student_id')" />
            </div>
                
        </div>
    
    </div>
	

	
	<div class="container text-center">
	<div class="form-group-lg">
	<button type="submit" class="btn btn-lg btn-base btn-block">@lang('labels.text_update')</button>
	</div>
	</div>
	</form>

    
</div>

<script> $( function() { $( "#birthdate" ).datepicker({format: 'dd/mm/yyyy'}); var mdate = '{{ $user['birthdate'] }}'; var fdate = mdate.substr(8,2)+'/'+mdate.substr(5,2)+'/'+mdate.substr(0,4); $("#birthdate").val(fdate); $( "#birthdate" ).datepicker('setValue',fdate); var gen = '{{ $user['gender'] }}'; if (gen == 'Female' || gen == 'Femenino'){ $("select option[value='Female']").attr("selected","selected"); } else { $("select option[value='Male']").attr("selected","selected"); } $("#back-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/0') }}"); $("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/0') }}"); } ); </script> 

<script> $( function() { var lan = 'en'; $.ajax({ url: "{{url('/locale')}}", dataType: 'json', success: function(data) { lan = data['lan']; var countries = []; var countries_en = []; var countries_es = ["Afganistán", "Akrotiri", "Albania", "Alemania", "Andorra", "Angola", "Anguila", "Antártida", "Antigua y Barbuda", "Antillas Neerlandesas", "Arabia Saudí", "Arctic Ocean", "Argelia", "Argentina", "Armenia", "Aruba", "Ashmore and Cartier Islands", "Atlantic Ocean", "Australia", "Austria", "Azerbaiyán", "Bahamas", "Bahráin", "Bangladesh", "Barbados", "Bélgica", "Belice", "Benín", "Bermudas", "Bielorrusia", "Birmania; Myanmar", "Bolivia", "Bosnia y Hercegovina", "Botsuana", "Brasil", "Brunéi", "Bulgaria", "Burkina Faso", "Burundi", "Bután", "Cabo Verde", "Camboya", "Camerún", "Canadá", "Chad", "Chile", "China", "Chipre", "Clipperton Island", "Colombia", "Comoras", "Congo", "Coral Sea Islands", "Corea del Norte", "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dhekelia", "Dinamarca", "Dominica", "Ecuador", "Egipto", "El Salvador", "El Vaticano", "Emiratos Árabes Unidos", "Eritrea", "Eslovaquia", "Eslovenia", "España", "Estados Unidos", "Estonia", "Etiopía", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gabón", "Gambia", "Gaza Strip", "Georgia", "Ghana", "Gibraltar", "Granada", "Grecia", "Groenlandia", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea Ecuatorial", "Guinea-Bissau", "Guyana", "Haití", "Honduras", "Hong Kong", "Hungría", "India", "Indian Ocean", "Indonesia", "Irán", "Iraq", "Irlanda", "Isla Bouvet", "Isla Christmas", "Isla Norfolk", "Islandia", "Islas Caimán", "Islas Cocos", "Islas Cook", "Islas Feroe", "Islas Georgia del Sur y Sandwich del Sur", "Islas Heard y McDonald", "Islas Malvinas", "Islas Marianas del Norte", "Islas Marshall", "Islas Pitcairn", "Islas Salomón", "Islas Turcas y Caicos", "Islas Vírgenes Americanas", "Islas Vírgenes Británicas", "Israel", "Italia", "Jamaica", "Jan Mayen", "Japón", "Jersey", "Jordania", "Kazajistán", "Kenia", "Kirguizistán", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "Líbano", "Liberia", "Libia", "Liechtenstein", "Lituania", "Luxemburgo", "Macao", "Macedonia", "Madagascar", "Malasia", "Malaui", "Maldivas", "Malí", "Malta", "Man, Isle of", "Marruecos", "Mauricio", "Mauritania", "Mayotte", "México", "Micronesia", "Moldavia", "Mónaco", "Mongolia", "Montenegro", "Montserrat", "Mozambique", "Mundo", "Namibia", "Nauru", "Navassa Island", "Nepal", "Nicaragua", "Níger", "Nigeria", "Niue", "Noruega", "Nueva Caledonia", "Nueva Zelanda", "Omán", "Pacific Ocean", "Países Bajos", "Pakistán", "Palaos", "Panamá", "Papúa-Nueva Guinea", "Paracel Islands", "Paraguay", "Perú", "Polinesia Francesa", "Polonia", "Portugal", "Puerto Rico", "Qatar", "Reino Unido", "República Centroafricana", "República Checa", "República Democrática del Congo", "República Dominicana", "Ruanda", "Rumania", "Rusia", "Sáhara Occidental", "Samoa", "Samoa Americana", "San Cristóbal y Nieves", "San Marino", "San Pedro y Miquelón", "San Vicente y las Granadinas", "Santa Helena", "Santa Lucía", "Santo Tomé y Príncipe", "Senegal", "Serbia", "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somalia", "Southern Ocean", "Spratly Islands", "Sri Lanka", "Suazilandia", "Sudáfrica", "Sudán", "Suecia", "Suiza", "Surinam", "Svalbard y Jan Mayen", "Tailandia", "Taiwán", "Tanzania", "Tayikistán", "Territorio Británico del Océano Indico", "Territorios Australes Franceses", "Timor Oriental", "Togo", "Tokelau", "Tonga", "Trinidad y Tobago", "Túnez", "Turkmenistán", "Turquía", "Tuvalu", "Ucrania", "Uganda", "Unión Europea", "Uruguay", "Uzbekistán", "Vanuatu", "Venezuela", "Vietnam", "Wake Island", "Wallis y Futuna", "West Bank", "Yemen", "Yibuti", "Zambia", "Zimbabue"]; if ( lan =='es'){ countries = countries_es; }; var choice = 0; for (i=0; i<countries.length; i++){ $('#country').append($('<option>', { value: i, text: countries[i], })); if (countries[i] == '{{$user['country']}}' ){ console.log(countries[i]); choice = i; } } $("select option[value='"+choice+"']").attr("selected","selected"); } }); }); </script> 

<script> $(document).ready(function(){ $('#register').validate({ submitHandler: function(form) { $.post( "", { last_name : $("#lastname").val(), first_name : $("#firstname").val(), nationid : $("#dni").val(), gender : $("#gender").val(), birthdate : $("#birthdate").val(), country : $("#country option:selected").text(), city : $("#city").val(), phone : $("#phone").val(), studentid : $("#studentid").val(), speciality : $("#speciality").val(), institution_name : $("#institution").val() }, function(data, status) { window.location.href="{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/0') }}"; }); }, rules: { firstname: { required: true }, lastname: { required: true }, birthdate: { required: true }, dni: { required: true } }, messages: { firstname: { required: "Ingrese su nombre" }, lastname: { required: "Ingrese sus apellidos" }, dni: { required: "Ingrese su número de D.N.I." }, birthdate: { required: "Ingrese su fecha de nacimiento" } }, errorClass: "has-error", highlight: function(element, errorClass) { $(element.form).find("div[id=" + element.id + "-box]").addClass(errorClass); }, }); }); </script> 

@stop

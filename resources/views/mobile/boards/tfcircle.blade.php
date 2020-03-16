@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/answerboard.min.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('js/js.cookie.js')}}"></script>
<link href="{{asset('css/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{asset('js/toastr.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script> 
@stop

@section('content')
@include('toolbars.toolbar-3btn-student')

<div class="text-center" id="title">
<br/>
<h4>Paso 1: RESPUESTA INDIVIDUAL</h4>
</div>
<div class="text-center alert-text" id="title">
<h4 >@lang('labels.msg_tap_correct_answer')</h4>
</div>

<div class="circle-wrapper">
<div class="circle">
<img class="img-circle" id="img-circle" src="">
<button id="ansF" class="btn-cir ansf">&#10004;&nbsp;&nbsp;</button>
<button id="ansG" class="btn-cir ansg">&nbsp;&nbsp;&#10004;</button>
<button id="ansH" class="btn-cir ansh">&#10004;</button>
<img class="logo-circle" src="{{ asset('images/logo_wheel.png') }}">
</div>
</div>

<div class="container">
<div class="col-xs-12 col-sm-12 col-md-12 text-center challenge">
	<button id="challenge" class="btn btn-lg btn-orange btn-block">
		@lang('labels.text_challenge_question')
	</button>
	<button id="share" class="btn btn-lg btn-red btn-block">
		@lang('labels.text_share_partner') }}
	</button>
	<button id="owner" class="btn btn-lg btn-red btn-block">
		@lang('labels.text_close_guest_session')
	</button>
</div>
</div>

<div id="modal-alert" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
			<div class="alert-text">IMPORTANTE:</div>
			<br/><br/>
			PARA CAMBIAR TU RESPUESTA SÓLO TIENES UNA OPORTUNIDAD.
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" data-dismiss="modal">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>

<div id="modal-wrong" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center"><br/>
			La respuesta no ha sido enviada.<br/>
                        La clase ha terminado.<br/>
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" data-dismiss="modal">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>
	
<div id="modal-answer" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
			ESCOGISTE LA ALTERNATIVA:
			<br/>
			<div id="dlg-letter"></div>
			<br/>
			¿DESEAS ENVIAR ESTA RESPUESTA?
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" id="dlg-send">Sí</button>
			<br/>
			<button type="button" class="btn btn-base" id="dlg-cancel">No</button>
		</div>
      </div>
    </div>
  </div>
</div>


<div id="modal-team" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
			<div class="alert-text">IMPORTANTE:</div><br/>
			Trabaja en equipo con uno de tus compañeros y hazle las preguntas reto.<br/><br/>  
			Pregunta a tu compañero(a):<br/><br/>
			<div class="text-left">
			<ol>
			<li>¿Qué concepto de esta lección fundamentó tu respuesta?</li>
			<li>¿Y qué pasaría si…? (crea otras situaciones)</li>
			</ol>
			</div>
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" data-dismiss="modal">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>

<div id="modal-guest" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<form id="login" method="post">
		<div class="text-center">
		<div class="form-group-lg" id="email-box">
		<input type="text" name="email" id="email" 
			   class="form-control"
			   placeholder="@lang('labels.hint_email')"/>
		</div> 
		</div>
		<br/>
		<div class="text-center">
		<div class="form-group-lg" id="password-box">
		<input type="password" name="password" id="password" 
			   class="form-control"
			   placeholder="@lang('labels.hint_password')"/>
		</div>
		</div>
		<br/>
		<div class="text-center">
			<button type="submit" class="btn btn-base">Aceptar</button>
		</div>
		</form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
	
	var mode = {{$mode}};
	var userid = {{$userid}};
	var ownerid = {{$userid}};
	var guestid = 0;
	var share = 0;
	var guestpass = "none";
	var guesturl = "";
	
	$("#share").css("display","none");
	$("#owner").css("display","none");
	
	function loadForm(){
	$('#login').validate({
		submitHandler: function(form) {
			$("#modal-guest").modal("hide");
			if (mode == 2){
				guestpass = "none";
				guesturl = "{{url('/web/student/guestschool-login')}}";
			} else {
				guestpass = $("#password").val();
				guesturl = "{{url('/web/student/guest-login')}}";
			}
			var vardata = {
				email: $("#email").val(),
				password : guestpass
			};
			$.ajax({
				type: "POST",
				url: guesturl,
				dataType: "json",
				contentType : 'application/json',
				data: JSON.stringify(vardata),
				success: function(data, status) {
					guestid = data['user_id'];
					share = 1;
					$("#share").css("display","none");
					$("#owner").css("display","block");
					$("#refresh-icon").trigger("click");
					
				}
			});
		},
		rules: {
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			email: {
				required: "Ingrese un cuenta de correo correcta",
			}
		},
		errorClass: "has-error",
		highlight: function(element, errorClass) {
			$(element.form).find("div[id=" + element.id + "-box]").addClass(errorClass);
		},
	});
	}
	
	toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-center",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	};
    
	$("#exit-icon").click(function(e){
		e.preventDefault();
		window.history.back();
	});
	
	$("#back-icon").click(function(e){
		e.preventDefault();
		window.history.back();
	});
	
	if (mode == 2){
		$("#share").css("display","none");
		$("#owner").css("display","none");
	}
	
	
	$("#share").click(function() {
		if (mode == 2){
			$("password-box").css("display","none");
		}
		$("#modal-guest").modal("show");
		loadForm();
	});
	
	$("#owner").click(function(){
		share = 0;
		$("#share").css("display","block");
		$("#owner").css("display","none");
		$("#refresh-icon").trigger("click");
	});
	
	
	$("#challenge").css("display","none");
	$("#challenge").click(function() {
		$("#modal-team").modal("show");
	});
	
	var ansltr = ['A','B','C'];
	var colors = ['whtf1.png', 'whtf2.png', 'whtf3.png'];
	var grays = ['whtf1_gray.png', 'whtf2_gray.png', 'whtf3_gray.png'];
	var imgs = Math.floor((Math.random() * 2) + 0);

	$("#img-circle").attr("src","{{asset('images')}}"+'/'+colors[imgs]);
	
	
	var last = 'Z';
	var check = {{$check}};
	var attempt = 0;
	var letter = 'Z';
	var realletter= 'V';
	disablebtn(1,'F');
	
	setTimeout(function () { 
		$("#refresh-icon").trigger("click");
	}, 500);
	
	var lessonid = {{$lessonid}};
	var userid = {{$userid}};
	$("#refresh-icon").on('click', function(e){
		e.preventDefault();
		var myurl = "{{url('/web/student/')}}"+'/'+userid+'/'+ownerid+'/'+{{$code}}+'/'+last+'/'+{{$mode}};
		if (share==1){
			myurl = "{{url('/web/student/')}}"+'/'+guestid+'/'+ownerid+'/'+{{$code}}+'/'+last+'/'+{{$mode}};
		}
		$.ajax({
			type: "GET",
			url: myurl,
			dataType: 'json',
			success: function(data, status) {
				var type = data['question_type'];
				var run = data['run'];
				lessonid = data['id'];
				var survey = data['survey'];
				check = data['check'];
				last = data['last_answer'];
				disablebtn(check,last);
				enablebtn(check);
				secondstep(run,check);
			}
		});
	});
	
	
	$("#ansF").click(function(){
		letter = 'F';
		realletter = 'Verdadero';
		showdlg();
	});
	
	$("#ansG").click(function(){
		letter = 'G';
		realletter = 'Falso';
		showdlg();
	});
	
	$("#ansH").click(function(){
		letter = 'H';
		realletter = 'No sé';
		showdlg();
	});
	
	
	$("#dlg-send").click(function(){
		fanswer(letter);
		$('#modal-answer').modal('hide');
	});
	
	$("#dlg-cancel").click(function(){
		$('#modal-answer').modal('hide');
		$('#modal-alert').modal('show');
	});
	
	
	function showdlg(){
		if (attempt == 0){
			++attempt;
			$('#dlg-letter').html(realletter);
			$('#modal-answer').modal('show');
		} else {
			fanswer(letter);
		}
		
	}
	
	function fanswer(letter){
		var myurl = "{{url('/web/answer/')}}"+'/'+userid+'/'+lessonid+'/';
		if (share==1){
			myurl = "{{url('/web/answer/')}}"+'/'+guestid+'/'+lessonid+'/';
		}
		if (check == 0){
			$.ajax({
			type: "POST",
			url: myurl+letter,
			success: function(data, status) {
				check = 1;
				last = letter;
				disablebtn(check,letter);
				toastr["info"]("SU RESPUESTA FUE ENVIADA.");
			},
                        error: function(){
                            $("#modal-wrong").modal("show");
                        }
			});
		} 
	}
	
	function disablebtn(check, letter){
		if (check==1 && letter != 'Z'){
			$("#ansF").attr("disabled",'');
			$("#ansG").attr("disabled",'');
			$("#ansH").attr("disabled",'');
			$("#img-circle").attr("src","{{asset('images')}}"+'/'+grays[imgs]);
			if (share==0){
				$("#share").css("display","block");
			}
		}
	}
	
	function enablebtn(check){
		if (check==0){
			$("#ansF").removeAttr("disabled",'');
			$("#ansG").removeAttr("disabled",'');
			$("#ansH").removeAttr("disabled",'');
			$("#img-circle").attr("src","{{asset('images')}}"+'/'+colors[imgs]);
			$("#share").css("display","none");
		}
	}
	
	
	function secondstep(run, check){
		if (run==2 && check==0){
			enablebtn(check);
			var imgs = Math.floor((Math.random() * 4) + 0);
			$("#img-circle").attr("src","{{asset('images')}}"+'/'+colors[imgs]);
			$("#challenge").css("display","block");
			$("#title").html("<h4>Paso 2: TRABAJO EN EQUIPO<h4>");
			$('body').css("background","#fff url('" + "{{asset('images/fondopregunta2.png')}}" + "') repeat center top");
			$('body').css("background-size","cover");
			$("#modal-team").modal("show");
			attempt = 0;
		}
	}
	
	
});
</script>

@stop



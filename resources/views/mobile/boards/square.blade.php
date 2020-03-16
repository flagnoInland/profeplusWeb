@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/answerboard.min.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('js/js.cookie.js')}}"></script>
<link href="{{asset('css/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{asset('js/toastr.min.js')}}"></script>
@stop

@section('content')
@include('toolbars.toolbar-3btn-student')

<div class="container">

	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
	<br/>
		<button id="ansA" class="btn btn-lg btn-green btn-block">
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="ansB" class="btn btn-lg btn-green btn-block">
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="ansC" class="btn btn-lg btn-green btn-block">
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="ansD" class="btn btn-lg btn-green btn-block">
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<button id="ansE" class="btn btn-lg btn-green btn-block">
		</button>
	</div>
	

</div>

<script>
$(document).ready(function(){
	
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
	
	var last = 'Z';
	var type = {{$survey}};
	var check = {{$check}};
	disablebtn(1,'A');
	
	var lblSatis = ['Estoy muy satisfecho con lo planteado.', 'Estoy satisfecho con lo planteado.', 
	'Estoy regularmente satisfecho con lo planteado.', 'Estoy insatisfecho con lo planteado.', 
	'Estoy totalmente insatisfecho con lo planteado.'];
	var lblqual = ['Muy alta calificación', 'Alta calificación', 'Regular calificación', 'Baja calificación' ,'Muy baja calificación'];
	var lblSpeaker = ['Muy buen expositor o docente.', 'Buen expositor o docente.', 'Regular expositor o docente.',
	'Debe mejorar.', 'Debe mejorar urgentemente.'];
	
	if (type == 2){
		$("#ansA").html(lblSatis[0]);
		$("#ansB").html(lblSatis[1]);
		$("#ansC").html(lblSatis[2]);
		$("#ansD").html(lblSatis[3]);
		$("#ansE").html(lblSatis[4]);
	}
	
	if (type == 4){
		$("#ansA").html(lblqual[0]);
		$("#ansB").html(lblqual[1]);
		$("#ansC").html(lblqual[2]);
		$("#ansD").html(lblqual[3]);
		$("#ansE").html(lblqual[4]);
	}
	
	if (type == 5){
		$("#ansA").html(lblSpeaker[0]);
		$("#ansB").html(lblSpeaker[1]);
		$("#ansC").html(lblSpeaker[2]);
		$("#ansD").html(lblSpeaker[3]);
		$("#ansE").html(lblSpeaker[4]);
	}
	
	setTimeout(function () { 
		$("#refresh-icon").trigger("click");
	}, 500);
	
	
	$("#refresh-icon").click(function(){
		var myurl = "{{url('/web/student/')}}"+'/'+{{$userid}}+'/'+{{$userid}}+'/'+{{$code}}+'/'+last+'/'+{{$mode}};
		$.ajax({
			type: "GET",
			url: myurl,
			dataType: 'json',
			success: function(data, status) {
				var type = data['question_type'];
				var run = data['run'];
				var lessonid = data['id'];
				var survey = data['survey'];
				check = data['check'];
				last = data['last_answer'];
				disablebtn(check,last)
				enablebtn(check)
			}
		});
	});
	
	
	$("#ansA").click(function(){
		fanswer('A');
	});
	
	$("#ansB").click(function(){
		fanswer('B');
	});
	
	$("#ansC").click(function(){
		fanswer('C');
	});
	
	$("#ansD").click(function(){
		fanswer('D');
	});
	
	$("#ansE").click(function(){
		fanswer('E');
	});
	
	function fanswer(letter){
		var myurl = "{{url('/web/answer/')}}"+'/'+{{$userid}}+'/'+{{$lessonid}}+'/';
		if (check == 0){
			$.ajax({
			type: "POST",
			url: myurl+letter,
			success: function(data, status) {
				check = 1;
				last = letter;
				disablebtn(check,letter);
				toastr["info"]("SU RESPUESTA FUE ENVIADA.");
			}
			});
		} 
	}
	
	function disablebtn(check, letter){
		if (check==1 && letter != 'Z'){
			$("#ansA").addClass("disable");
			$("#ansA").attr("disabled",'');
			$("#ansB").addClass("disable");
			$("#ansB").attr("disabled",'');
			$("#ansC").addClass("disable");
			$("#ansC").attr("disabled",'');
			$("#ansD").addClass("disable");
			$("#ansD").attr("disabled",'');
			$("#ansE").addClass("disable");
			$("#ansE").attr("disabled",'');
		}
	}
	
	function enablebtn(check){
		if (check==0){
			$("#ansA").removeClass("disable");
			$("#ansA").removeAttr("disabled",'');
			$("#ansB").removeClass("disable");
			$("#ansB").removeAttr("disabled",'');
			$("#ansC").removeClass("disable");
			$("#ansC").removeAttr("disabled",'');
			$("#ansD").removeClass("disable");
			$("#ansD").removeAttr("disabled",'');
			$("#ansE").removeClass("disable");
			$("#ansE").removeAttr("disabled",'');
		}
	}
	
	
});
</script>

@stop



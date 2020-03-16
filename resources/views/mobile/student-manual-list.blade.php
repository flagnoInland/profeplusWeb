@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container">

	<div class="text-center">
	<h4 id="title"></h4>
	</div>
	
	<div id="content" class="text-center">
	
	</div>
	
	<div id="ref-picture"class="text-center">
	<img src="#" id="picture"/>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="#" class="btn btn-lg btn-narrow btn-block" id="btn-next">
			@lang('labels.text_next')
		</a>
	</div>


</div>

<script>

$(document).ready(function(){
	
	var page = 0;
	var mode = {{ $mode }};
	
	var titles = ['<b>Página 1/5</b>', '<b>Página 2/5</b>', '<b>Página 3/5</b>', '<b>Página 4/5</b>', '<b>Página 5/5</b>'];
	
	var content = ['Con este sistema aprenderás más, respondiendo las preguntas planteadas en la clase.',
	'El docente te dictará un número de cuatro dígitos, que debes colocar en el recuadro. Luego pulsa "ENTRAR A CLASE".',
	'Para responder la pregunta, planteada por el docente, debes seguir los dos pasos siguientes.',
	'Paso 1: marca la alternativa correcta. Luego, atiende las indicaciones del profesor y espera a que se active el siguiente paso.',
	'Paso 2: hazle las dos preguntas que saldrán en la pantalla a un compañero cercano a ti. Luego marca tu respuesta.'];
	
	var pictures = ['universitario1.png','universitario2.png','universitario3.png','universitario4.png','universitario5.png'];
	if ( mode == 2) {
		pictures = ['colegial1.png','colegial2.png','colegial3.png','colegial4.png','colegial5.png'];
	}
    
	$("#title").html(titles[0]);
	$("#content").html(content[0]);
	$("#picture").attr("src","{{asset('images')}}"+'/'+pictures[0]);
	
	$("#back-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/0000/0') }}");
	
	$("#back-icon").on("click", function(){
		--page;
		if (page<0){
			$("#back-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/0000/0') }}");
		} else {
			$("#title").html(titles[page]);
			$("#content").html(content[page]);
			$("#picture").attr("src","{{asset('images')}}"+'/'+pictures[page]);
		}
	});
	
	$("#btn-next").on("click", function(){
		++page;
		if (page>4){
			$("#btn-next").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/0000/0') }}");
		} else {
			$("#title").html(titles[page]);
			$("#content").html(content[page]);
			$("#picture").attr("src","{{asset('images')}}"+'/'+pictures[page]);
			$("#back-icon").attr("href", "#");
		}
	});
	
	$("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/0000/0') }}");
	
});

</script>

@stop



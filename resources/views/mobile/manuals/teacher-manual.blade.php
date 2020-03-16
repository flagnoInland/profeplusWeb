@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')
<br/>
<div class="manual">
<div class="container manual-wrapper">
	<br/>
	<div class="text-center">
	<h4 id="title"></h4>
	</div>
	<br/>
	<div id="content" class="text-center">
	
	</div>
	<br/>
	<div id="ref-picture"class="text-center">
	<img src="#" id="picture"/>
	</div>
	<br/><br/>
	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<a href="#" class="btn btn-lg btn-narrow btn-block" id="btn-next">
			{{ trans('labels.text_next') }}
		</a>
	</div>

</div>
</div>

<script>  $(document).ready(function(){  var code = '{{$code}}'; var myurl = "{{ url('/web/teacher-manual-list/'.$userid.'/'.$mode.'/'.$code) }}"; if (code != '0000'){ myurl = "{{ url('/web/session/'.$question.'/'.$survey.'/'.$exercise.'/'.$subject.'/'.$code.'/'.$lessonid.'/'.$userid.'/'.$mode) }}"; } var page = 0; var titles = ['Página 1/10', 'Página 2/10', 'Página 3/10', 'Página 4/10', 'Página 5/10', 'Página 6/10', 'Página 7/10', 'Página 8/10', 'Página 9/10', 'Página 10/10'];  var content = ['Con este sistema podremos saber cuántos estudiantes responden correctamente a preguntas planteadas en la clase y fomentar en ellos el trabajo en equipo.', 'Indique a los estudiantes el número de cuatro dígitos que aparece en la pantalla y escríbalo en la pizarra. Con ese número ellos ingresarán a esta clase.', 'Comente a los estudiantes que sus respuestas son anónimas y que este sistema les ayudará a aprender en sólo dos pasos.', 'Paso 1: Indíquenles que en silencio, y de manera individual, marquen la alternativa correcta a la pregunta que se planteó.', 'Motive a su salón de clase y así evitará tener estudiantes sin responder (SR).<br/>Los resultados los verá en su pantalla en un gráfico.', 'Para empezar el paso 2 (trabajo en equipo) pulse el botón "Terminar paso 1".<br/>Luego, pulse "Iniciar paso 2".', 'Paso 2: Invite a cada estudiante a trabajar en equipo con su compañero más cercano para resolver la pregunta (metodología "instrucción por pares").', 'Luego podrá ver la comparación de las respuestas<br/>(el paso 2 ayuda a aumentar la cantidad de respuestas correctas).', 'En el paso 2 sugerimos que cada estudiante haga las dos preguntas reto a su compañero (ambas aparecen en sus pantallas).<br/>Luego contestarán individualmente.', 'Si más del 70% respondió la alternativa correcta, se puede considerar avanzar con el siguiente concepto que debe enseñarse.<br/>Caso contrario, realice otras preguntas sobre ese mismo concepto hasta lograr superar el 70% de respuestas correctas.<br/>Para mayor detalle, puede consultar también el PROTOCOLO.',];  var pictures = ['docente1.png','docente2.png','docente3.png','docente4.png','docente5.png'];  $("#title").html(titles[0]); $("#content").html(content[0]); $("#picture").attr("src","{{asset('images')}}"+'/'+pictures[0]);   $("#back-icon").attr("href", myurl);   $("#back-icon").on("click", function(){ --page; if (page<0){ $("#back-icon").attr("href", myurl); } else { $("#title").html(titles[page]); $("#content").html(content[page]); $("#picture").attr("src","{{asset('images')}}"+'/'+pictures[page]); } });  $("#btn-next").on("click", function(){ ++page; if (page>9){ $("#btn-next").attr("href", myurl); } else { $("#title").html(titles[page]); $("#content").html(content[page]); if (page<5){ $("#picture").attr("src","{{asset('images')}}"+'/'+pictures[page]); } else { $("#picture").css("display","none"); } $("#back-icon").attr("href", "#"); } });  $("#exit-icon").attr("href", myurl);  });  </script> 



@stop
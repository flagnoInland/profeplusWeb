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
	<h4 id="title"><b>CREADORES</b></h4>
	</div>
	<br/>
	<div id="content">
ProfePlus es una iniciativa de la Red de Emprendedores E-QUIPU. Esta idea empezó a generarse desde el 2014. Luego, el 2015 la propuesta se presentó al Fondo Concursable de Innovación para la Docencia de la Dirección Académica del Profesorado de la Pontificia Universidad Católica del Perú (PUCP); ganando financiamiento inicial.<br/><br/>La propuesta en mención fue elaborada por un grupo de profesores, miembros del Grupo de Investigación del Trabajo en Equipo y Emprendimiento (GITEE) de la PUCP. Este equipo estuvo integrado por los tres profesionales que se presentan a continuación.<br/><br/>
<ul>
<li>Richard Moscoso Bullón: Profesor de Física PUCP y responsable del proceso de generación de preguntas y ejercicios de la primera edición del Manual para Profesores Innovadores de Física 1.</li>
<li>Carlos Vera Gutiérrez: Profesor de Estadística PUCP y responsable del análisis estadístico de las hipótesis planteadas. Profesor Principal y Miembro del Consejo de la Facultad de Ciencias e Ingeniería PUCP.</li>
<li>Ronnie Hans Guerra Portocarrero: Coordinador General de la Red de Emprendedores E-QUIPU y Profesor TPA de la PUCP. Responsable de la creación, análisis, implementación y monitoreo de ProfePlus y del proceso de innovación.</li>
</ul></br>
Asimismo, como  colaborador clave se sumó desde el inicio de esta iniciativa el Sr. Mijail Choque Huamán, estudiante de ingeniería mecatrónica de la PUCP.<br/><br/>Luego, para facilitar su expansión a más universidades del país, se obtuvo un valioso aporte de la Red Peruana de Universidades del Perú; quienes facilitaron la visita al campus PUCP de delegaciones de profesores de Física de costa, sierra y selva. También, al mismo tiempo, las áreas de Estudios Generales Ciencias, y la Facultad de Ciencias e Ingeniería de la PUCP aportaron subvención para la continuidad de esta iniciativa, naciendo así “ProfePlus”.<br/><br/>
Este es un esfuerzo colectivo y colaborativo que ponemos a disposición de la comunidad académica, en pos de la mejora en la enseñanza en el país.
	</div>
	<br/>
	

</div>
</div>

<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/info-list/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}");
	$("#exit-icon").attr("href", "{{ url('/web/info-list/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}");
});
</script>

@stop



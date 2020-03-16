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
	<h4 id="title"><b>POR QUÉ SE CREÓ PROFEPLUS</b></h4>
	</div>
	<br/>
	<div id="content">
ProfePlus nace como una propuesta para elevar la calidad del sistema de enseñanza, el cual, bajo las metodologías tradicionales, no está cumpliendo sus objetivos. Así, los ciudadanos, al finalizar su educación, egresan con una formación incompleta en conocimientos y competencias; debido fuertemente a que muchos centros de estudio se han convertido en organizaciones enfocadas solamente en la formación de trabajadores o empleados con débiles capacidades para generar cambios y mejoras para la sociedad.<br/><br/>
Si se revisan los estatutos de todas las universidades en el Perú, se encontrarán, palabras más, palabras menos, que “son instituciones dedicadas a la formación académica y profesional de primera clase, que desarrollan investigación de alto nivel y que realizan actividades de extensión en beneficio de la sociedad”. La posición en general del país en los rankings universitarios es una clara muestra que esa declaración no refleja la realidad.<br/><br/>
El sistema educativo es muy rígido y poco abierta a cambios y mejoras rápidas. Asimismo, en estas instituciones se suele tener miedo a cometer errores, generando que muchos prefieran no hacer nada y evitar que se les señale por algún fracaso. Basta ver la muy baja cantidad de carreras de educación superior con acreditación de calidad, para saber que muy poco se ha logrado. Es más, la experiencia refleja que en variadas ocasiones, quienes desean generar e implementar mejoras dentro de sus propias casas de estudio, son catalogados como rebeldes; pues no desean decir “Amén” a la situación actual.<br/><br/>
De acuerdo a lo anterior, el equipo de profesores, profesionales y estudiantes; quienes hemos estado inmersos en ProfePlus desde sus inicios, nos consideramos rebeldes a la situación y resultados actuales del sistema educativo. Consideramos que una forma de generar valor en los esquemas actuales estaría en socializar, facilitar e implementar la metodología de instrucción entre pares (la cual inició en la década de 1990 en la Universidad de Harvard, gracias al Dr. Eric Mazur).<br/><br/>
Así, luego de muchos esfuerzos conjuntos, a finales de febrero del 2016 se realizaron las pruebas de hipótesis de esta herramienta de innovación docente, utilizando el estadístico de prueba t-student, con 32 grados de libertad y error Tipo I del 5%. Los resultados fueron muy satisfactorios, probándose lo siguiente:<br/><br/>
<u>Hipótesis principal:</u>  Es factible utilizar un método sencillo, con el uso de TICs y aplicable en el aula, que estimule la generación de competencias relacionadas con el emprendimiento; y asimismo, potencie el aprendizaje de conceptos en los estudiantes.<br/><br/>
<u>Hipótesis secundarias:</u><br/>
<ol>
<li>Existe predisposición en los estudiantes a usar un aplicativo móvil en el aula.</li>
<li>El uso de un App en el aula para implementar la instrucción entre pares facilita una mejor valoración del profesor por parte de los estudiantes.</li>
<li>Los estudiantes perciben el progreso en la formación de las competencias al usar un App en el aula para implementar la instrucción entre pares.</li>
<li>El uso de un App en el aula para implementar la instrucción entre pares contribuye significativamente a que los estudiantes tengan una mejor percepción sobre su formación para trabajar en equipo.</li>
<li>La percepción de los estudiantes sobre la calidad de la enseñanza y la formación en competencias están influenciadas positivamente al saber que el docente monitorea en tiempo real la sesión.</li>
</ol><br/><br/>
ProfePlus es aplicable a cualquier curso, asignatura o disciplina, pues la instrucción entre pares tiene esta facilidad de adaptación sin inconvenientes. Con su uso estamos ayudando fuertemente en que los estudiantes mejoren el aprendizaje de conceptos y su formación en competencias. Asimismo, facilitamos la generación de publicaciones e investigaciones en docencia a los profesores; así como el proceso de acreditación de calidad de las instituciones de educación. Para mayor detalle de su uso puede ingresar a la sección Protocolo.
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



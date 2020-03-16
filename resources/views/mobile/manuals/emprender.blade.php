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
	<h4 id="title"><b>SI QUIERES EMPRENDER, ÚNETE A E-QUIPU</b></h4>
	</div>
	<br/>
	<div id="content">
Hola, muchas gracias por  usar ProfePlus y por expresar tus deseos de emprender mientras estudias. Para ello, te invitamos a unirte a la Red de Emprendedores E-QUIPU, iniciativa creada para apoyar tus iniciativas emprendedoras, principalmente en tres temas clave:<br/><br/>
<ol>
<li>Compartir tú pasión con más emprendedores.</li>
<li>Conectarte con más emprendedores y equipos.</li>
<li>Mejorar tus competencias.</li>
</ol><br/>
Asimismo, luego que te registres en <a href="http://www.e-quipu.pe">http://www.e-quipu.pe</a> y crees un equipo, te recomendamos que explores cómo potenciar tu emprendimiento. Nuestra experiencia de más de diez años, apoyando a jóvenes estudiantes, nos permite sugerir que te enfoques en tres tips:<br/><br/>
 
Tip 1: Revisa qué están haciendo, en otros países o ciudades, los jóvenes como tú en el tema que te interesa. Esto es clave, pues de esta manera tendrás mayores posibilidades de éxito. Por ello, revisa las siguiente webs, donde expertos de diversos temas comentan sus experiencias y donde además se comentan variados avances: <a href="http://www.ted.com/playlists">http://www.ted.com/playlists</a>, <a href="http://www.productioninspiration.com">http://www.productioninspiration.com</a>, <a href="https://scholar.google.com.pe/">https://scholar.google.com.pe/</a>, <a href="https://patents.google.com/">https://patents.google.com/</a>. Publica en tu espacio asignado en la Web E-QUIPU la información que creas conveniente, con el fin que incrementes tus destrezas en el tema que a ti te apasiona.<br/><br/>

Tip 2: Recuerda que hay muchas formas de auto-capacitarte en el tema que te apasiona; por ello, revisa las siguientes web donde puedes capacitarte rápidamente. <a href="https://es.coursera.org/">https://es.coursera.org/</a>, <a href="https://www.edx.org/">https://www.edx.org/</a>, <a href="https://www.acamica.com/cursos">https://www.acamica.com/cursos</a>. Asimismo, siempre revisa la sección de concursos donde puedes presentar tu proyecto emprendedor:<br/> <a href="http://www.e-quipu.pe/becasyconcursos">http://www.e-quipu.pe/becasyconcursos</a>.<br/><br/>
 
Tip 3: Facilita reuniones efectivas. Para permitir la participación a los miembros de tu equipo que no puedan estar presentes, utiliza herramientas como Skype o Zoom Google Hangouts. También, no debemos pensar que siempre las reuniones deben ser en un aula; pues pueden ser en casa de un amigo o al aire libre (y si se tiene wi-fi, mejor, pues puedes también usar las herramientas anteriores para que todos vean la misma pantalla, sin necesidad de un proyector multimedia).<br/><br/>
 
Asimismo, si consideras que tu proyecto está encaminado a ser una Start-Up, te invitamos a usar la sección “Crea tu Canvas” en la página principal www.e-quipu.pe. Para mayor detalle puedes revisar estos videos para afinar más la idea lo antes posible:<br/> <a href="http://www.e-quipu.pe/default/video/ver/video/202">http://www.e-quipu.pe/default/video/ver/video/202</a>;<br/><a href="http://www.e-quipu.pe/default/video/ver/video/204">http://www.e-quipu.pe/default/video/ver/video/204</a>;<br/> <a href="http://www.e-quipu.pe/default/video/ver/video/206">http://www.e-quipu.pe/default/video/ver/video/206</a><br/><br/>
 
Muchas gracias por tu atención y te felicitamos nuevamente por tu espíritu emprendedor. Suerte.<br/><br/>

</div>
</div>

<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/info-list/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}");
	$("#exit-icon").attr("href", "{{ url('/web/info-list/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}");
});
</script>

@stop



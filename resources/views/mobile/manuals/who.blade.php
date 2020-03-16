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
	<h4 id="title"><b>CONSEJO CONSULTIVO</b></h4>
	</div>
	<br/>
	<div id="content">
ProfePlus es una iniciativa de la Red de Emprendedores E-QUIPU y está a disposición de profesores y estudiantes de toda disciplina y ámbito. Su uso es libre y siempre lo será, estando a disposición para quien desee innovar en la enseñanza básica o superior.<br/><br/>En el marco de este esfuerzo conjunto y colaborativo se ha establecido un Consejo Consultivo, integrado por profesionales de tres universidades del Perú:<br/><br/>
<b>Pontificia Universidad Católica del Perú (PUCP):</b> 
<ul>
<li>Eduardo Ismodes Cascón, Fundador de la Red E-QUIPU. Past Decano de la Facultad de Ciencias e Ingeniería, PUCP. Fundador y coordinador del Grupo de Investigación del Trabajo en Equipo y Emprendimiento de la PUCP.</li>
<li>Ronnie Hans Guerra Portocarrero, Coordinador General de la Red E-QUIPU. Miembro Fundador del Grupo de Investigación del Trabajo en Equipo y Emprendimiento de la PUCP.</li>
</ul><br/>
<b>Universidad Nacional Mayor de San Marcos (UNMSM):</b>
<ul> 
<li>Orestes Cachay Boza, Rector de la UNMSM. Fundador de E-QUIPU San Marcos.</li>
<li>Álvaro Echevarría Córdova, Coordinador de E-QUIPU San Marcos. Profesor TP de Emprendimiento en la Facultad de Ingeniería Industrial en la UNMSM.</li>
</ul><br/>
<b>Universidad Nacional de Trujillo (UNT):</b> 
<ul>
<li>Arístides Távara Aponte, Fundador y Coordinador de E-QUIPU UNT. Profesor Principal y Past Decano de la Facultad de Ciencias Físicas y Matemáticas de la UNT.</li>
</ul><br/>
La Red de Emprendedores E-QUIPU está conformada por universidades de costa, sierra y selva del Perú; y en la que interactúan estudiantes de pregrado con espíritu emprendedor. Para mayor información de E-QUIPU revise la Web www.e-quipu.pe.
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
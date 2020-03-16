<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>ProfePlus</title>
</head>
<body>
<h1>Informe ProfePlus</h1>
<h2>{{ $teacher->first_name.' '.$teacher->last_name }}

@foreach ($lessons as $lesson)

<table  width="700" border="1" style="	border-collapse:collapse;background-color:#fff;color:#000;font-size:80%;text-align:center">
<col width="400" style="background-color:#fff;"><col width="200">
<tr style="color:#000;"><td>Hora</td><td>
{{ $lesson['data']->updated_at }}
</td></tr><tr><td>Clave</td><td>
{{ $lesson['data']->accesscode }}
</td></tr><tr><td>Tipo de pregunta</td><td>
{{ $lesson['data']->qt }}
</td></tr><tr><td>Opinión</td><td>
{{ $lesson['data']->surv }}
</td></tr><tr style="color:#000;"><td>Tema</td><td>
{{ $lesson['data']->subject }}
</td></tr><tr style="color:#000;"><td>Ejercicio</td><td>
{{ $lesson['data']->exercise }}
</td></tr><tr style="color:#000;"><td>Paso</td><td>
{{ $lesson['data']->run }}
</td></tr><tr style="color:#000;"><td>Respuesta Correcta</td><td>
{{ $lesson['data']->answer_keys }}
</td></tr><tr style="color:#000;"><td>Nombre del Curso</td><td>
{{ $lesson['data']->course_name }}

@if ( $teacher->appmode != 2 )
    @if ( $lesson['data']->speciality != "" )
        </td></tr><tr style="color:#000;"><td>Especialidad</td><td>
        {{ $lesson['data']->speciality }}
    @endif
    @if ( $lesson['data']->institution != "" )
        </td></tr><tr style="color:#000;"><td>Institución</td><td>
        {{ $lesson['data']->institution }}
    @endif
    @if ( $lesson['data']->observations != "" )
        </td></tr><tr style="color:#000;"><td>Observación</td><td>
        {{ $lesson['data']->observations }}
    @endif
@else
    @if ( $lesson['data']->level != "" )
        </td></tr><tr style="color:#000;"><td>Nivel</td><td>
        {{ $lesson['data']->level }}
    @endif
    @if ( $lesson['data']->grade != "" )
        </td></tr><tr style="color:#000;"><td>Grado</td><td>
        {{ $lesson['data']->grade }}
    @endif
    @if ( $lesson['data']->classroom != "" )
        </td></tr><tr style="color:#000;"><td>Sección</td><td>
        {{ $lesson['data']->classroom }}
    @endif
    @if ( $lesson['data']->institution != "" )
        </td></tr><tr style="color:#000;"><td>Institución</td><td>
        {{ $lesson['data']->institution }}
    @endif
@endif

<tr><td style="color:#00f">ALTERNATIVAS</td><td style="color:#00f">
RESPUESTAS

@if ( $lesson['data']->question_type != 3 )
    
</td></tr><tr><td>
 1. {{ $lesson['data']->opt1_name_es }}
</td><td style="color:#00f">
{{ $lesson['data']->ans1 }}
</td></tr><tr><td>
 2. {{ $lesson['data']->opt2_name_es }}
</td><td style="color:#00f">
{{ $lesson['data']->ans2 }}
</td></tr><tr><td>
 3. {{ $lesson['data']->opt3_name_es }}
<td style="color:#00f">
{{ $lesson['data']->ans3 }}
</td></tr><tr><td>
 4. {{ $lesson['data']->opt4_name_es }}
</td><td style="color:#00f">
{{ $lesson['data']->ans4 }}
</td></tr><tr><td>
 5. {{ $lesson['data']->opt5_name_es }}
</td><td style="color:#00f">
{{ $lesson['data']->ans4 }}

@else
    
</td></tr><tr><td>
 1. Verdadero
</td><td style="color:#00f">
{{ $lesson['data']->ans_yes }}
 </td></tr><tr><td>
 2. Falso
</td><td style="color:#00f">
{{ $lesson['data']->ans_no }}
 </td></tr><tr><td>
 3. No lo sé
</td><td style="color:#00f">
{{ $lesson['data']->ans_na }}

@endif
 
</td><tr><td style="color:#f00"> Estudiantes sin responder</td><td style="color:#f00">
{{ $lesson['data']->ansnn }}

</td><tr><td style="color:#f00"> Total Estudiantes</td><td style="color:#f00">
{{ $lesson['data']->inlesson }}
 
</td></tr>
</table> 
<br/>
Lista de Estudiantes
<table border="1" style="border-collapse:collapse;background-color:#fff;color:#000;font-size:80%;text-align:center"> 
<tr><td>Institución</td><td>Carrera</td><td>Código</td><td>Apellidos</td>
<td>Nombres</td><td>Participación</td><td>Cómo envió su respuesta</td></tr>
@foreach ($lesson['users'] as $user)
<tr><td>
{{ $user->institution_name }}
</td><td>
{{ $user->speciality }}
</td><td>
{{ $user->studentid }}
</td><td>
{{ $user->last_name }}
</td><td>
{{ $user->first_name }}
</td>
@if ( $user->answer != 0 )
	<td>Sí envió su respuesta</td>
@else
	<td style="color:#f00;">No envió su respuesta</td>
@endif
@if ( $user->owner == $user->user_id )
	<td>Usó su propio equipo</td>
@else
	<td style="color:#f00;">Usó el equipo de {{$user->owner_name}} {{$user->owner_surname}} </td>
@endif
</tr>
@endforeach
</table>



<br/>
@endforeach
<br/>





Enviado desde ProfePlus por la Plataforma Web de E-QUIPU
<br/>

</body>
</html>

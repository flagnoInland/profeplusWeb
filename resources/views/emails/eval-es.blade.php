<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>ProfePlus</title>
</head>
<body>
<h1>Reporte ProfePlus</h1>
<h2>{{ $teacher->first_name.' '.$teacher->last_name }}

@foreach ($evals as $eval)

<table  width="700" border="1" style="	border-collapse:collapse;background-color:#fff;color:#000;font-size:80%;text-align:center">
<col width="400" style="background-color:#fff;"><col width="200">

<tr style="color:#000;"><td>Nombre de la Prueba</td><td>
{{ $eval['data']->exam_title }}</td></tr>
<tr style="color:#000;"><td>Curso</td><td>
{{ $eval['data']->course_name }}</td></tr>
<tr style="color:#000;"><td>Hora</td><td>
{{ $eval['data']->created_at }}</td></tr>
<tr><td>Especialidad</td><td>
{{ $eval['data']->speciality }}</td></tr>
<tr><td>Institución</td><td>
{{ $eval['data']->institution }}</td></tr>
<tr style="color:#000;"><td>Número de Preguntas</td><td>
{{ $eval['data']->number_question }}</td></tr>


<tr><td style="color:#00f">Estudiantes</td><td style="color:#00f">
Puntaje</td></tr>
@foreach ($eval['users'] as $user)
<tr><td>
{{ $user->first_name.' '.$user->last_name}}
</td><td style="color:#00f">
{{ $user->score }}
</td></tr>
 
@endforeach
 

</td><tr><td style="color:#f00"> Total Estudiantes</td><td style="color:#f00">
{{ $eval['lessons']->inlesson }}
 
</td></tr>


</table> 
</br>
@endforeach

</body>
</html>

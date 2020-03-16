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
	<h4 id="title"><b>AGRADECIMIENTOS</b></h4>
	</div>
	<br/>
	<div id="content">
El comité consultivo de ProfePlus, agradece a quienes desde el inicio confiaron 
en este proyecto y ayudaron a sacarlo adelante.<br/><br/>Por ello, en 
primer lugar, expresamos nuestra profunda y eterna gratitud por las palabras 
de aliento a este esfuerzo, basado en difundir la metodología de instrucción 
por pares, recibidas por el Dr. Eric Mazur, decano de Física Aplicada de la 
Universidad de Harvard, quien es creador de dicha metodología.<br/><br/>
Del mismo modo, los autores reconocen el apoyo de los siguientes 
profesionales PUCP : Carlos Pizarro Ortiz, Lucrecia Chumpitaz Campos, 
Ana Maria Balbin Bastidas, Carmen Quiroz Fernández, Enrique Quispe Peña, 
Rogger Anaya Rosales, Pedro Siesquen Manrique y José María Espinoza Bueno.<br/><br/>
También apreciamos el compromiso en el proyecto "ProfePlus" de 
Herbert Caller Guzmán (consultor de programación) y Milagros Echegaray Mayorga 
(miembro del GITEE PUCP). Aprovechamos para hacer mención al apoyo de los 
estudiantes PUCP inmersos en este proyecto: Mijail Choque Huamán, 
Cindy Bautista Chavez, Juan Rivas, Jonathan Marcelo y Natalia Cárdenas Tataje. 
Sin ellos, ProfePlus no hubiese avanzado.<br/><br/>Del mismo modo, saludamos 
el compromiso de profesores de Física en el proyecto "ProfePlus", que 
representan a diversas universidades peruanas de costa, sierra y selva; 
especialmente a: Arístides Távara Aponte, Ricardo Gil Ramirez, 
Julio Idrogo Cordova, Demetrio Rocha Mendez, Denis Abanto, 
Roberto Rojas Alegria, Myriam Soledad Figueroa, Wilson Camacho Mamani, 
Luis Moreno, Wilfredo Valdivia Rojas, Alfredo Guzmán Valdivia, 
Mario Pumacallahui, José Portugal Salinas, Whinders Fernández Granda, 
Wilson Cabana, Juan Ramón Diaz, Rebeca Linares, Fernando Vásquez Vásquez,  
César Augusto Costa Polo, Julio Oré García, Jorge Luis Lozano, 
Manuel Emiliano Esteves Pairazamán, Mario Chávez Bacilio, y 
Arminda Tirado Rengifo.<br/><br/>Finalmente, extendemos nuestra 
correspondencia eterna a las siguientes áreas de la Pontificia Universidad 
Católica del Perú: Fondo Concursable de Innovación para la Docencia de la 
Dirección Académica del Profesorado, Red Peruana de Universidades del Perú, 
Dirección de Informática Académica, Estudios Generales Ciencias, y la 
Facultad de Ciencias e Ingeniería. Del mismo modo, a los estudiantes de 
ingeniería industrial que participaron en la pre-evaluación de esta 
iniciativa, especialmente a: Harold Blanco Rodríguez, Jackelyne Durán Feliciano, 
Franz Sac Araujo, Bárbara Salazar Gamarra, Grisell Sarrín Camas, 
Andrei Paulino Prieto, Ivonne Tananta Calvo, Giulliana Zagastizabal, 
Sonia Rojas Villanueva, Claudia Cochachin Malpica, Victor Villaizan Pastrana, 
Camila Huanca Ramos, Marialuisa Romero Rodríguez, Romina Flores Merino, 
Marialejandra Palomino Vara, Jhasmin Quispe Jorge, Isabel Diaz Alarcon, 
Josseline Wisky Pérez, Andrea Sanchez Gutierrez, Maria Valeria  Sotelo Polo, 
Dylan Natividad Giron, Emiliano Huamán Gil, Joselyn León Meza, 
Karina Fernández Romero, Brigitt Barrios Carlos, Leonardo Inga Curay, 
Katherine Chuquipalla Huamaní, Diego López Romero,  
Yessi León Poma, Anthony López Flores, Jorge Samamé Villacorta, 
Jose Ccorisoncco Capcha, Seleni Lara Jauregui.</div>
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



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
	<h4 id="title"><b>POR QUÉ USAR PROFEPLUS</b></h4>
	</div>
	<br/>
	<div id="content" oncopy="return false;">
ProfePlus está dirigido a profesores y estudiantes, de nivel básico o superior, que tengan deseos de innovar en la enseñanza. Principalmente, buscamos que sea usado por personas con espíritu rebelde ante los resultados actuales de educación, producto de métodos tradicionales de enseñanza.<br/><br/>Luego de los análisis y estudios realizados, podemos asegurar que al utilizar ProfePlus se logra beneficiar a profesores, estudiantes y a la sociedad.<br/><br/> 
	</div>
	
	<div><a href="#" id="teacher"><b>Beneficios para los profesores</b></a></div>
	<div id="teacher-content" oncopy="return false;">
	El uso de ProfePlus permite al profesor conocer, en tiempo real, el avance de la clase. Este sistema facilita al profesor ver en un gráfico qué opciones de respuestas han elegido los estudiantes ante una pregunta de conceptos planteada en la clase. De este modo el profesor puede elegir su mejor estrategia para asegurar el aprendizaje del curso.<br/><br/>¿Por qué es tan importante que el profesor sepa la proporción de estudiantes que realmente le han comprendido? Esto lo consideramos clave pues, en muchas ocasiones, cuando los profesores (luego de explicar algún concepto) preguntan “por favor, en caso alguien no haya entendido, levanten la mano”, lo común es que pocos o nadie de los estudiantes indique que tiene dudas (quizás por temor a que sus compañeros lo señalen por si se equivocó). Luego, el profesor, creyendo que los conceptos han sido comprendidos, siguen avanzando con otros temas, mientras los estudiantes se enfocan sólo en buscar medios para aprobar el curso, en lugar de aprenderlo bien. Si consideramos también que “no se defiende lo que no se comprende”, comprenderemos por qué es importante que se interioricen los conceptos de cada curso.<br/><br/>Un tema importante de resaltar es que la clase de vuelve mucho más dinámica, posicionando al estudiante con un rol más activo. El paso 2 (trabajo en equipo) implica dos preguntas reto que asegura el aprendizaje de los conceptos, así como estimular la imaginación y generación de preguntas. Esto lo consideramos necesario, pues el sistema tradicional de enseñanza solamente impulsa a los estudiantes a responder, calcular o hallar incógnitas (como “hallar X”). Esto posibilita a que los estudiantes a futuro puedan argumentar más fácilmente sus ideas con fundamentos sólidos; así como experimentar y comprobar la efectividad del trabajo en equipo.<br/><br/>Además, los análisis realizados mostraron que el profesor, que sigue el manual de uso de ProfePlus y sigue el protocolo planteado, a diferencia del uso del método tradicional, genera que sus estudiantes consideren mejor a su profesor por: (1) su calidad de enseñanza, (2) incrementar los conocimientos y competencias de sus estudiantes en la clase, (3) su uso de preguntas o mención a situaciones que despiertan el interés, (4) mostrar interés por el progreso en el aula, (5) incrementar su interés en el área del curso; entre otros.<br/><br/>
	</div>

	</br>
	<div><a href="#" id="student"><b>Beneficios para los estudiantes</b></a></div>
	<div id="student-content" oncopy="return false;">
	Los estudiantes, de cualquier nivel o disciplina, usando ProfePlus, además de mejorar el aprendizaje de conceptos, podrán sentirse más confiados en el desarrollo de competencias que son consideradas clave en el siglo XXI, como el trabajo en equipo, participación en proyectos, aprendizaje autónomo, entre otras.<br/><br/>Aplicando ProfePlus facilitamos mayor participación del estudiante en la clase y de manera anónima. ¿Cómo? Cuando el profesor plantea una pregunta en el aula e invita a los estudiantes a brindar sus opiniones, muchas veces los estudiantes no comunican sus verdaderas opiniones, ya sea por temor a críticas o para evitar ser tildado de mal estudiante por sus compañeros de clase o el profesor. Por ello, ProfePlus permite que los estudiantes envíen sus respuestas de manera anónima a las preguntas planteadas por profesor, tanto luego de un análisis individual (paso 1) y luego de un trabajo en equipo con su par (paso 2).<br/><br/>El uso de ProfePlus hace que una clase con métodos tradicionales de enseñanza se vuelva más dinámica. Esto se logra en el paso 2, en el trabajo en equipo (basado en la instrucción por pares). El trabajo en equipo implica dos preguntas reto que solidifican los conceptos y estimula la generación de competencias que le facilitará argumentar mejor sus ideas y trabajar en equipo. Esta interacción posibilita aumentar la red de contactos y lazos de amistad, rompiendo hielo rápidamente. Si consideramos que todos tenemos sueños por lograr en nuestras vidas, estos se materializarán más fácilmente si contamos con una red de contactos y amigos grande; y muchos de ellos se generan en los salones de clase.<br/><br/>
	</div>
	
	</br>
	<div><a href="#" id="society"><b>Beneficios para la sociedad</b></a></div>
	<div id="society-content" oncopy="return false;">
	La sociedad necesita ciudadanos que generen e impulsen innovación. Esto es palpable, y comprendamos por innovación a todo aquello que implique la implementación de una creación o mejora de un producto o servicio que genere una mejora sustancial. Esta mejora puede realizarse en una organización, pública o privada, a beneficio de la sociedad.<br/><br/>Ahora, ¿de dónde salen los innovadores?  Las innovaciones implican implementar cambios que generen mejoras, que agreguen valor. En muchos ámbitos (como el contexto educativo) es comúnmente difícil hacer realidad los cambios que necesitamos. ¿Los cambios que agregan valor son producto de alguna “mano invisible”? Nosotros creemos que no, pues los cambios son producidos por personas; y en ámbitos difíciles y que encierran inclusive peligro. Estas personas, para lograr dicho fin, para implementar los cambios que necesita la sociedad, deben ser considerados por sus pares como líderes. Sí, líderes. Es decir, para generar innovación (que en sí es implementar cambios que agreguen valor) es necesario contar con líderes, que convenzan con sus acciones e ideas a hacer realidad los cambios que se necesitan.<br/><br/>¿De dónde salen los líderes? Existen diversas e innumerables investigaciones que puede responder esta pregunta. Nosotros creemos que para generar los líderes que necesitamos, es necesario que los estudiantes culminen sus estudios con competencias que les faciliten liderar. Que sepan trabajar en equipo, que se comuniquen apropiadamente, fundamentando sus ideas y opiniones. Que se atrevan a enfrentar situaciones difíciles. Hacer frente a ello es lo que definimos como emprendimiento.<br/><br/>El emprendimiento es hacer realidad cualquier acción o proyecto, especialmente si encierra dificultad o peligro. Esto está abierto a cualquier ámbito de emprendimiento, sea social, cultural o empresarial. Es decir, para forjar innovación, es necesario contar con líderes. Para contar con líderes, es necesario estimular el emprendimiento.<br/><br/>Las personas que emprenden están confiadas en sus competencias de trabajo en equipo y participación en proyectos; y son estas competencias las que son trabajadas en ProfePlus. Confiamos, de este modo, que contribuiremos a la sociedad con ciudadanos confiados en emprender y capaces de innovar. Sí es posible.<br/><br/>
	</div>
	
	<br/>
	<br/>

</div>
</div>
<script>  $(document).ready(function(){  $("#back-icon").attr("href", "{{ url('/web/info-list/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}"); $("#exit-icon").attr("href", "{{ url('/web/info-list/'.$userid.'/'.$mode.'/'.$type.'/'.$code) }}");  var vis1 = false; var vis2 = false; var vis3 = false;  $("#teacher-content").css("display","none"); $("#student-content").css("display","none"); $("#society-content").css("display","none");  $("#teacher").on("click", function() { vis1 = !vis1; if (vis1){ $("#teacher-content").css("display","inline"); $("#student-content").css("display","none"); $("#society-content").css("display","none"); } else { $("#teacher-content").css("display","none"); }  });  $("#student").on("click", function() { vis2 = !vis2; if (vis2){ $("#student-content").css("display","inline"); $("#teacher-content").css("display","none"); $("#society-content").css("display","none"); } else { $("#student-content").css("display","none"); }  });  $("#society").on("click", function() { vis3 = !vis3; if (vis3){ $("#society-content").css("display","inline"); $("#teacher-content").css("display","none"); $("#student-content").css("display","none"); } else { $("#society-content").css("display","none"); }  });  });  </script>  




@stop



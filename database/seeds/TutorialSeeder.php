<?php

use Illuminate\Database\Seeder;
use App\Tutorial;

class TutorialSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Eloquent::unguard();
        DB::table('profeplus_tutorials')->delete();
        
        Tutorial::create(array(
        'title' => '',
        'content' => '',
        'title_es' => '<b>INTRODUCCIÓN</b>|<b>ACCIÓN 1:<br/>Programar el Smartphone o Tablet del profesor para que no se apague
	rápido.</b> | <b>ACCIÓN 2:<br/>Indicar a los estudiantes la contraseña de acceso al Internet del aula
	y cómo entrar a ProfePlus.</b> | <b>ACCIÓN 3:<br/>Exponer el primer día de clase la importancia de usar ProfePlus en el
	aula.</b> | <b>ACCIÓN 4:<br/>Iniciar el uso de ProfePlus con solamente un ejercicio por clase.</b> | <b>ACCIÓN 5:<br/>Aprovechar el Paso 1 para reforzar conceptos, leyendo en voz alta la pregunta de la diapositiva.</b> | <b>ACCIÓN 6:<br/>Comprender la importancia de ejecutar el paso 2.</b> | <b>ACCIÓN 7:<br/>Tomar decisión según el gráfico de respuestas.</b> | <b>ACCIÓN 8:<br/>Facilitar soluciones a quienes no puedan usar ProfePlus por distintos motivos.</b> | <b>ACCIÓN 9:<br/>Considerar el lenguaje no verbal para innovar en la enseñanza.</b> | <b>ACCIÓN 10:<br/>Alentar la participación de los estudiantes y su instinto creativo en
	el curso (y evitar usar palabras poco positivas).</b>',
        'content_es' => ' Este protocolo consta de diez acciones y se ha elaborado para asegurar el
incremento de conocimientos y competencias de los estudiantes.
<br/><br/>Para ello, nos hemos basado en diversos análisis de la
metodología de instrucción por pares, los resultados
de las clases piloto con el uso de esta herramienta informática, y la apreciación del
equipo de profesionales inmersos en esta propuesta de innovación docente. Los archivos
que se mencionan pueden descargarse de la Web:
<a href="">www.e-quipu.pe/ProfePlus</a>
<br/><br/>Finalmente, comente
su experiencia a colegas de su misma u otras áreas, y anímelos también a innovar en la
docencia; con el fin de forjar profesionales con mejores capacidades y competencias' | 'Es recomendable que el docente programe su Smartphone o Tablet con el fin de
mantener su pantalla encendida, pues durante la clase debe tener control del monitoreo
de respuestas.<br/><br/>Para ello se recomienda ingresar a la pestaña "Aplicaciones" y buscar
el ícono del engranaje que indique "Ajustes o Configurar"; y allí se debe elegir la
opción "Pantalla".  Seguidamente, ubique la opción "Límite de tiempo de pantalla"
o "Suspender la inactividad" y elija "10 minutos" o más (en caso exista podría elegir
"Nunca" y lo bloquea presionando el botón de encendido). | Escriba en la pizarra la contraseña wi-fi del aula. Luego,
indique a los estudiantes que podrán usar ProfePlus a
través del App en Google Play (sólo para Android) o
ingresando a la Web
<a href="">www.e-quipu.pe/ProfePlus</a>.
<br/><br/>Luego, el profesor debe abrir la
presentación de diapositivas "Bienvenidos a ProfePlus"; la cual muestra fácilmente
a los estudiantes cómo ingresar a este App. El avance de la presentación es
automática y solamente debe mostrarse por 5 minutos (luego debe abrirse el PDF
"Conociendo el Método ProfePlus").
<br/><br/>El uso de esta herramienta informática propicia
que los estudiantes asuman un rol más activo a través de dos pasos para responder
una pregunta planteada por el profesor. El paso 1 es la respuesta individual;
y el paso 2 es el trabajo en equipo. | Diversos estudios de la metodología de instrucción por pares coinciden en la
importancia de exponer a los estudiantes, desde el inicio de la asignatura, este
método de enseñanza y sus impactos positivos; y mejor aún si lo experimentan con
un ejercicio.
<br/><br/>Por ello, debe presentar en el aula el archivo PDF "Conociendo
ProfePlus - Básico", en caso sea para educación primaria o secundaria; o "Conociendo
ProfePlus – Superior", en caso sea para educación superior. El profesor debe revisar
este archivo antes de presentarlo en la clase, cuya duración tomará máximo 25 minutos.
<br/><br/>Invite a los estudiantes a dar su máximo esfuerzo en este curso y en su vida; y que
se comprometan a ello por su propio honor; brindando no solamente "buenos resultados",
sino que además siempre aspiren a generar "resultados sobresalientes". | Es mejor empezar a usar esta metodología con un sólo ejercicio por clase, con
el fin de acostumbrar a todos los estudiantes a los dos pasos; donde el paso 1 es la
intervención individual del estudiante, y el paso 2 es el trabajo en equipo en el
aula.
<br/><br/>Se propone esto pues el tiempo que puede tomar al profesor familiarizarse
con esta herramienta informática puede tomar unas clases; y es mejor iniciar de
poco a mucho; conociendo así las preguntas más frecuentes y las posibles dudas de
los estudiantes; e inclusive, algún tema de infraestructura que sea necesario afinar
o coordinar con los responsables de su institución educativa.
<br/><br/>Se puede acceder a
ProfePlus desde un Smartphone, Tablet o laptop, ya sea a través del App (en sistema
operativo Android) o por la Web:
<a href="">profeplus.e-quipu.pe</a> | El paso 1 implica la participación individual de los estudiantes. En esta etapa,
para que asimilen más la pregunta planteada, recomendamos a los docentes leerles el
texto que se presente en la pantalla.
<br/><br/>Asimismo, pueden incidir un poco más en la
pregunta, ya que es posible que no se explique todo en el texto de la diapositiva.
Por ejemplo, comentarles en qué contexto la pregunta planteada se aplica según la
experiencia del profesor o brindarles información adicional para fomentarles la
curiosidad por investigar más.
<br/><br/>El tiempo estimado para el paso 1 lo definirá el
profesor; según la dificultad o complejidad de la pregunta planteada.
<br/><br/>Para conocer
más sobre cómo aplicar el paso 1, revise el "Manual de Uso". También recomendamos
revisar "Cómo crear un banco de preguntas". | El paso 2 implica que los estudiantes trabajen en equipo, con el fin que lleguen
a la respuesta correcta, conversando y argumentando sus posiciones (basado en la
metodología de instrucción por pares).
<br/><br/>Asimismo, ayuda fuertemente a generar
competencias de trabajo en equipo, participación en proyectos, aprendizaje autónomo,
respeto ético a las ideas del compañero y capacidad crítica.; y ayudarán a los
estudiantes a emprender proyectos de investigación u otras temáticas, apoyándoles
en sus capacidades comunicativas. Es por ello que principalmente recomendamos que
siempre se practiquen los dos pasos.
<br/><br/>Acá los estudiantes deben hacerse las preguntas
reto: (i) ¿Qué concepto de esta lección fundamentó tu respuesta?; y (ii)
¿Y qué pasaría si…?
<br/><br/>La pregunta "(i)" busca que los estudiantes enlacen los
conceptos del curso con sus aplicaciones. La pregunta "(i)" contribuye a ampliar
la imaginación de los estudiantes. | En los pasos 1 y 2 el profesor puede apreciar en un gráfico las respuestas
de los estudiantes; sin poder acceder a las respuestas individuales (excepto en
las evaluaciones calificadas). Según las investigaciones realizadas para esta
herramienta informática, los estudiantes se sentirán más confiados en responder
con total libertad al saber que no están siendo evaluados individualmente;
mientras que si creen que estarían siendo evaluados en el aula, se sentirían
tentados a copiar de otro estudiante).
<br/><br/>Si en el paso 1 el gráfico de respuestas
indica que menos del 70% de los estudiantes contestó correctamente, lo más
apropiado será iniciar el paso 2 (trabajo en equipo).
<br/><br/>En el paso 2, si más del 70%
respondió la alternativa correcta, se puede considerar avanzar con el siguiente
concepto que debe enseñarse. Caso contrario, realice otras preguntas sobre ese
mismo concepto hasta lograr superar el 70% de respuestas correctas. | En caso el estudiante haya ingresado al App, pero luego tenga inconvenientes y
comente "no puedo entrar nuevamente", "el código no ingresa", u otro similar; el
profesor puede indicarle “salga por completo de la sesión e ingrese otra vez” u otra
frase similar.
<br/><br/>No debe obligarse a los estudiantes a adquirir un equipo; pero
sí enfatizar las ventajas en aprendizaje de conceptos y competencias con el uso
de esta herramienta informática; esperando que ellos mismos asistan con un equipo
propio para la siguiente sesión.
<br/><br/>Para los estudiantes que no tengan sus equipos
en el aula, el profesor puede invitar a quienes sí los tengan a que, luego de enviar
sus respuestas, presten sus equipos a sus compañeros para que ellos también puedan
participar. Empero, el profesor debe considerar el tiempo que toma. | Una característica que ayudará al profesor a innovar en el aula será su capacidad
para tener empatía con los estudiantes; y consideramos que esto será promovido
mostrando mayor dinámica en el salón de clase.
<br/><br/>Comúnmente en muchas cátedras los
docentes permanecen sentados y solamente se mueven en la línea de la pizarra, no
logrando conectarse con los estudiantes que estén ubicados en las últimas filas.
<br/><br/>Por ello, es recomendable movilizarse por el pasillo y generar contacto visual con
los estudiantes (más aún en el paso 2, en la instrucción por pares).
<br/><br/>En caso sea posible, el profesor podría usar puntero
 láser para presentar sus diapositivas. | En la mayoría de veces, la mejor forma de aprender es haciendo preguntas que
cuestionen lo común. Sin embargo, cuando el ambiente es de total complacencia al
docente, sin participación activa, lo único que se generará es "repetidores" y
"memoristas". Por ello, tratemos de evitar las siguientes frases: "No tengo tiempo",
"esto es muy difícil", "esto es complicado", "(en el paso 2) deben convencer de su
idea a su compañero a toda costa", "no tenemos tiempo para profundizar en esto".
<br/><br/>No nos amarguemos ni generemos esa percepción en los estudiantes cuando ellos realicen
preguntas. Para evitar lo anterior, cuando un estudiante realiza una pregunta no
debe respondérsele con frases como "¿por qué pregunta eso?", "¡pero si es tan obvio!".
Recordemos el adagio popular "no somos responsables de la cara que tenemos, pero sí
de la que ponemos".
<br/><br/>Inclusive, no señale a los estudiantes que preguntan
("cuando un dedo señala a alguien, hay otros tres que lo señalan a uno").
<br/><br/>Cuando explique algún concepto que es importante para los estudiantes, use las siguientes
frases: "esto es muy importante", "esta parte es clave", "en otras instituciones esto
no es tomado en cuenta, pero es importante porque…".
<br/><br/>Anime a los estudiantes cuando pregunten, respondiéndoles así:
"¡buena pregunta!", "¡me alegra que te hayas dado
cuenta de esto!", "¡excelente punto de vista!", "¡qué bien que me pregunten esto!".
De esta manera, también animará a otros a participar.
<br/><br/>Cuando un estudiante realice
una pregunta que pareciera obvia para sus compañeros o usted, no lo desanime. Mejor,
conteste con las siguientes frases: "cuando yo era estudiante, también pensaba así,
y luego me di cuenta de lo siguiente…"; "la mayoría comete este error, pero nosotros
no debemos cometerlo", "por supuesto, muchos piensan así pues no se aclaran algunos
conceptos, pero ahora mismo aclararemos este tema…". Si los compañeros se ríen de
la pregunta, coménteles un antiguo proverbio chino: "pregunta lo que no sepas y
pasarás por tonto unos minutos; no lo preguntes, y serás tonto la vida entera".',
        'images' => 'docente1.png|docente3.png|docente3.png|docente4.png|docente5.png||||||',
        ));
        
       
	}

}
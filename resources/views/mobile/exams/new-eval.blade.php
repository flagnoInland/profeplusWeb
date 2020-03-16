@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/exam.min.css')}}" rel="stylesheet" type="text/css">
<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script-->
<script src="{{asset('js/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{asset('js/additional-methods.js')}}" type="text/javascript"></script>
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container">
<br/>

<div class="container frameqtn" id="step-1"><!--Start step 1-->

  <div class="container"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">Ingrese el puntaje total</div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <input type="text" name="score" id="score" class="form-group-ex text-center" maxlength="3"/>
    </div>
  </div>
    
  <div class="container"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">Ingrese el número de preguntas</div>	
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <input type="text" name="question" id="question" class="form-group-ex text-center" maxlength="2"/>
    </div>
  </div>

  <div class="container"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">Duración de la evaluación (minutos)</div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <input type="text" name="duration" id="duration" class="form-group-ex text-center" maxlength="3"/>
    </div>
  </div>

  <div class="container"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
    Las preguntas serán de cinco alternativas (A, B, C, D y E) o también de dos (Verdadero y Falso).)
    </div>
  </div>

  <div class="container"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button id="go-step2" class="btn btn-lg btn-gopage btn-block">SIGUIENTE</button>
    </div>
  </div>

</div><!--div step 2-->

<div class="container frameqtn" id="step-2" style="visibility: hidden;"><!--Start step 2-->
	
  <!--div class="container form-group-lg"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Nombre de la asignatura
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <textarea name="course" id="course" class="form-control text-center" rows="1"></textarea>
    </div>
  </div-->
  
  <div class="container form-group-lg"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Nombre de la asignatura
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <div class="mytextarea h5">
            <div name="course" id="course" contenteditable="true" style="outline: none; word-wrap: break-word;"><br/></div>   
        </div>          
    </div>
  </div>

  <!--div class="container form-group-lg"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Opcional: Nombre de la Facultad o Especialidad de esta asignatura
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <textarea name="speciality" id="speciality" class="form-control text-center" rows="1"></textarea>
    </div>
  </div-->
  
  <div class="container form-group-lg"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Opcional: Nombre de la Facultad o Especialidad de esta asignatura
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <div class="mytextarea h5">
            <div name="speciality" id="speciality" contenteditable="true" style="outline: none; word-wrap: break-word;"><br/></div>   
        </div>          
    </div>
  </div>

  <!--div class="container form-group-lg "><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Opcional: Nombre de la universidad o instituto
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <textarea name="institute" id="institute" class="form-control text-center" rows="1"></textarea>
    </div>
  </div-->
  
  <div class="container form-group-lg"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Opcional: Nombre de la universidad o instituto
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <div class="mytextarea h5">
            <div name="institute" id="institute" contenteditable="true" style="outline: none; word-wrap: break-word;"><br/></div>   
        </div>          
    </div>
  </div>

  <!--iv class="container form-group-lg"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Opcional: Título de la evaluación (Ej.: Examen 1, otro)
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <textarea name="examen" id="examen" class="form-control text-center" rows="1"></textarea>
    </div>
  </div-->
  
  <div class="container form-group-lg"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Opcional: Título de la evaluación (Ej.: Examen 1, otro)
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <div class="mytextarea h5">
            <div name="examen" id="examen" contenteditable="true" style="outline: none; word-wrap: break-word;"><br/></div>   
        </div>          
    </div>
  </div>

  <div class="container"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button id="go-step3" class="btn btn-lg btn-gopage btn-block">SIGUIENTE</button>
    </div>
  </div>

</div><!--div step 2-->

<div class="container frameqtn" id="step-3" style="visibility: hidden;"><!--Start step 3-->
	
  <div class="container form-group-lg"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Indicaciones que desee incluir en la evaluación.
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <div class="mytextarea h5">
            <div id="observation" contenteditable="true" style="outline: none; word-wrap: break-word;"><br/></div>   
        </div>          
    </div>
  </div>


  <div class="container form-group-lg"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      Materiales que se usarán
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-left">
      <div class="checkbox">
        <label><input type="checkbox" value="calculadora" name="item1"/>Calculadora</label>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-left">
      <div class="checkbox">
        <label><input type="checkbox" value="apuntes de clase" name="item2"/>Apuntes de clase</label>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-left">
      <div class="checkbox">
        <label><input type="checkbox" value="libros" name="item3"/>Libros</label>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-left">
      <div class="checkbox">
        <label><input type="checkbox" value="computadora personal" name="item4"/>Computadora personal</label>
      </div>
    </div>
  </div>

  <div class="container"><br/>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button id="go-step4" class="btn btn-lg btn-gopage btn-block">SIGUIENTE</button>
    </div>
  </div>

</div><!--div step 3-->

<div class="container frameqtn" id="step-4" style="visibility: hidden;"><!--Start step 4-->

  <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <h5>INGRESE EL SOLUCIONARIO</h5>
    </div>
  </div>

  <div class="container frame0qtn2 frameexam">
    <div class="col-xs-8 col-sm-8 col-md-8">
      <h5>Claves</h5>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 text-center">
      <h5>Puntaje</h5>
    </div><!--end score number-->
  </div>


  <div id="question-container">

  </div>

  <div class="container frameqtn2 frameexam">
    <div class="col-xs-8 col-sm-8 col-md-8 text-center form-group-lg">
      <h5>Puntaje Total</h5>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 text-right form-group-lg">
      <input type="text" name="totals" id="totals" class="form-control text-center" maxlength="3"/>
    </div>
  </div><br/>

  <div class="container">
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button id="go-code" class="btn btn-lg btn-gopage btn-block">TERMINAR</button>
    </div>
  </div>

</div><!--div step 4-->


<div class="container" id="step-5" style="visibility: hidden;"><!--Start step 5-->
    
  <div class="container frameqtn">
        
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <!--h5><div id="title" style="margin: auto; width:60%;"></div></h5-->
      <div class="h6" style="color:#f00;">
        Solicite a sus estudiantes que ingresen a “Evaluación calificada” 
        (botón de color naranja). Luego, indíqueles la clave que aparece 
        debajo para que inicien su evaluación 
        (le recomendamos copiar en la pizarra la clave).
      </div>
    </div>
	
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <div id="accesscode" class="accesscode-box"></div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button id="to-evalList" class="btn btn-lg btn-gopage btn-block">
        INICIAR EVALUACIÓN CALIFICADA
      </button>
      <a href="{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/1') }}" class="btn btn-lg btn-gopage-ii btn-block">
        CANCELAR
      </a>
    </div>

  </div>
	
</div><!--div step 5-->

</div><!--div container-->

<div id="modal-score" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="text-center">
          <h6><b>Error. El resultado de la división entre el puntaje total y 
            el número de pregunta debe tener un número de decimales 0.0 o de 0.5.
            Por favor, modifique dichos datos.</b></h6><br/>
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-narrow h6" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-failure" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="text-center">
          <h5>Debe colocar puntajes numéricos.</h5><br/>
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-narrow h6" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>



<script>
$(document).ready(function(){
	
    $("#exit-icon").attr("href", "{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/1') }}");
    $("#back-icon").click(function(){
      window.history.back();
    });

    $("#step-1").css("display","block");
    $("#step-2").css("display","none");
    $("#step-3").css("display","none");
    $("#step-4").css("display","none");
    $("#step-5").css("display","none");
	
	
    var nqtns = 0;
    var total = 0;
    var sameScore = true;
    var duration = 30;
    var course = "sin curso";
    var speciality = "sin especialidad";
    var institute = "sin instituto";
    var examen = "sin título";
    var observation = "sin observaciones";
    var mats = ["materiales"];
    var typs = [];
    var scrs = [];
    var ans = [];
    var code = 0;
    var allCheck = 0;
    var lessonId = 0;

    //updateUI(4);

    $("#go-step2").click(function(){
      
      if (hasDuration() + hasQuestion() + hasScore() == 3){
        allCheck = nqtns;
        var newTotal = 0;
        var mScore = total/nqtns;
        var scoreGood = (mScore*10) % 5           
        if (scoreGood == 0){
          for (i=0; i<nqtns; i++){
            scrs[i]= mScore;
            newTotal = newTotal + scrs[i];
          }
          total = newTotal;
          updateUI(1);
        } else {
          $("#modal-score").modal("show");
        }
      }       
    });
		
    $("#go-step3").click(function(){
	  insti = $("#institute").text();
	  if (insti.length > 0) {
		  institute = insti;
	  }
		spec = $("#speciality").text();
		if (spec.length > 0){
			speciality = spec;
		}
      exa = $("#examen").text();
		if (exa.length > 0){
			examen = exa;
		}
      if (hasCourse()) {
        updateUI(2);
      }	
    });
		
    $("#go-step4").click(function(){
       obse = $("#observation").text();
		if (obse.length > 0){
			observation = obse;
		}
      mats = ["materiales"];
      for ( i=1; i<5; i++){
        setItem(i);
      }
      //alert(mats);
      updateUI(3);
    });
    
    function setItem(num){
      if ( $('input[name="item'+num+'"]').is(":checked") ) {
        mats.push($('input[name="item'+num+'"]').val());
      }
    }
	
    $("#go-code").click(function(){
      if (allCheck == nqtns) {
        prepareExam();
      } else {
        $("modal-failure").modal("show");
      }
    });

    $("#to-evalList").click(function(){
      startExam();
    });
	
    function prepareExam(){
      var myExam = {
        'user_id' : {{ $user_id }},
        'number_question' : nqtns,
        'overall_score' : total,
        'duration' : duration,
        'course_name' : course,
        'speciality' : speciality,
        'institution' : institute,
        'exam_title' : examen,
        'observations' : observation,
        'materials' : mats.toString(),
        'answer_keys' : ans.toString(),            
        'answer_weights' : scrs.toString(),
        'answer_types' : typs.toString(),
        'eval_type' : 1
      };
      $.ajax({
        type: "POST",
        url: "{{url('/web/exam/teacher')}}"+'/'+{{$user_id}}+'/new',
        dataType: "json",
        contentType : 'application/json',
        data: JSON.stringify(myExam),
        success: function(data, status) {
          lessonId = data['lesson_id'];
          code = data['code'];
          updateUI(4);
        } 
      });
    }
    
    function startExam(){
      $.ajax({
        type: "POST",
        url: "{{url('/web/exam/teacher')}}"+'/'+{{$user_id}}+'/start/'+lessonId,
        contentType : 'application/json',
        success: function(data, status) {
          //window.location.replace("{{ url('web/exam/teacher/'.$user_id.'/'.$mode.'/board') }}");
          window.location.replace("{{ url('web/exam/teacher/'.$user_id.'/'.$mode.'/board/lesson') }}"+'/'+lessonId);
        } 
      });
    }
	
    function hasCourse(){
      course = $("#course").text();
      if (course != ""){
        return true;
      } else {
        return false;
      }
    }
	
    function hasDuration(){
      duration = $("#duration").val();
      var ptn1 = new RegExp("[^0-9]");
      if ( ptn1.test(duration) || duration == "" ){
        $(".duration-error").remove();
        $("#duration").parent().append('<div class="duration-error error-msg p">Ingrese un número</div>');
        return 0;
      } else {
        $(".duration-error").remove();
      }
      return 1;
    }
	
        
    function hasQuestion(){
      nqtns = $("#question").val();  
      var ptn1 = new RegExp("[^0-9|.]");
      if ( ptn1.test(nqtns) || nqtns == "" ){
        $(".question-error").remove();
        $("#question").parent().append('<div class="question-error error-msg p">Ingrese un número</div>');
        return 0;
      } else {
        $(".question-error").remove();
      }
      return 1;
    }
    
    
    function hasScore(){
      total = 1.0*$("#score").val();      
      var ptn1 = new RegExp("[^0-9|.]");
      if ( ptn1.test(total) || total == "" ){
        $(".score-error").remove();
        $("#score").parent().append('<div class="score-error error-msg p">Ingrese un número</div>');
        return 0;
      } else if (total > 100){
        $(".score-error").remove();
        $("#score").parent().append('<div class="score-error error-msg p">Puntaje máximo es 100</div>');
        return 0;
      } else {
        $(".score-error").remove();
      }
      return 1;
    }
    
	
    function updateUI(page){
      upCourse();
      upInstitute();
      upSpeciality();
      upExam();
      upNqtns();
      upDuration();
      upTotal();
      $("#back-icon").off();
      var pageUp = page + 1;
      $("#step-"+page).css("visibility","hidden");
      $("#step-"+pageUp).css("visibility","visible");
      $("#step-"+page).css("display","none");
      $("#step-"+pageUp).css("display","block");
      $("#back-icon").click(function(){
        $("#step-"+page).css("visibility","visible");
        $("#step-"+pageUp).css("visibility","hidden");
        $("#step-"+page).css("display","block");
        $("#step-"+pageUp).css("display","none");
        if (page>0){
          updateUI(page-1)	
        } else {
          window.history.go(-2);
        }
      });
      if (page==3){
        preparePageQuestion();
      }
      if (page==4){
        preparePageCode();
      }
    }
	
    function preparePageCode(){
      $("#back-icon").click(function(){});
      //$("#title").html(course);
      $("#accesscode").html(code);
    }
	
    function preparePageQuestion(){
      var scoreSame = 0;
      $("#question-container").html("");
      $("#totals").val(total.toFixed(1));
      var ptn1 = new RegExp("[^0-9|.]");
      for (i=0; i<nqtns; i++){
        $("#question-container").append(createQuestion(i+1, scrs[i]));
      }
      for (i=0; i<nqtns; i++){
        scrs[i] = parseFloat($("#scr"+(i+1)).val());
        ans[i] = parseFloat($("#qtn"+(i+1)+" :selected").val());
        if ( ans[i]==6 || ans[i]==7 ){
          typs[i] = 2;
        } else {
          typs[i] = 1;
        }
      }
      $(".qtn-ctrl2").keyup(function(){
        total = 0;
        allCheck = 0;
        for (i=0; i<nqtns; i++){
          var value = $("#scr"+(i+1)).val();
          if ( ptn1.test(value) || value == "" ){
            $(".scr-error"+(i+1)).remove();
            $("#scr"+(i+1)).parent().append('<div class="scr-error'+(i+1)+' error-msg p">Sólo números</div>');
          } else {
            if ((value*10 % 5) == 0){
              $(".scr-error"+(i+1)).remove();
              scrs[i] = parseFloat(value);
              total = total + scrs[i];
              allCheck = allCheck + 1;
            } else {
              $(".scr-error"+(i+1)).remove();
              $("#scr"+(i+1)).parent().append('<div class="scr-error'+(i+1)+' error-msg p">(#.0 ó #.5)</div>');
            }
          }
          console.log(scrs);
        };
        $("#totals").val(total.toFixed(1));
      });
      $(".qtn-ctrl").change(function(){
        for (i=0; i<nqtns; i++){
          ans[i] = parseFloat($("#qtn"+(i+1)+" :selected").val());
          if ( ans[i]==6 || ans[i]==7 ){
            typs[i] = 2;
          } else {
            typs[i] = 1;
          }
          console.log(ans);
          console.log(typs);
        };
      });
    }
	
    function createQuestion(num, score){
      var template = '<div class="container frameqtn2 frameexam">'+
      //'<div class="col-xs-6 col-sm-6 col-md-6 form-group-lg">'+
      '<div class="col-xs-8 col-sm-8 col-md-8 form-group-lg">'+
      '<div class="num-container"><div class="framenumber2">ZZZ</div></div>'+
      '<select class="form-control qtn-ctrl" id="qtnZZZ">'+
        '<option value="1">A</option>'+
        '<option value="2">B</option>'+
        '<option value="3">C</option>'+
        '<option value="4">D</option>'+
        '<option value="5">E</option>'+
        '<option value="6">V</option>'+
        '<option value="7">F</option>'+
      '</select>'+
      '</div>'+
      //'<div class="col-xs-2 col-sm-2 col-md-2 text-center"><div class="num-container">'+
      //'<h4>Ptj:</h4>'+
      //'</div></div>'+
      '<div class="col-xs-4 col-sm-4 col-md-4 text-right form-group-lg">'+
      '<input type="text" value="QQQ" name="scrZZZ" id ="scrZZZ" class="form-control qtn-ctrl2 text-center" maxlength="4"/>'+
      '</div>'+
      '</div><br/>';
      var res = template.replace(/ZZZ/g, num);
      return res.replace(/QQQ/g, score.toFixed(1));
    }
    
    function upInstitute(){
      if (institute != ""){
        $("#institute").text(institute);
      }
    }
    
    function upSpeciality(){
      if (speciality != ""){
        $("#speciality").text(speciality);
      }
    }
    
    function upCourse(){
      if (course != ""){
        $("#course").text(course);
      }
    }
    
    function upObservation(){
      if (observation != ""){
        $("#observation").text(observation);
      }
    }
    
    function upExam(){
      if (examen != ""){
        $("#examen").text(examen);
      }
    }
    
    function upNqtns(){
      if (nqtns != ""){
        $("#question").text(nqtns);
      }
    }
    
    function upTotal(){
      if (total != ""){
        $("#score").text(total);
      }
    }
    
    function upDuration(){
      if (duration != ""){
        $("#duration").text(duration);
      }
    }

});
</script>

@stop



@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/exam.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/additional-methods.js"></script> 
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container">
<br/>

<div class="container frameqtn" id="step-1"><!--Start step 1-->

  <div class="container">
    <div class="h5 col-xs-12 col-sm-12 col-md-12 text-center">
      EVALUACIONES REALIZADAS
    </div>
  </div>

  <div id="exam-list"></div>

</div><!--div step 1-->

</div>


<script>
$(document).ready(function(){
	
    $("#exit-icon").attr("href", "{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/1') }}");
    $("#back-icon").click(function(){
      window.history.back();
    });
        
    $("#finish").css("display","block");
    $("#email").css("display","none");
    $("#update").css("display","none");
    $("#exam-stat").css("display","none");
    
   
    cleanItems();
    
    setTimeout(function () { 
      resetPage();
    }, 200);
    
    
    var cardLabel = "";
    var evalType = 1;
    var lessonId = 0;
    var evalId = 0;
    var exams = [];
    var examView;
    var endTime, remain;
    var hours, seconds, minutes;
    var hasFinish = false;
    

    function prepareListItems(){
      $.ajax({
        type: "GET",
        url: "{{url('/web/exam/teacher')}}"+'/'+{{$user_id}}+'/index',
        contentType : 'application/json',
        success: function(data, status) {
          exams = data;
          makeItemButtons();
        } 
      });
    }

    function resetPage(){
      $("#step-1").css("display","block");
      $("#step-2").css("visibility","hidden");
      prepareListItems();
    }
    
    function cleanItems(){
      $.ajax({
        type: "POST",
        url: "{{url('/web/exam/teacher')}}"+'/'+{{$user_id}}+'/cleanExam',
        contentType : 'application/json',
        success: function(data, status) {
        } 
      });
    }

    function makeItemButtons(){
      $("#exam-list").empty();
      for ( i=0; i<exams.length; i++){
        if (exams[i].visibility == 1) {
          var exam = new Exam(exams[i].id, exams[i].lesson_id, exams[i].exam_title, 
          exams[i].date, exams[i].time, exams[i].course, exams[i].type, exams[i].status)
          var template = '<div class="container"><div class="col-xs-12 col-sm-12 col-md-12 text-center">'+
          '<button id="idx" name="lessonId" class="btn btn-lg btn-gopage btn-block">course</button>'+
          '</div></div>';
          var template2 = '<div class="container"><div class="col-xs-12 col-sm-12 col-md-12 text-center">'+
          '<button id="idx" name="lessonId" class="btn btn-lg btn-gopage-iii btn-block">course</button>'+
          '</div></div>';
          var res = template.replace(/lessonId/g, exam.lessonId);
          if (exam.status == 1){
            res = template2.replace(/lessonId/g, exam.lessonId);
          } 
          res = res.replace(/idx/g, i);
          var label = [];
          if (exam.course != ""){
            label.push(exam.course);
          }
          if (exam.title != ""){
            label.push(exam.title);
          }
          var newLabel = label.toString();
          $("#exam-list").append(res.replace(/course/g, newLabel.replace(',','<br/>')));
          $("#"+i).click(function(){
              var x = $(this).attr('id');
              var exam = new Exam(exams[x].id, exams[x].lesson_id, exams[x].exam_title, 
                  exams[x].date, exams[x].time, exams[x].course, exams[x].type, exams[x].status);            
              cardLabel = newLabel;
              evalId = exam.id;
              lessonId = $(this).attr('name');
              window.location.href = "{{url('/web/exam/teacher')}}"+'/'+{{$user_id}}
                      +'/'+{{$mode}}+'/board/lesson/'+lessonId;                
          });	
        }
      }
    }
    

    function Exam(eval, id, title, date, time, course, type, status) {
      this.id = eval;
      this.lessonId = id;
      this.title = title;
      this.date = date;
      this.time = time;
      this.type = type;
      this.course = course;
      this.status = status;
    }

		
});
</script>


@stop



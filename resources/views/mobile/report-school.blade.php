@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/report.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container">

	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
	
		<div>
		<br/>
		<h5>@lang('labels.text_complete_report_title')</h5>
		</div>
	
		<br/>
		
		<div class="form-group-lg" id="level-box">
		<label for="level">Nivel:</label>
		<select name="level" id="level" 
                   class="form-control">
		  <option value="1ro">Primaria</option>
		  <option value="2do">Secundaria</option>
		</select>
		</div>
		
		<br/>
		
		<div class="form-group-lg" id="grade-box">
		<label for="grade">Grado:</label>
		<select name="grade" id="grade" 
                   class="form-control">
		</select>
		</div>
			
		<br/>
		
		<div class="form-group-lg" id="section-box">
		<label for="section">Sección:</label>
		<input type="text" name="section" id="section" 
			   class="form-control-input"/>
		</div>
			
		<br/>
		
		<div class="form-group-lg" id="institution-box">
		<label for="institution">@lang('labels.text_school_name')</label>
		<input type="institution" name="institution" id="institution" 
			   class="form-control-input"/>
		</div>
		
		
		<br/>
		
		<div class="form-group-lg" id="report-box">
		<button id="report" class="btn btn-lg btn-base btn-block">
		@lang('labels.text_send_report')
		</button>
		</div>
		
		
	</div>
	
</div>

<div id="modal-mail" class="modal fade" role="dialog">
  <div class="modal-dialog">
     <div class="modal-wrapper">
      <div class="modal-content modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
		<h5>¡Listo!<br/>Se le enviará, vía Email, un informe<br/> de todos los pasos que realice de este ejercicio.</h5><br/>
		</div>
		<div class="text-center">
			<button id="btn-return" type="button" class="btn btn-base">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>

<div id="modal-alert" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="text-center">
		<h5>Llene al menos la institución.</h5>
		<br/>
		</div>
		<div class="text-center">
			<button type="button" class="btn btn-base" data-dismiss="modal">Aceptar</button>
		</div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
     $("#exit-icon").click(function(e){
		e.preventDefault();
		window.history.back();
	});
	
	$("#back-icon").click(function(e){
		e.preventDefault();
		window.history.back();
	});
	
	$("#btn-return").click(function(){
		$("#modal-alert").modal("hide");
		window.history.back();
	});
	
	var grades = ['1ro', '2do', '3ro', '4to', '5to', '6to'];
	
	for (i=0; i<grades.length; i++){
	  $('#grade').append($('<option>', {
			value: grades[i],
			text: grades[i],
		}));
	}
	
	
	setTimeout(function () {
		$.ajax({
			type: "GET",
			url: "{{ url('web/full-report-data/'.$lessonid) }}",
			dataType: "json",
			success: function(data, status) {
				var level = data['level'];
				var grade = data['grade'];
				var institution = data['institution'];
				var classroom = data['classroom'];
				$("#level").val(level);
				$("#grade").val(grade);
				$("#section").val(classroom);
				$("#institution").val(institution);
			}
		});
	}, 500);
	
	$("#report").click(function(){
		var vardata = {
			level : $("#level").val(),
			grade: $("#grade").val(),
			observation: '',
			classroom : $("#section").val(),
			institution : $("#institution").val(),
			speciality: '',
			course_name: ''
		};
		$.ajax({
			type: "POST",
			url: "{{ url('web/report-data/'.$lessonid) }}",
			dataType: "json",
			contentType : 'application/json',
			data: JSON.stringify(vardata),
			success: function(data, status) {
				sendEmail();
			}
		});
	});
	
	
	function sendEmail(){
		$.ajax({
			type: "GET",
			url: "{{ url('web/mail/'.$userid.'/'.$lessonid) }}",
			dataType: "json",
			success: function(data, status){
				$("#modal-mail").modal("show");
			}
		});
	}
	
	
	
	
	
	
});
</script>

@stop



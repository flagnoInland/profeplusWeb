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
		
		<div class="form-group-lg" id="course-box">
		<label for="course">@lang('labels.text_name_course')</label>
		<input type="text" name="course" id="course" 
			   class="form-control-input"/>
		</div>
		
		<br/>
		
		<div class="form-group-lg" id="speciality-box">
		<label for="speciality">@lang('labels.text_name_speciality')</label>
		<input type="text" name="speciality" id="speciality" 
			   class="form-control-input"/>
		</div>
			
		<br/>
		
		<div class="form-group-lg" id="institution-box">
		<label for="institution">@lang('labels.text_name_institution')</label>
		<input type="text" name="institution" id="institution" 
			   class="form-control-input"/>
		</div>
			
		<br/>
		
		<div class="form-group-lg" id="observation-box">
		<label for="observation">@lang('labels.text_type_observations')</label>
		<input type="text" name="observation" id="observation" 
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
    <div class="modal-content">
      <div class="modal-body">
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
		<h5>Llene al menos el nombre del curso.</h5>
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
	
	
	setTimeout(function () {
		$.ajax({
			type: "GET",
			url: "{{ url('web/full-report-data/'.$lessonid) }}",
			dataType: "json",
			success: function(data, status) {
				var observation = data['observation'];
				var institution = data['institution'];
				var speciality = data['speciality'];
				var course = data['course'];
				$("#course").val(course);
				$("#observation").val(observation);
				$("#institution").val(institution);
				$("#speciality").val(speciality);
			}
		});
	}, 500);
	
	$("#report").click(function(){
		var course = $("#course").val();
		if (course != ''){
			var vardata = {
				level : '',
				grade: '',
				observation: $("#observation").val(),
				classroom : '',
				institution : $("#institution").val(),
				speciality: $("#speciality").val(),
				course_name: course
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
		} else {
			$("#modal-alert").modal("show");
		}
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



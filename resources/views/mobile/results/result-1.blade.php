@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/result.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.4','packages':['corechart']}]}"></script><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{asset('js/js.cookie.js')}}"></script>
<link href="{{asset('css/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{asset('js/toastr.min.js')}}"></script>
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="container">

	<div class="col-xs-12 col-sm-12 col-md-12 text-center">
		<div id="chart-title"></div>
	</div>
	
</div>

	
<div id="columnchart_values" class="graph text-center"></div>

<div class="container">
	<!--div class="col-xs-12 col-sm-4 col-md-4 text-center" id="update-box">
		<button id="update" class="btn btn-lg btn-orange btn-block">
			@lang('labels.text_update_answers')
		</button>
	</div-->
	
	
	<div class="col-xs-6 col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2 text-center" id="report-box">
		<button id="report" class="btn btn-lg btn-orange btn-block">
			@lang('labels.text_get_report')
		</button>
	</div>
	
	<div class="col-xs-6 col-sm-4 col-md-4 text-center" id="finish-box">
		<button id="finish" class="btn btn-lg btn-green btn-block">
			@lang('labels.text_finish_one')
		</button>
	</div>
	
	<div class="col-xs-6 col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2 text-center" id="exit-box">
		<button id="exit" class="btn btn-lg btn-orange btn-block">
			@lang('labels.text_finish_exit')
		</button>
	</div>
	
	<div class="col-xs-6 col-sm-4 col-md-4 text-center" id="start-box">
		<button id="start" class="btn btn-lg btn-green btn-block">
			@lang('labels.text_start_two')
		</button>
	</div>
	
	<div class="col-xs-12 col-sm-4 col-md-4 col-sm-offset-4 col-md-offset-4 text-center" id="exit-survey-box">
		<button id="exit-survey" class="btn btn-lg btn-green-2 btn-block">
			FINALIZAR<br/> Y SALIR
		</button>
	</div>

</div>

<script>
$(document).ready(function(){
	
        google.charts.load('current', {packages: ['corechart','bar']});
        google.charts.setOnLoadCallback(drawChart);
        
	toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-center",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "30000",
	  "hideDuration": "1000",
	};
	
	
	
	var keepCode = Cookies.getJSON('keepCode');
	var idxTime = keepCode['idxTime'];
	if (idxTime == 2){
		 toastr["info"]("LA CLAVE ES LA MISMA.")
	}
	
	$("#exit-icon").click(function(){
		$.ajax({
			type: "POST",
			url: "{{ url('web/disable/'.$lessonid) }}",
			success: function(data, status) {
				window.location.replace("{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
			}
		});
	});
	
	$("#exit").click(function(){
		$.ajax({
			type: "POST",
			url: "{{ url('web/disable/'.$lessonid) }}",
			success: function(data, status) {
				window.location.replace("{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
			}
		});
	});
	
	$("#exit-survey").click(function(){
		$.ajax({
			type: "POST",
			url: "{{ url('web/disable/'.$lessonid) }}",
			success: function(data, status) {
				window.location.replace("{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
			}
		});
	});
	
	
	$("#back-icon").click(function(){
		$.ajax({
			type: "POST",
			url: "{{ url('web/disable/'.$lessonid) }}",
			success: function(data, status) {
				window.location.replace("{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
			}
		});
	});
	
	$("#exit-box").css("display","none");
	$("#exit-survey-box").css("display","none");
	$("#start-box").css("display","none");
	$("#finish-box").css("display","none");
	$("#report-box").css("display","none");
	$("#update-box").css("display","none");
	
	
	
	
	$("#report").click(function(){
		window.location.href="{{url('/web/report/1/')}}"+'/'+{{$question}}+'/'+{{$run}}+'/'+{{$survey}}+'/'
		+{{$exercise}}+'/'+{{$subject}}+'/'+{{$code}}+'/'+{{$lessonid}}+'/'+{{$userid}}+'/'+{{$mode}}	
	});
	
	
	var previous = {{$lessonid}};
	
	$("#chart-title").html("Paso 1: Clave {{$code}}&nbsp;&nbsp;&nbsp;&nbsp;#Estudiantes="+0);
	
	$("#start-box").click(function(){
		var vardata = {
			course_id : -1,
			evaluation_id: 0,
			accesscode: '{{$code}}',
			subject : {{$subject}},
			exercise : {{$exercise}},
			inactive: 0,
			app_mode: {{$mode}},
			run: 2,
			survey: {{$survey}},
			question_type: {{$question}},
			question_mode: 0
		};
		$.ajax({
			type: "POST",
			url: "{{ url('web/code/'.$userid) }}",
			dataType: "json",
			contentType : 'application/json',
			data: JSON.stringify(vardata),
			success: function(data, status) {
				var lessonid = data['id'];
				var run = data['run'];
				var code = data['accesscode'];
				transferReportData(lessonid,previous);
				window.location.replace("{{url('/web/result/2/')}}"+'/'+{{$question}}+'/'+previous+'/'+{{$survey}}+'/'
		+{{$exercise}}+'/'+{{$subject}}+'/'+code+'/'+lessonid+'/'+{{$userid}}+'/'+{{$mode}}	);
			}
		});
	});
	
	function transferReportData(lessonid,previous){
		$.ajax({
			type: "POST",
			url: "{{ url('web/share-report-data/') }}"+'/'+lessonid+'/'+previous
		});
	}
	
	$("#finish").click(function(){
		$("#finish-box").css("display","none");
		$("#report-box").css("display","none");
		$("#update-box").css("display","none");
		if({{$survey}}>1){
			$("#start-box").css("display","none");
			$("#exit-box").css("display","none");
			$("#exit-survey-box").css("display","block");
		} else {
			$("#start-box").css("display","block");
			$("#exit-box").css("display","block");
			$("#exit-survey-box").css("display","none");
		}
		$.ajax({
			type: "POST",
			url: "{{ url('web/disable/'.$lessonid) }}",
			success: function(data, status) {
				//$("#update").trigger("click");
				updateChart();
			}
		});
	});
    
    
	var mleft = 30;
	var flbly = 14;
	var flblx = 14;
	
	myDims();

	function updateChart(){
		$.ajax({
			type: "GET",
			url: "{{ url('web/graph/1/'.$lessonid.'/'.$run) }}",
			dataType: "json",
			contentType : 'application/json',
			success: function(data, status) {
				drawChart(data);	
			}
		});
	}

    /*$("#update").on("click", function(){
    	updateChart();	
    });*/
	
	setTimeout(function () {
		$.ajax({
			type: "GET",
			url: "{{ url('web/check/'.$lessonid) }}",
			dataType: "json",
			contentType : 'application/json',
			success: function(data, status) {
				var inactive = data['inactive'];
				if (inactive==1){
					$("#finish-box").css("display","none");
					$("#report-box").css("display","none");
					$("#update-box").css("display","none");
					if({{$survey}}>1){
						$("#start-box").css("display","none");
						$("#exit-box").css("display","none");
						$("#exit-survey-box").css("display","block");
					} else {
						$("#start-box").css("display","block");
						$("#exit-box").css("display","block");
						$("#exit-survey-box").css("display","none");
					}
				} else {
					$("#finish-box").css("display","block");
					$("#report-box").css("display","block");
					$("#update-box").css("display","block");
					$("#exit-box").css("display","none");
					$("#start-box").css("display","none");
					$("#exit-survey-box").css("display","none");
				}
			}
		});
		//$("#update").trigger("click");
		updateChart();
	}, 500);

	setInterval(function() {
		updateChart();
	}, 10000); //10 segundos
	
	
	var globalResizeTimer = null;

	$(window).resize(function() {
		myDims();
		if(globalResizeTimer != null) window.clearTimeout(globalResizeTimer);		
		globalResizeTimer = window.setTimeout(function() {
			//$("#update").trigger("click");
			updateChart();
		}, 500);
	});
	
	
	function myDims(){
		if (window.innerWidth > 767) {
			mleft = 50;
			flbly = 18;
			flblx = 14;
		} else {
			mleft = 30;
			flbly = 14;
			flblx = 12;
		}
	}
	
	
    function drawChart(res){
		
	var ans1 = 0;
	var ans2 = 0;
	var ans3 = 0;
	var ans4 = 0;
	var ans5 = 0;
	var ansnn = 0;
	var ansy = 0;
	var ansn = 0;
	var ansd = 0;
	var total = 0;
	
	if (res != null){
		ans1 = parseInt(res.ans1);
		ans2 = parseInt(res.ans2);
		ans3 = parseInt(res.ans3);
		ans4 = parseInt(res.ans4);
		ans5 = parseInt(res.ans5);
		ansnn = parseInt(res.ansnn);
		ansy = parseInt(res.ans_yes);
		ansn = parseInt(res.ans_no);
		ansd = parseInt(res.ans_na);
		total = parseInt(res.inlesson);
	}
		
		var maxw = total;
		var glines = 2;
		
		if (total==0){
			maxw = 1;
		}
		if (maxw<6){
			glines = 2;
		} else if (maxw<11){
			glines = 3;
		} else if (maxw<20){
			glines = 4;
		} else {
			glines = 5;
		}
		$("#chart-title").html("Paso 1: Clave {{$code}}&nbsp;&nbsp;&nbsp;&nbsp;#Estudiantes="+total);
    
		var vals = ['0','0','0','0','0','0'];
		if (total != 0){
				vals[0]=Math.round(100*ans1/total)+"%";
				vals[1]=Math.round(100*ans2/total)+"%";
				vals[2]=Math.round(100*ans3/total)+"%";
				vals[3]=Math.round(100*ans4/total)+"%";
				vals[4]=Math.round(100*ans5/total)+"%";
				vals[5]=Math.round(100*ansnn/total)+"%";
		}
		
		var data = google.visualization.arrayToDataTable([
			[{label: 'Answer', type: 'number'},
                        {label: 'Paso 1', type: 'number'}, 
                        { role: 'style' } ],
			[0.5, ans1, "color: #74b47c"],
			[1.5, ans2, "color: #74b47c"],
			[2.5, ans3, "color: #74b47c"],
			[3.5, ans4, "color: #74b47c"],
			[4.5, ans5, "color: #74b47c"],
			[5.5, ansnn, "color: #74b47c"]
		  ]);
		  
		
		var view = new google.visualization.DataView(data);
		view.setColumns([0,1,2,
						   { calc: "stringify",
							 sourceColumn: 1,
							 type: "string",
							 role: "annotation" }]);
                       
		var options = {
			tooltip : {trigger: 'none'},
			backgroundColor: '#ffffdd',
			legend: { position: "top" },
			bar: {groupWidth: "70%"},
			annotations: {
			  alwaysOutside: true,
			  textStyle: {
				fontSize: 14,
				color: '#000',
				auraColor: 'none'
				}
			},
			chartArea:{
				left:mleft,
				right:10,
				bottom:40,
				top:20,
				width:"100%",
				height:"100%",
				backgroundColor: '#ffffdd'
			},
			hAxis: {
				textStyle:{fontSize:flblx},
				showTextEvery: 1,
				maxTextLines: 2,
				minValue:0,				
				baselineColor: 'black',
				gridlines: {color:'transparent'},
				ticks:[{v:0, f:''}, {v:0.5, f:'1\n1'}, {v:1.5, f:'1\n1'}, {v:2.5, f:'1\n1'}, 
				{v:3.5, f:'1\n1'}, {v:4.5, f:'1\n1'}, {v:5.5, f:'1\n1'},]				
				},
			vAxis: {
				maxValues: maxw, 
				minValue: 1, 
				viewWindow: {max:maxw, min:0},			
				gridlines: {color:'transparent', count: glines}, 
				textStyle:{fontSize:flbly},
				format: '0'
				},
			colors: ['#74b47c']
		};

		var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
		chart.draw(view,options);
		
		var lbls = ["A","B","C","D","E", "S.R."];
		var rects =  document.querySelectorAll('[text-anchor="middle"]');
		for (var i=0;i<rects.length-6;i+=2) { 
			rects[i].innerHTML = lbls[i/2];
			rects[i+1].innerHTML = vals[i/2];
		}
		
	}
  
});

</script>


<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
	$("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
	
});
</script>


@stop



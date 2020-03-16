@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/result.min.css')}}" rel="stylesheet" type="text/css">
<script src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.4','packages':['corechart']}]}"></script><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
	<!--div class="col-xs-12 col-sm-6 col-md-6 text-center" id="update-box">
		<button id="update" class="btn btn-lg btn-orange-2 btn-block">
			@lang('labels.text_update_answers')
		</button>
	</div-->
	
	
	<div class="col-xs-12 col-sm-4 col-md-4 col-sm-offset-4 col-md-offset-4 text-center" id="finish-box">
		<button id="finish" class="btn btn-lg btn-green btn-block">
			@lang('labels.text_finish_two')
		</button>
	</div>
	
	
	<div class="col-xs-12 col-sm-4 col-md-4 col-sm-offset-4 col-md-offset-4 text-center" id="report-box">
		<button id="report" class="btn btn-lg btn-green-2 btn-block">
			RECIBIR<br/> INFORME
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
	
	toastr["info"]('IMPORTANTE<br/><br>Indique a los estudiantes que presionen el botón "Actualizar".')
	
	$("#report-box").css("display","none");
	$("#finish-box").css("display","none");
	$("#update-box").css("display","none");
	$("#chart-title").html("Paso 2: Clave {{$code}}&nbsp;&nbsp;&nbsp;&nbsp;#Estudiantes="+0);
	
	$("#report").click(function(){
		window.location.href="{{url('/web/report/1/')}}"+'/'+{{$question}}+'/'+{{$previous}}+'/'+{{$survey}}+'/'
		+{{$exercise}}+'/'+{{$subject}}+'/'+{{$code}}+'/'+{{$lessonid}}+'/'+{{$userid}}+'/'+{{$mode}}	
	});
	
	
	$("#exit-icon").click(function(){
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
	
	$("#finish").click(function(){
		$("#finish-box").css("display","none");
		$("#update-box").css("display","none");
		$("#report-box").css("display","block");
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
			url: "{{ url('web/graph/2/'.$lessonid.'/'.$previous) }}",
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
					$("#update-box").css("display","none");
					$("#report-box").css("display","block");
				} else {
					$("#finish-box").css("display","block");
					$("#update-box").css("display","block");
					$("#report-box").css("display","none");
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
		var total = 0;
		var ans1i = 0;
        var ans2i = 0;
        var ans3i = 0;
        var ans4i = 0;
        var ans5i = 0;
        var ansnni = 0;
        var totali = 0;
		
		if (res!= null){
			ans1 = parseInt(res.ans1);
			ans2 = parseInt(res.ans2);
			ans3 = parseInt(res.ans3);
			ans4 = parseInt(res.ans4);
			ans5 = parseInt(res.ans5);
			ansnn = parseInt(res.ansnn);
			total = parseInt(res.inlesson);
			ans1i = parseInt(res.ans1i);
			ans2i = parseInt(res.ans2i);
			ans3i = parseInt(res.ans3i);
			ans4i = parseInt(res.ans4i);
			ans5i = parseInt(res.ans5i);
			ansnni = parseInt(res.ansnni);
			totali = parseInt(res.inlessoni);
		}
    
		
		var maxw = totali;
		if (total > totali){
			maxw = total;
		}
		
		var glines = 2;
		
		if (maxw==0){
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
		
		$("#chart-title").html("Paso 2: Clave {{$code}}&nbsp;&nbsp;&nbsp;&nbsp;#Estudiantes="+total);
    
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
			["Answer", "Paso 1", { role: 'style' }, "Paso 2", {role:'style'} ],
			[0.5, ans1i, "#74b47c", ans1, "#daa520"],
			[1.5, ans2i, "#74b47c", ans2, "#daa520"],
			[2.5, ans3i, "#74b47c", ans3, "#daa520"],
			[3.5, ans4i, "color: #74b47c", ans4, "#daa520"],
			[4.5, ans5i, "color: #74b47c", ans5, "#daa520"],
			[5.5, ansnni, "color: #74b47c", ansnn, "#daa520"],
		  ]);
		  
		
		var view = new google.visualization.DataView(data);
		view.setColumns([0,1,2,
						   { calc: "stringify",
							 sourceColumn: 1,
							 type: "string",
							 role: "annotation" },3,4,{ calc: "stringify",
							 sourceColumn: 3,
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
			colors: ['#74b47c','#daa520']
		};

		var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
		chart.draw(view,options);
		
		var lbls = ["A","B","C","D","E", "S.R."];
		var rects =  document.querySelectorAll('[text-anchor="middle"]');
		for (var i=0;i<rects.length-12;i+=2) { 
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



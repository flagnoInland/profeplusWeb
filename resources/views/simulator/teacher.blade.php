<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INNOVAClase</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-content.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js" type="text/javascript"></script>
</head>
<body>
    <div>
        @include('simulator.partials.teacher-menu')
        @include('simulator.partials.start-student-menu')
        <div class="right-pannel">
        <h3>Code: {{$accesscode}} </h3>
        <p id="DEBUG" class="debug">Debug test</p>
        <table align="center">
            <tr><td>            
            {{ Form::button('CHART', array('class' => 'awesome-button', 'id' => 'updateData', 'onclick' => 'loadChart('.$code.')'))}}
            </td></tr>
        </table>               
        <div class="chart">
            <canvas id="canvas" ></canvas>
        </div>
        <script src="{{asset('js/chart-result.js')}}" type="text/javascript"></script>
        </div>    
    </div>
</body>
</html>

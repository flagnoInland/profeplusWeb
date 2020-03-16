<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INNOVAClase</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-content.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-radio.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js" type="text/javascript"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>  
</head>
<body>
    <div>
        @include('simulator.partials.start-teacher-menu')
        @include('simulator.partials.start-student-menu')
        <div class="right-pannel">
        <table align="center">
            <tr>           
            <td>{{Form::label('code', 'CODE', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('code-main', '9876', array('class' => 'table-text','id' => 'codeadmin'))}}</td>
            <td>
            <div class="switch-field">            
                {{Form::radio('graph', '1', true, array('data-toggle' => 'button', 'id' => 'graph1'))}} {{Form::label('graph1', 'ACTUAL')}}           
                {{Form::radio('graph', '2', false, array('data-toggle' => 'button', 'id' => 'graph2'))}} {{Form::label('graph2', 'COMPARE')}}
            </div>
            </td>    
            <td>{{Form::button('POPULATE', array('class' => 'awesome-button', 'id' => 'populate'))}}</td>          
            </tr>
        </table>      
        
        
        <table align="center">
            <tr><td>            
            {{ Form::button('CHART', array('class' => 'awesome-button', 'id' => 'updateData'))}}
            </td></tr>
        </table>               
        <div class="chart">
            <canvas id="canvas" ></canvas>
        </div>
        <script src="{{asset('js/graph.js')}}" type="text/javascript"></script>
        </div>    
    </div>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INNOVAClase</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
    <link href="{{asset('css/innova-content.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-radio.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-checkbox.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-modal.css')}}" rel="stylesheet" type="text/css">      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js" type="text/javascript"></script>
    <script src="{{asset('js/modal.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/course-school.js')}}" type="text/javascript"></script>
</head>
<body>
    <div>
        @include('simulator.partials.start-teacher-menu')
        @include('simulator.partials.start-student-menu')
        <div class="right-pannel">
        <div class="right-pannel-left">
        {{ Form::open(array('url' => 'simulator/school/teacher/'.$code.'/'.$task)) }}  
        <table class="narrow-table">
        <tr>                
            <td>{{Form::label('id', 'ID', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('id', '1', array('class' => 'table-text'))}}</td>
        </tr>
        <tr>                
            <td>{{Form::label('code-main', 'CODE', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('code-main', '9999', array('class' => 'table-text'))}}</td>
        </tr>
        <tr>                
            <td>{{Form::label('course', 'COURSE', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('course', '3', array('class' => 'table-text'))}}</td>
        </tr>
        <tr>                
            <td>{{Form::label('subject', 'SUBJECT', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('subject', '10', array('class' => 'table-text'))}}</td>
        </tr>
        <tr>                
            <td>{{Form::label('exercise', 'EXERCISE', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('exercise', '10', array('class' => 'table-text'))}}</td>
        </tr>
        <tr>                
            <td>{{Form::label('run', 'RUN', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('run', '1', array('class' => 'table-text'))}}</td>
        </tr>
        </table>
        <table class="narrow-table">
        <tr>                
            <td>{{Form::label('label1', 'SURVEY', array('class' => 'awesome-label'))}}</td>
        </tr>
        <tr>
        <td>
        <div class="switch-field">
            {{Form::radio('survey', '0', true, array('data-toggle' => 'button', 'id' => 'ansZ'))}} {{Form::label('ansZ', 'None')}}
            {{Form::radio('survey', '1', false, array('data-toggle' => 'button', 'id' => 'ansA'))}} {{Form::label('ansA', 'Satisfaction')}}           
            {{Form::radio('survey', '2', false, array('data-toggle' => 'button', 'id' => 'ansB'))}} {{Form::label('ansB', 'Agreement')}}
            {{Form::radio('survey', '3', false, array('data-toggle' => 'button', 'id' => 'ansC'))}} {{Form::label('ansC', 'Qualification')}}
            {{Form::radio('survey', '4', false, array('data-toggle' => 'button', 'id' => 'ansD'))}} {{Form::label('ansD', 'Exposition')}}
        </div>
        </td>                 
        </tr>     
        </table>
        <div>
        <table class="narrow-table">
        <tr>                
            <td>{{Form::checkbox('dich', '1', false, array('id' => 'dich', 'class' => 'switch'))}} {{Form::label('dich', 'Dichotomous', array('class' => 'switch-label'))}}</td>
        </tr>
        <tr>                
            <td>{{Form::checkbox('free', '1', false, array('id' => 'free', 'class' => 'switch'))}} {{Form::label('free', 'Free Question', array('class' => 'switch-label'))}}</td>
        </tr>
        <tr>                
            <td>{{Form::checkbox('peer', '1', false, array('id' => 'peer',  'class' => 'switch'))}} {{Form::label('peer', 'Peer Instruction', array('class' => 'switch-label'))}}</td>
        </tr>             
        </table>     
        </div>
        {{ Form::close() }} 
        </div>
        </div>
        
        <div class="right-pannel-right-top">        
        <table align="center">
        <tr>
            <td>       
            {{ Form::submit('START', array('class' => 'awesome-button', 'id' => 'start'))}}           
            </td>     
        </tr>
        <tr>
            <td>         
            {{ Form::submit('UPDATE', array('class' => 'awesome-button', 'id' => 'update'))}}
            </td>     
        </tr>
        <tr>
            <td>         
            {{ Form::submit('NEW RUN', array('class' => 'awesome-button', 'id' => 'newrun'))}}
            </td>     
        </tr>
        <tr>
            <td>
            {{ Form::submit('STOP', array('class' => 'awesome-button', 'id' => 'stop'))}}
            </td> 
        </tr>
        <tr>
            <td>
            {{Form::button('POPULATE', array('class' => 'awesome-button', 'id' => 'populate'))}}
            </td>
        </tr>       
        </table>
        </div>
                  
        <div class="right-pannel-right-bottom">                        
        <table align="center">
        <tr>
            <td align="center">            
            {{ Form::button('CHART', array('class' => 'awesome-button', 'id' => 'updateData'))}}
            </td>
        </tr>
        <tr>
            <td>
            <div class="switch-field">            
                {{Form::radio('graph', '1', true, array('data-toggle' => 'button', 'id' => 'graph1'))}} {{Form::label('graph1', 'ACTUAL')}}           
                {{Form::radio('graph', '2', false, array('data-toggle' => 'button', 'id' => 'graph2'))}} {{Form::label('graph2', 'COMPARE')}}
            </div>
            </td>   
        </tr>
        </table>               
        <div class="chart">
            <canvas id="canvas" ></canvas>
        </div>
        <script src="{{asset('js/graph.js')}}" type="text/javascript"></script>
        </div>
        
        
    </div>
</body>
</html>

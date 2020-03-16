<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INNOVAClase</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-content.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-radio.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-checkbox.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
    <div>
        @include('simulator.partials.start-teacher-menu')
        @include('simulator.partials.start-student-menu')
        <div class="right-pannel">
        {{ Form::open(array('url' => 'simulator/teacher/'.$code.'/'.$task)) }}  
        <table class="narrow-table">
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
            <td>{{Form::checkbox('dich', '1', false, array('id' => 'ansE', 'class' => 'switch'))}} {{Form::label('ansE', 'Dichotomous', array('class' => 'switch-label'))}}</td>
        </tr>
        <tr>                
            <td>{{Form::checkbox('free', '1', false, array('id' => 'ansF', 'class' => 'switch'))}} {{Form::label('ansF', 'Free Question', array('class' => 'switch-label'))}}</td>
        </tr>
        <tr>                
            <td>{{Form::checkbox('peer', '1', false, array('id' => 'ansG',  'class' => 'switch'))}} {{Form::label('ansG', 'Peer Instruction', array('class' => 'switch-label'))}}</td>
        </tr>
        <tr>                
            <td align="right">{{ Form::submit('SEND', array('class' => 'awesome-button'))}}</td>    
        </tr>         
        </table>     
        </div>
        {{ Form::close() }} 

    
        </div>       
    </div>
</body>
</html>

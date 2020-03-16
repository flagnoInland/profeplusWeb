<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INNOVAClase</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-content.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-radio.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
    <div>
        @include('simulator.partials.teacher-menu')
        @include('simulator.partials.student-menu')
        <div class="right-pannel">
        <table class="table">
        <tr>
            {{ Form::open(array('url' => 'simulator/students/register/'.$id.'/'.$code)) }}      
            <td>{{Form::label('id', 'User ID', array('class' => 'awesome-label'))}}</td>
            <td class="awesome-label">{{$id}}</td>
            <td>{{Form::label('code', 'Session ID', array('class' => 'awesome-label'))}}</td>
            <td class="awesome-label">{{$code}}</td>           
            <td>{{Form::submit('REGISTER', array('class' => 'awesome-button'))}}</td>
            {{ Form::close() }}             
        </tr>
        </table>
        <hr>
        <table class="table">
        <tr>
        <h3>CHOOSES ANSWER</h3>
        </tr>        
        <tr>
        {{ Form::open(array('url' => 'simulator/students/answer/'.$code.'/'.$id)) }}      
        <td><div class="switch-field">
        {{Form::radio('answer', 'A', true, ['data-toggle' => 'button', 'id' => 'ansA'])}} {{Form::label('ansA', 'A')}}
        {{Form::radio('answer', 'B', true, ['data-toggle' => 'button', 'id' => 'ansB'])}} {{Form::label('ansB', 'B')}}
        {{Form::radio('answer', 'C', true, ['data-toggle' => 'button', 'id' => 'ansC'])}} {{Form::label('ansC', 'C')}}
        {{Form::radio('answer', 'D', true, ['data-toggle' => 'button', 'id' => 'ansD'])}} {{Form::label('ansD', 'D')}}      
        {{Form::radio('answer', 'E', true, ['data-toggle' => 'button', 'id' => 'ansE'])}} {{Form::label('ansE', 'E')}}
        </div><td>{{Form::submit('SEND', array('class' => 'awesome-button'))}}</td>
        {{ Form::close() }}    
        </tr>        
        </table>
        <hr>
        <table class="table">
        <tr>
        <h3>YES-NO ANSWER</h3>
        </tr>
        <tr>
        {{ Form::open(array('url' => 'simulator/students/answer/'.$code.'/'.$id)) }}      
        <td><div class="switch-field">
        {{Form::radio('answer', 'F', true, ['data-toggle' => 'button', 'id' => 'ansYes'])}} {{Form::label('ansYes', 'Yes')}}
        {{Form::radio('answer', 'G', true, ['data-toggle' => 'button', 'id' => 'ansNo'])}} {{Form::label('ansNo', 'No')}}
        {{Form::radio('answer', 'H', true, ['data-toggle' => 'button', 'id' => 'ansNA'])}} {{Form::label('ansNA', "Don't know.")}}    
        </div><td>{{Form::submit('SEND', array('class' => 'awesome-button'))}}</td>
        {{ Form::close() }}    
        </tr>
        </table>
        </div>
    </div>
</body>
</html>

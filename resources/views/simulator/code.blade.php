<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INNOVAClase</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-login.css')}}" rel="stylesheet" type="text/css">

</head>
<body>
    <div class="container">
        {{ Form::open(array('url' => 'simulator/authenticate')) }}
        <table class="table">
        <tr>
            <td>{{Form::label('email', 'E-Mail Address', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('email', 'example@gmail.com', array('class' => 'awesome-text'))}}</td>       
        </tr>
        <tr>
            <td>{{ Form::label('password', 'Password', array('class' => 'awesome-label'))}}</td>
            <td>{{ Form::password('password', array('class' => 'awesome-text'))}}</td>
        </tr>      
        </table>
        <table align="center">
            <tr>
                <td>{{ Form::submit('LOG IN', array('class' => 'awesome-button'))}}</td>        
            </tr>
        </table>
        {{ Form::close() }}
    </div>
</body>
</html>

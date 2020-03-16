<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INNOVAClase</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-content.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-checkbox.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-selectbox.css')}}" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="{{asset('js/database.js')}}" type="text/javascript"></script>
</head>
<body>
    <div>
        @include('simulator.partials.start-teacher-menu')
        @include('simulator.partials.start-student-menu')
        <div class="right-pannel">            
            <table class="table">       
            <tr>
                <td align="center">
                {{ Form::open(array('action' => array('SimulatorController@cleanTableLessonUsers'))) }}    
                {{ Form::submit('CLEAR USERS-LESSONS', array('class' => 'database-button'))}}
                {{ Form::close() }}
                </td>                        
                <td align="center">
                {{ Form::open(array('action' => array('SimulatorController@cleanTableLessons'))) }}   
                {{ Form::submit('CLEAR LESSONS', array('class' => 'database-button'))}}
                {{ Form::close() }}
                </td>          
            </tr>
            </table >

            <hr>
            
            <table width="660">
            <col width="100">
            <col width="360">
            <col width="200">    
            <tr>
                <td>{{Form::label('code', 'CODE', array('class' => 'awesome-label'))}}</td>
                <td>{{Form::text('coderun', '9876', array('class' => 'table-text','id' => 'coderun'))}}</td>                   
                <td>{{Form::button('USERS', array('class' => 'awesome-button', 'id' => 'users'))}}</td>          
            </tr>
            </table>
            <div class="results">
                <table class="table-users" id="users-title">
                </table>
            </div>           
        
                
        </div>
    </div>
</body>
</html>

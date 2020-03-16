<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INNOVAClase</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-content.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-radio.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/innova-checkbox.css')}}" rel="stylesheet" type="text/css">
     <link href="{{asset('css/innova-selectbox.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="{{asset('js/database.js')}}" type="text/javascript"></script>    
</head>
<body>
    <div>
        @include('simulator.partials.start-teacher-menu')
        @include('simulator.partials.start-student-menu')
        <div class="right-pannel">           
        <table>    
        <tr>
            <td>{{Form::label('run', 'TEST USER', array('class' => 'awesome-label'))}}</td>
        </tr>
        </table>
        <table width="660">
        <col width="100">
        <col width="360">
        <col width="200">    
        <tr>
            <td>{{Form::label('code', 'CODE', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('coderun', '9876', array('class' => 'table-text','id' => 'coderun'))}}</td>                   
            <td>{{Form::button('TWO RUNS', array('class' => 'awesome-button', 'id' => 'runs'))}}</td>          
        </tr>
        </table>
        <table class="table" id="two-run-title">
        </table>
        <hr>
        <table>
        <tr>
            <td>{{Form::label('run', 'TEST ADMIN', array('class' => 'awesome-label'))}}</td>
        </tr>
        </table>
        <table width="660">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="160">
        <col width="200">
        <tr>
            <td>{{Form::label('code', 'CODE', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('codeadmin', '9876', array('class' => 'table-text','id' => 'codeadmin'))}}</td>
            <td>{{Form::label('run', 'RUN', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('runadmin', '2', array('class' => 'table-text','id' => 'runadmin'))}}</td>            
            <td>{{Form::button('POPULATE', array('class' => 'awesome-button', 'id' => 'populate'))}}</td>          
        </tr>
        </table>   
        
        <hr>
        <table>
        <tr>
            <td>{{Form::label('run2', 'TEST ADMIN TRUE-FALSE', array('class' => 'awesome-label'))}}</td>
        </tr>
        </table>
        <table width="660">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="160">
        <col width="200">
        <tr>
            <td>{{Form::label('code2', 'CODE', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('codeadmin2', '9876', array('class' => 'table-text','id' => 'codeadmin2'))}}</td>
            <td>{{Form::label('run2', 'RUN', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('runadmin2', '1', array('class' => 'table-text','id' => 'runadmin2'))}}</td>            
            <td>{{Form::button('POPULATE', array('class' => 'awesome-button', 'id' => 'populate2'))}}</td>          
        </tr>
        </table>  

        <hr>

        <table>
        <tr>
            <td>{{Form::label('run', 'TEST MAIL', array('class' => 'awesome-label'))}}</td>
        </tr>
        </table>
        <table width="660">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="160">
        <col width="200">
        <tr>
            <td>{{Form::label('codemail', 'CODE', array('class' => 'awesome-label'))}}</td>
            <td>{{Form::text('codemail', '9876', array('class' => 'table-text','id' => 'codemail'))}}</td>
            <td>{{Form::label('local', 'LOCAL', array('class' => 'awesome-label'))}}</td>
            <td>
            <select id="local">
            <option value="es">Spanish</option>
            <option value="en">English</option>
            </select> 
            </td>                 
            <td>{{Form::button('SEND', array('class' => 'awesome-button', 'id' => 'email'))}}</td>          
        </tr>
        </table> 
       
        </div>    
    </div>
</body>
</html>

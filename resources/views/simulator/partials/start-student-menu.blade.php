<div class="left-bottom-pannel">
<div class="title-mainpage">
    USERS
</div>
{{ Form::open(array('action' => array('SimulatorController@startLesson'))) }} 
<table align="center">   
<tr>
    <td align="center">{{Form::label('code', 'Code', array('class' => 'table-label'))}}</td>
</tr>
<tr>
    <td align="center">{{Form::text('code', '6666666', array('class' => 'table-text'))}}</td>
</tr>  
<tr>
    <td align="center">{{ Form::submit('START', array('class' => 'awesome-button'))}}</td>     
</tr>
</table>
{{ Form::close() }} 
       
</div>           
       
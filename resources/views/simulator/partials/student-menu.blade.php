<div class="left-bottom-pannel">
<div class="title-mainpage">
    USERS
</div>
<table align="center">         
<tr>
    <td>
    {{ Form::open(array('action' => array('SimulatorController@setStudent', "id=2&code=".$code))) }}      
    {{ Form::submit('USER 1', array('class' => 'awesome-button'))}}
    {{ Form::close() }} 
    </td>                    
</tr>
<tr>
    <td>
    {{ Form::open(array('action' => array('SimulatorController@setStudent', "id=3&code=".$code))) }}      
    {{ Form::submit('USER 2', array('class' => 'awesome-button'))}}
    {{ Form::close() }} 
    </td>          
</tr>
<tr>
    <td>
    {{ Form::open(array('action' => array('SimulatorController@setStudent', "id=4&code=".$code))) }}      
    {{ Form::submit('USER 3', array('class' => 'awesome-button'))}}
    {{ Form::close() }} 
    </td>            
</tr>
<tr>
   <td>
    {{ Form::open(array('action' => array('SimulatorController@setStudent', "id=5&code=".$code))) }}      
    {{ Form::submit('USER 4', array('class' => 'awesome-button'))}}
    {{ Form::close() }} 
    </td>          
</tr>
</table>
       
</div>           
       
<div class="left-top-pannel">
    <div class="title-mainpage">
        ADMIN
    </div>
    <table align="center">
    <tr>    
        <td>
        {{ Form::open(array('action' => array('SimulatorController@updateLesson', "id=".$code))) }}  
        {{ Form::submit('UPDATE', array('class' => 'awesome-button'))}}
        {{ Form::close() }} 
        </td>        
    </tr>
    <tr>
        <td>
        {{ Form::open(array('action' => array('SimulatorController@newLesson', "id=".$code))) }}  
        {{ Form::submit('NEW', array('class' => 'awesome-button'))}}
        {{ Form::close() }} 
        </td>        
    </tr>
    <tr>
        <td>
        {{ Form::open(array('action' => array('SimulatorController@stopLesson', "id=".$code))) }}  
        {{ Form::submit('STOP', array('class' => 'awesome-button'))}}
        {{ Form::close() }} 
        </td>        
    </tr>
    <tr>
        <td>
        {{ Form::open(array('action' => array('SimulatorController@studentInLesson', "id=".$code))) }}  
        {{ Form::submit('USERS', array('class' => 'awesome-button'))}}
        {{ Form::close() }} 
        </td>        
    </tr>
</table>
</div>
        
<div class="left-top-pannel">
    <div class="title-mainpage">
        ADMIN
    </div>
    
    <table align="center">
        <tr>
            <td align="center">
            {{ Form::open(array('action' => array('SimulatorController@createLesson'))) }} 
            {{ Form::submit('EXAMPLE', array('class' => 'awesome-button'))}}
            {{ Form::close() }}
            </td>     
        </tr>
        <tr>
            <td align="center">
            {{ Form::open(array('url' => 'simulator/graph', 'method' => 'get')) }} 
            {{ Form::submit('GRAPH', array('class' => 'awesome-button'))}}
            {{ Form::close() }}
            </td>     
        </tr>
        <tr>
            <td align="center">
            {{ Form::open(array('url' => 'simulator/test', 'method' => 'get')) }} 
            {{ Form::submit('TEST', array('class' => 'awesome-button'))}}
            {{ Form::close() }}
            </td>     
        </tr>
        <tr>
            <td align="center">
            {{ Form::open(array('action' => array('SimulatorSchoolController@createLesson'))) }} 
            {{ Form::submit('SCHOOL', array('class' => 'awesome-button'))}}
            {{ Form::close() }}
            </td>     
        </tr>
        <tr>
            <td align="center">
            {{ Form::open(array('url' => 'simulator/database', 'method' => 'get')) }} 
            {{ Form::submit('DB CLEAN UP', array('class' => 'awesome-button'))}}
            {{ Form::close() }}
            </td>     
        </tr>
    </table>
</div>
        
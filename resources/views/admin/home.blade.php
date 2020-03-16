@extends('admin.layout00')

@section('header')
<link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
<link href="{{asset('css/admin.min.css')}}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/es.js"></script> 
@stop


@section('content')
<div style="position: absolute; max-height: 100vh; height:100%; width: 20%; 
     left:0px; background-color: #8e747c">
    
</div>

<div style="position: absolute; height:100%; width: 80%; 
     left:20%; background-color: #fff3f3">
    
</div>

<div style="position: absolute; height: 100%; width: 100%; overflow-y: hidden">
    
    <div id="toolbar"><!-- Toolbar-->
        <ul class="tabs" data-tabs id="example-tabs">
        <div style="float: left; padding-left: 20px">
            <li class="tabs-title">
            <img src="{{asset('images/favicon.png')}}" 
                 class="inline-icon"/></li>
            <li id="full-name" class="tabs-title h4" style="padding-top: 5px; padding-left: 20px"></li>
        </div>

        <div style="float: right">
            <li class="tabs-title text-center" >
                <a href="#panel1" aria-selected="true">
                <span data-tooltip aria-haspopup="true" title="NO DISPONIBLE">
                  Ayuda  
                </span>
            </a>
            </li>
            <li class="tabs-title text-center" >
                <a href="{{ url('/') }}">Ir al Sitio</a></li>
            <li class="tabs-title text-center" >
                <a href="{{ url('/admin/logout') }}">Cerrar Sesión</a></li>
        </div>
        </ul>
    </div><!-- End toolbar-->
    
    <div style="width: 20%; left:0px; float: left"><!-- Navbar-->
        <ul class="tabs primary vertical" id="example-vert-tabs" data-tabs >
            <li id="tests" class="tabs-title-primary is-active"><a href="#tests" aria-selected="true">Pruebas</a></li>
            <li id="stats" class="tabs-title-primary"><a href="#stats">Estadísticas</a></li>
            <li id="users" class="tabs-title-primary"><a href="#users">Gestión de Usuarios</a></li>
            <li id="utils" class="tabs-title-primary"><a href="#utils">Utilidades</a></li>
            <li id="evals" class="tabs-title-primary"><a href="#evals">Evaluaciones</a></li>
        </ul>
    </div><!-- End navbar-->

    <div id="block-pannel" style="width: 80%; left:20%; float: right;">
        <div class="tabs-content vertical" data-tabs-content="example-vert-tabs">
            
            <div class="tabs-panel is-active" id="panel1v"><!-- Start panel 1-->
            <div class="text-center">
                <button id="test-exam" 
                        class="raised-button block-ctrl h5">Probar Evaluaciones</button>
            </div>
            </div><!-- End panel 1-->
            
            <div class="tabs-panel" id="panel2v"><!-- Start panel 2-->
                
            <div class="row" style="color: #000; margin: auto">
                
                <div class="medium-4 columns">
                    <div class="card end text-center" style="margin: auto 5px; padding-top: 5px">
                        <h5>Usuarios</h5>
                        <span class="text-caption" id="date-user">Noviembre 10</span>
                        <h1 id="num-user">2456</h1>
                    </div>
                </div>
                
                <div class="medium-4 columns">
                     <div class="card end text-center" style="margin: auto 5px; padding-top: 5px">
                        <h5>Lecciones</h5>
                        <span class="text-caption" id="date-lecc">Noviembre 10</span>
                        <h1 id="num-lecc">2456</h1>
                     </div>
                </div>
                
                <div class="medium-4 columns">
                     <div class="card end text-center" style="margin: auto 5px; padding-top: 5px">
                        <h5>Evaluaciones</h5>
                        <span class="text-caption" id="date-exam">Noviembre 10</span>
                        <h1 id="num-exam">2456</h1>
                     </div>
                </div>
                
                <div class="medium-12 columns">
                     <div id="users1" class="card end" style="margin: auto 5px; padding-top: 5px">
                        <h5 class="text-center">Estudiantes y Profesores</h5>                      
                     </div>
                </div>
                
                <div class="medium-12 columns">
                     <div id="users2" class="card end" style="margin: auto 5px; padding-top: 5px">
                        <h5 class="text-center">Usuarios Nacionales y Extranjeros</h5>                      
                     </div>
                </div>
                
                <div class="medium-12 columns">
                     <div id="users3" class="card end" style="margin: auto 5px; padding-top: 5px">
                        <h5 class="text-center">Usuarios Nacionales</h5>                      
                     </div>
                </div>
                
                <!--div class="medium-12 columns">
                     <div id="concurso" class="card end" style="margin: auto 5px; padding-top: 5px">
                        <h5 class="text-center">Competencia Profeplus</h5>                      
                     </div>
                </div-->
                
            </div><!-- End panel 2 -->
                
            </div>
            
            
            <div class="tabs-panel" id="panel3v"><!-- Start panel 3-->
                <div class="input-group">
                    <span class="label h5" style="line-height: 1.66">E-mail</span>
                    <input id="email" class="h5" 
                           style="margin: 5px 5px; 
                           padding: 5px; 
                           max-width: 420px; 
                           display: inline" type="text">
                    <button id="search" class="raised-accent-button h5" style="display: inline">Buscar</button>
                </div>
                
                <div id="user-card" style="color: #000">
                   
                    
                </div>
            </div><!-- End panel 3-->
            
            <div class="tabs-panel" id="panel4v"><!-- Start panel 4-->
                <div class="text-center">
                <button id="mail-log" 
                        class="raised-button block-ctrl h5">Enviar Log al Administrador</button>
                </div>               
            </div><!-- End panel 4-->

            <div class="tabs-panel" id="panel5v"><!-- Start panel 5-->
            <div class="row" style="color: #000; margin: auto">
                <div class="medium-12 columns">
                    <div class="card end" style="margin: 5px; padding: 5px; display: inline-block; width:100%">
                        <span style="display: inline-block; width:30%; font-size: 24px;">
                            <select name="evalCustomId" id="evalCustomId" class="form-control">
                                <option value="1">Evaluación 1</option>
                                <option value="2">Evaluación 2</option>
                                <option value="3">Evaluación 3</option>
                                <option value="4">Evaluación 4</option>
                                <option value="5">Evaluación 5</option>
                                <option value="6">Evaluación 6</option>
                                <option value="7">Evaluación 7</option>
                                <option value="8">Evaluación 8</option>
                                <option value="9">Evaluación 9</option>
                                <option value="10">Evaluación 10</option>
                            </select>
                        </span>
                        <span id="statEval1a" style="display: inline-block; width:30%; font-size: 24px">Código: 5436</span>
                        <span id="statEval1b" style="display: inline-block; width:30%; font-size: 24px">Estado: Activo</span>
                        <button id="startEval1" class="raised-button h6" 
                        style="display: inline">Comenzar</button>
                        <button id="endEval1" class="raised-accent-button h6" 
                        style="display: inline">Cerrar</button>
                        <button id="sendEval1" class="raised-accent-button h6" 
                        style="display: inline">Enviar</button>
                    </div>
                </div>
            </div>

            </div><!-- End panel 5-->
            
        </div>
    </div>

    
</div>

<script>
$(document).ready(function(){
    
    $("#stats").css("display","none");
    $("#users").css("display","none");
    $("#utils").css("display","none");
    $("#evals").css("display","none");
    
    var htbar = $("#toolbar").height();
    var vport = $("body").height();
    $("#block-pannel").css("height",vport-htbar);
    $("#block-pannel").css("overflow-y","auto");

    $.ajax({
        type: "GET",
        url: "{{url('/web/exam/teacher')}}"+'/1/custom/eval/status/1',
        dataType: "json",
        success: function(data, status) {
            status = data['status'];
            accesscode = data['accesscode'];
            $("#statEval1a").text("Código: " + accesscode);
            if (status == 1){
                $("#statEval1b").text("Estado: Inactivo");
            } else {
                $("#statEval1b").text("Estado: Activo");
            }
        }
    });

    $("#evalCustomId").change(function(){
        var evalCustomId = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{url('/web/exam/teacher')}}"+'/1/custom/eval/status/'+evalCustomId,
            dataType: "json",
            success: function(data, status) {
                status = data['status'];
                accesscode = data['accesscode'];
                $("#statEval1a").text("Código: " + accesscode);
                if (status == 1){
                    $("#statEval1b").text("Estado: Inactivo");
                } else {
                    $("#statEval1b").text("Estado: Activo");
                }
            }
        });
    });
    
    $.ajax({
        type : 'GET',
        url : "{{url('/admin/user/data?id=')}}"+"{{$userId}}",
        contentType : "application/json",
        success: function(data) {
            var rol = data["rol"];
            var name = data["fullname"];
            $("#full-name").append(name);
            if (rol == 2){
                $("#stats").css("display","block");
            }
            if (rol == 3){
                $("#stats").css("display","block");
                $("#users").css("display","block");
                $("#utils").css("display","block");
                $("#evals").css("display","block");
            }
        }
    })
    
    $.ajax({
        type : 'GET',
        url : "{{url('/admin/stats')}}",
        contentType : "application/json",
         success: function(data) {
             $("#num-user").html(data["users"]);
             $("#date-user").html(data["dateUser"]);
             $("#num-lecc").html(data["leccs"]);
             $("#date-lecc").html(data["dateLecc"]);
             $("#num-exam").html(data["exams"]);
             $("#date-exam").html(data["dateExam"]);
             fillTableUsers1(data["nusers"]);
             fillTableUsers2(data["cusers"]);
             fillTableUsers3(data["pusers"]);
             //fillTableConcurso(data["concurso"]);
         }
    });
    
    $("#test-exam").click(function(){
        window.location.href = "{{url('/web/exam/testing')}}"; 
    });
    
    $("#mail-log").click(function(){
        $.ajax({
          type: "GET",
          url: "{{ url('admin/mail/log') }}",
          dataType: "json",
          success: function(data, status){
            alert('Log enviado.');
          }
        }); 
    });
    
    $("#tests").click(function(){
        $("#tests").addClass("is-active");
        $("#users").removeClass("is-active");
        $("#stats").removeClass("is-active");
        $("#utils").removeClass("is-active");
        $("#evals").removeClass("is-active");
        $("#panel1v").addClass("is-active");
        $("#panel3v").removeClass("is-active");
        $("#panel2v").removeClass("is-active");
        $("#panel4v").removeClass("is-active");
        $("#panel5v").removeClass("is-active");
    });
    
    $("#stats").click(function(){
        $("#tests").removeClass("is-active");
        $("#users").removeClass("is-active");
        $("#stats").addClass("is-active");
        $("#utils").removeClass("is-active");
        $("#evals").removeClass("is-active");
        $("#panel1v").removeClass("is-active");
        $("#panel3v").removeClass("is-active");
        $("#panel2v").addClass("is-active");
        $("#panel4v").removeClass("is-active");
        $("#panel5v").removeClass("is-active");
    });
    
    $("#users").click(function(){
        $("#tests").removeClass("is-active");
        $("#users").addClass("is-active");
        $("#stats").removeClass("is-active");
        $("#utils").removeClass("is-active");
        $("#evals").removeClass("is-active");
        $("#panel1v").removeClass("is-active");
        $("#panel3v").addClass("is-active");
        $("#panel2v").removeClass("is-active");
        $("#panel4v").removeClass("is-active");
        $("#panel5v").removeClass("is-active");
    });
    
    $("#utils").click(function(){
        $("#tests").removeClass("is-active");
        $("#utils").addClass("is-active");
        $("#stats").removeClass("is-active");
        $("#stats").removeClass("is-active");
        $("#evals").removeClass("is-active");
        $("#panel1v").removeClass("is-active");
        $("#panel4v").addClass("is-active");
        $("#panel2v").removeClass("is-active");
        $("#panel3v").removeClass("is-active");
        $("#panel5v").removeClass("is-active");
    });

    $("#evals").click(function(){
        $("#tests").removeClass("is-active");
        $("#utils").removeClass("is-active");
        $("#stats").removeClass("is-active");
        $("#stats").removeClass("is-active");
        $("#evals").addClass("is-active");
        $("#panel1v").removeClass("is-active");
        $("#panel4v").removeClass("is-active");
        $("#panel2v").removeClass("is-active");
        $("#panel3v").removeClass("is-active");
        $("#panel5v").addClass("is-active");
    });
    
    $("#search").click(function(){
        var email = $("#email").val();
        $.ajax({
            type: "GET",
            url : "{{url('/admin/user/info?email=')}}"+email,
            contentType : "application/json",
            success: function(data) {
                var user = data['user'];
                var rol = data['rol'];
                userCard(user, rol);
            }
        });
    });
    
    function userCard(user, rol){
        var temp = '<div class="card end" style="margin: auto 5px; padding-top: 5px; padding-left: 30px">\n\
<div class="h5">Nombre: line0</div>\n\
<div class="h5">Apellidos: line1</div>\n\
<div class="h5">Actualizado: line2</div>\n\
<div class="h5">Nacimiento: line3</div>\n\
<div class="h5">País: line4</div>\n\
<div class="h5">Ciudad: line5</div>\n\
<div class="h5">Institución: line6</div>\n\
<div class="h5">Especialidad: line7</div>\n\
<div class="h5">Estudiante Id: line8</div><br/>\n\
<div class="row"><label for="rolUser" class="radio h5">Usuario</label>\n\
<input type="radio" name="rols" value="0" id="rolUser">\n\
<label for="rolTester" class="radio h5">Tester</label>\n\
<input type="radio" name="rols" value="1" id="rolTester">\n\
<label for="rolAdmin" class="radio h5">Admin</label>\n\
<input type="radio" name="rols" value="2" id="rolAdmin">\n\
</div><br/></div>';
        var res = temp.replace('line0',user.first_name);
        res = res.replace('line1', user.last_name);
        res = res.replace('line2', user.updated_at);
        res = res.replace('line3', user.birthdate);
        res = res.replace('line4', user.country);
        res = res.replace('line5', user.city);
        res = res.replace('line6', user.institution_name);
        res = res.replace('line7', user.speciality);
        res = res.replace('line8', user.studentid);
        $("#user-card").html(res);
        if (rol == 0){
            $('label[for=rolUser]').addClass('checked');
        }
        if (rol == 1){
            $('label[for=rolTester]').addClass('checked');
        }
        if (rol == 2){
            $('label[for=rolAdmin]').addClass('checked');
        }
        var userId = user.id;
        $('label[for=rolUser]').click(function(){
            $('label[for=rolUser]').addClass('checked');
            $('label[for=rolTester]').removeClass('checked');
            $('label[for=rolAdmin]').removeClass('checked');
            changeRol(userId, 0);
        })
        $('label[for=rolTester]').click(function(){
            $('label[for=rolUser]').removeClass('checked');
            $('label[for=rolTester]').addClass('checked');
            $('label[for=rolAdmin]').removeClass('checked');
            changeRol(userId, 1);
        })
        $('label[for=rolAdmin]').click(function(){
            $('label[for=rolUser]').removeClass('checked');
            $('label[for=rolTester]').removeClass('checked');
            $('label[for=rolAdmin]').addClass('checked');
            changeRol(userId, 2);
        })
    }
    
    function fillTableUsers1(data){       
        var head = '<table><thead><tr class="h5">\n\
                    <th>Año</th>\n\
                    <th>Mes</th>\n\
                    <th>Profesores</th>\n\
                    <th>Estudiantes</th>\n\
                    </tr></thead><tbody>';
        var tmpl = '<tr class="h5"><td>col1</td><td>col2</td>\n\
    <td>col3</td><td>col4</td></tr>';
        for (i=0; i<data.length; i++){
            var ent = data[i];
            res = tmpl.replace('col1',ent.f_year);
            res = res.replace('col2',moment().month(ent.n_month-1).format("MMMM"));
            res = res.replace('col3',ent.teachers);
            res = res.replace('col4',ent.students);
            head = head + res;
        } 
        var body = head+'</tbody></table>';
        $("#users1").append(body);

    }
    
    function fillTableUsers2(data){       
        var head = '<table><thead><tr class="h5">\n\
                    <th>Año</th>\n\
                    <th>Mes</th>\n\
                    <th>Perú</th>\n\
                    <th>Extranjeros</th>\n\
                    </tr></thead><tbody>';
        var tmpl = '<tr class="h5"><td>col3</td><td>col4</td>\n\
    <td>col1</td><td>col2</td></tr>';
        for (i=0; i<data.length; i++){
            var ent = data[i];
            var res = tmpl.replace('col1',ent.peru);
            res = res.replace('col2',ent.others);
            res = res.replace('col3',ent.f_year);
            res = res.replace('col4',moment().month(ent.n_month-1).format("MMMM"));
            head = head + res;
        } 
        var body = head+'</tbody></table>';
        $("#users2").append(body);

    }
    
    function fillTableUsers3(data){       
        var head = '<table><thead><tr class="h5"><th>Ciudad</th>\n\
<th>Usuarios</th></tr></thead><tbody>';
        var tmpl = '<tr class="h5"><td>col1</td><td>col2</td></tr>';
        for (i=0; i<data.length; i++){
            var ent = data[i];
            var res = tmpl.replace('col1',ent.city);
            res = res.replace('col2',ent.users);
            head = head + res;
        } 
        var body = head+'</tbody></table>';
        $("#users3").append(body);

    }
    
    
    function fillTableConcurso(data){       
        var head = '<table><thead><tr class="h5"><th>Grupo</th>\n\
<th>Votos</th></tr></thead><tbody>';
        var tmpl = '<tr class="h5"><td>col1</td><td>col3</td></tr>';
        for (i=0; i<data.length; i++){
            var ent = data[i];
            var res = tmpl.replace('col1',ent.team);
            res = res.replace('col3',ent.votes);
            head = head + res;
        } 
        var body = head+'</tbody></table>';
        $("#concurso").append(body);

    }
    
    function changeRol(user, num){
        var opts = {
            'userId' : user,
            'rol': num
        };
        $.ajax({
            type : 'POST',
            url : "{{url('/admin/rol/new')}}",
            dataType: "json",
            contentType : 'application/json',
            data: JSON.stringify(opts),
            success: function(data) {
                
            }
        });
    }

    $("#startEval1").click(function(){
        var evalCustomId = $("#evalCustomId").val();
        $.ajax({
        type: "POST",
        url: "{{url('/web/exam/teacher/1/custom/eval/new/')}}"+"/"+evalCustomId,
        dataType: "json",
        contentType : 'application/json',
        success: function(data, status) {
          lessonId = data['lesson_id'];
          code = data['code'];
        }
      });
    });

    var examView = null;

    $("#endEval1").click(function(){
        var evalCustomId = $("#evalCustomId").val();
        $.ajax({
            type: "POST",
            url: "{{url('/web/exam/teacher/1/remove/custom/eval/')}}"+"/"+evalCustomId,
            contentType : 'application/json',
            success: function(data, status) {
            examView.status = 1;
            } 
        });
    });

    $("#sendEval1").click(function(){
        var evalCustomId = $("#evalCustomId").val();
        $.ajax({
        type: "GET",
        url: "{{ url('web/exam/email/1/custom/eval/') }}"+"/"+evalCustomId,
        dataType: "json",
        success: function(data, status){
          
        }
      });
    });
    
});
</script>

<script id="jsfoundation" src="{{asset('js/material-foundation.js')}}"></script> 
@stop


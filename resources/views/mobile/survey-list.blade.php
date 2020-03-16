@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('js/js.cookie.js')}}"></script>
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="full">
<div class="container wrapper">

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button id="satisfaction" class="btn btn-lg btn-green btn-block">
            @lang('labels.text_satisfaction_level')
        </button>
    </div>
	
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button id="qualification" class="btn btn-lg btn-green btn-block">
            @lang('labels.text_qualification')
        </button>
    </div>
	
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button id="speaker" class="btn btn-lg btn-green btn-block">
            @lang('labels.text_speaker_examination')
        </button>
    </div>
	
</div>
</div>

<div id="modal-answer" class="modal fade" role="dialog">
  <div class="modal-dialog">
     <div class="modal-wrapper">
      <div class="modal-content modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="text-center"><br/><br/>
                ¿Es la misma clase?
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-dialog" id="dlg-send">Sí</button>
            <br/>
            <button type="button" class="btn btn-dialog" id="dlg-cancel">No</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/questions/'.$userid.'/'.$mode.'/'.$code) }}");
    $("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/1') }}");
	
    var user = {{$userid}};
    var mode = {{$mode}};
    var lessonid = "0";
    var code = "{{$code}}";

    var nextUrl1, nextUrl2, sub, exr, qst, svy;
    var keepCode = Cookies.getJSON('keepCode');
    var d = new Date();
    var start = keepCode['startTime'];
    var elapsed = (d.getTime()-start)/(60*1000);
    var isZero = (code == "0000");
	
    $("#satisfaction").click(function (){
        sub = 0;
        exr = 0;
        qst = 4;
        svy = 2;
        sameCode();	
    });

    $("#qualification").click(function (){
        sub = 0;
        exr = 0;
        qst = 4;
        svy = 4;
        sameCode();	
    });

    $("#speaker").click(function (){
        sub = 0;
        exr = 0;
        qst = 4;
        svy = 5;
        sameCode();	
    });
	
	
    function sameCode(){
        var idxTime = keepCode['idxTime'];
        if (isZero) {
            keepCode['idxTime']=1;
            Cookies.set('keepCode', JSON.stringify(keepCode));
            goToNextUrl();
                /*
        } else if( elapsed > 30 && !isZero && idxTime == 1 ) {
            $("#modal-answer").modal("show");	
        } else if( elapsed > 30 && !isZero && idxTime == 2 ){
            getCode();
        } else if( elapsed > 60 && !isZero && idxTime == 2 ) {
            $("#modal-answer").modal("show");	
        } else if( elapsed > 60 && !isZero && idxTime == 3 ){
            getCode();
        } else if( elapsed > 90 && !isZero && idxTime == 3 ) {
            $("#modal-answer").modal("show");	
        } else if( elapsed > 90 && !isZero && idxTime == 4 ){
            getCode();
			*/
        } else  if (elapsed > 120 && !isZero){
            keepCode['idxTime']=1;
            keepCode['startTime']=d.getTime();
            keepCode['code']='0000';
            goToNextUrl();
        } else {
            $("#modal-answer").modal("show");
            //getCode();
        }
    };
	
    $("#dlg-send").click(function(){
        $("#modal-answer").modal("hide");
        keepCode['idxTime']=2;
        /*
        if ( elapsed > 30 ){
                keepCode['idxTime']=2;
        } else if ( elapsed > 60 ){
                keepCode['idxTime']=3;
        } else if ( elapsed > 90 ){
                keepCode['idxTime']=4;
        }
        */
        Cookies.set('keepCode', JSON.stringify(keepCode));
        getCode();
    });
	
    $("#dlg-cancel").click(function(){
        $("#modal-answer").modal("hide");
        keepCode['startTime']=d.getTime();
        keepCode['code']='0000';
        Cookies.set('keepCode', JSON.stringify(keepCode));
        goToNextUrl();
    })
	
	
    function getCode(){
        var vardata = {
            course_id : -1,
            evaluation_id: 0,
            accesscode: code,
            subject : sub,
            exercise : exr,
            inactive: 0,
            app_mode: mode,
            run: 1,
            survey: svy,
            question_type: qst,
            question_mode: 0
        };
        $.ajax({
            type: "POST",
            url: "{{ url('web/code/'.$userid) }}",
            dataType: "json",
            contentType : 'application/json',
            data: JSON.stringify(vardata),
            success: function(data, status) {
                lessonid = data['id'];
                var run = data['run'];
                code = data['accesscode'];
                myurl = "{{url('/web/result/1/')}}"+'/'+qst+'/1/'+svy+'/'+exr+'/'+sub+'/'+code+'/'+lessonid+'/'+user+'/'+mode;
                window.location.replace(myurl);					
            }
        });
    }
	
	
    function goToNextUrl(){
        if (svy==2){
            nextUrl1 = "{{url('/web/session/4/2/0/0/')}}"+'/0000/'+lessonid+'/'+user+'/'+mode;
        } else if (svy==4){
            nextUrl1 = "{{url('/web/session/4/4/0/0/')}}"+'/0000/'+lessonid+'/'+user+'/'+mode;
        } else if (svy==5){
            nextUrl1 = "{{url('/web/session/4/5/0/0/')}}"+'/0000/'+lessonid+'/'+user+'/'+mode;
        }
        window.location.replace(nextUrl1);
    }
	
});
</script>

@stop



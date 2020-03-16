@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/exam.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')

<div class="full">
  <div class="container wrapper">

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <a href="{{url('/web/exam/teacher/').'/'.$user_id.'/'.$mode.'/new'}}" 
         class="btn btn-xlg btn-option btn-block">
        CREAR EVALUACIÓN
      </a>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <a href="{{url('/web/exam/teacher/').'/'.$user_id.'/'.$mode.'/fci'}}" 
         class="btn btn-xlg btn-option btn-block">
        FCI
      </a>
    </div>

    <!--div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <a href="{{url('/web/exam/teacher/').'/'.$user_id.'/'.$mode.'/board'}}" 
         class="btn btn-xlg btn-option btn-block">
        VER EVALUACIONES
      </a>
    </div-->

  </div>
</div>

<script>
$(document).ready(function(){
  $("#back-icon").attr("href", "{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/1') }}");
  $("#exit-icon").attr("href", "{{ url('/web/board/'.$user_id.'/'.$mode.'/0000/1') }}");
  //$("#back-icon").attr("href", "{{url('/web/exam/testing')}}");
  //$("#exit-icon").attr("href", "{{url('/web/exam/testing')}}");
});
</script>

@stop



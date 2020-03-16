@extends('layouts.layout01')

@section('header')
<link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/board.min.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
@include('toolbars.toolbar-2btn')
<br/>
<div class="manual">
<div class="container manual-wrapper">
	<br/>
	<div class="text-center">
	<h4 id="title"><b>ANDROID</b></h4>
	</div>
	<br/>
	<div id="content">
	<p class="text-center"><a href='https://play.google.com/store/apps/details?id=com.equipu.profeplus&hl=es&pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img alt='Disponible en Google Play' src='https://play.google.com/intl/en_us/badges/images/generic/es-419_badge_web_generic.png' width="300"/></a></p>
	</div>
	<br/>
	<div class="text-center">
	<h4 id="title"><b>Usuarios iOS</b></h4>
	</div>
	<br/>
	<div id="content">
	<p class="text-center">Para participar ingrese desde su iPhone al sitio web:</p>
	<p class="text-center"><a href="http://www.profeplus.org">www.profeplus.org</a></p>
	</div>
	<br/>
</div>
</div>

<script>
$(document).ready(function(){
    $("#back-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/'.$type) }}");
	$("#exit-icon").attr("href", "{{ url('/web/board/'.$userid.'/'.$mode.'/'.$code.'/'.$type) }}");
});
</script>

@stop



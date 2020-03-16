<!doctype html>
<html lang="es" prefix="og: http://ogp.me/ns#">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ProfePlus</title>
<meta property="og:title" content="ProfePlus" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://www.e-quipu.pe/profeplus" />
<meta property="og:image" content="{{asset('images/logo.png')}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
<!--link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Atma:400,500,600,700,300" type="text/css" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Arima+Madurai:200,300,400,500,700,800" rel="stylesheet"-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
<!-- Latest compiled and minified CSS -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<!-- Optional theme -->
<link href="{{asset('css/bootstrap-theme.css')}}" rel="stylesheet" type="text/css">
<!-- Latest compiled and minified JavaScript -->
<script src="{{asset('js/bootstrap.js')}}" type="text/javascript"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85631265-1', 'auto');
  ga('send', 'pageview');

</script>
@yield('header')
</head>
<body>
@yield('content')
</body>
</html>

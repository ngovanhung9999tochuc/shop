<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thế giới điện tử</title>

  <!-- Google Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{asset('/ustora/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/ustora/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('/Admin/plugins/fontawesome-free/css/all.min.css')}}">

  <!-- iCheck -->
  <!-- JQVMap -->
  <!-- Theme style -->
  <!-- overlayScrollbars -->
  <!-- Daterange picker -->
  <!-- summernote -->
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{asset('/ustora/style.css')}}">
  <link rel="stylesheet" href="{{asset('/ustora/css/responsive.css')}}">
  <link rel="stylesheet" href="{{asset('/ustora/style1.css')}}">
  <link rel="stylesheet" href="{{asset('/ustora/login.css')}}">
  <link rel="stylesheet" href="{{asset('/ustora/login1.css')}}">

  @yield('css')

</head>

<body>



  <!-- header area -->
  @include('front_end.parials.header')
  <!-- site branding area -->


  <!-- content -->
  @yield('content')


  <!-- JQuery-->
  <!-- Latest jQuery form server -->
  <script src="{{asset('/ustora/jquery.min.js')}}"></script>
  <!-- Bootstrap JS form CDN -->
  <script src="{{asset('/ustora/bootstrap.min.js')}}"></script>
  <script src="{{asset('vendor/sweetalert2@10.js')}}"></script>
  <script src="{{asset('font_end/layout.js')}}"></script>

  @yield('js')
  @php
  if(Session::has('messageCheckOut')){
  echo Session::get('messageCheckOut');
  }
  @endphp
</body>

</html>
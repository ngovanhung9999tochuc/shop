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
  <link rel="stylesheet" href="/ustora/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/ustora/css/font-awesome.min.css">
  <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="/ustora/css/owl.carousel.css">
  <link rel="stylesheet" href="/ustora/style.css">
  <link rel="stylesheet" href="/ustora/css/responsive.css">
  <link rel="stylesheet" href="/ustora/style1.css">
  <link rel="stylesheet" href="/ustora/login.css">
  <link rel="stylesheet" href="/ustora/login1.css">

  @yield('css')

</head>

<body>



  <!-- header area -->
  @include('front_end.parials.header')
  <!-- site branding area -->

  <!-- mainmenu area -->
  @include('front_end.parials.mainmenu')

  <!-- content -->
  @yield('content')

  <!-- footer top area -->
  @include('front_end.parials.footer')
  <!-- footer bottom area -->


  <!-- JQuery-->
  <!-- Latest jQuery form server -->
  <script src="/ustora/jquery.min.js"></script>
  <!-- Bootstrap JS form CDN -->
  <script src="/ustora/bootstrap.min.js"></script>
  <!-- jQuery sticky menu -->
  <script src="/ustora/js/owl.carousel.min.js"></script>
  <script src="/ustora/js/jquery.sticky.js"></script>

  <!-- jQuery easing -->
  <script src="/ustora/js/jquery.easing.1.3.min.js"></script>

  <!-- Main Script -->
  <script src="/ustora/js/main.js"></script>

  <!-- Slider -->
  <script type="text/javascript" src="/ustora/js/bxslider.min.js"></script>
  <script type="text/javascript" src="/ustora/js/script.slider.js"></script>
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
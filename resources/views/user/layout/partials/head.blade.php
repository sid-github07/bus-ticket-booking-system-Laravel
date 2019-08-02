<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{$gs->website_title}} - @yield('title')</title>
<!-- favicon -->
<link rel="shortcut icon" href="{{asset('assets/user/interfaceControl/logoIcon/icon.jpg')}}" type="image/x-icon">
<!--Google Font-->
<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,600i,700" rel="stylesheet">
<!--Bootstrap Stylesheet-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/bootstrap.min.css')}}">
<!--Owl Carousel Stylesheet-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/plugins/owl.carousel.min.css')}}">
<!--Slick Slider Stylesheet-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/plugins/slick-theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/plugins/slick.css')}}">
<!--Font Awesome Stylesheet-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/font-awesome.min.css')}}">
<!--venobox Stylesheet-->
<link rel="stylesheet" type="text/css" href="css/plugins/venobox.css">
<!--Animate Stylesheet-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/plugins/animate.css')}}">
{{-- File input CSS --}}
<link href="{{ asset('assets/plugins/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/packeg.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/bc.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<!--Main Stylesheet-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/style.css')}}">
<!--Responsive Stylesheet-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/user/css/homePageResponsive.css')}}">
<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-timepicker/jquery.timepicker.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@stack('styles')
{{-- Base Color Change... --}}
<link href="{{url('/')}}/assets/user/css/themes/base-color.php?color={{$gs->base_color_code}}" rel="stylesheet">



<!--jQuery JS-->
<script src="{{asset('assets/user/js/jquery.2.1.2.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

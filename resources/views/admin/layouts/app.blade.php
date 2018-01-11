<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="" name="description" />
        <meta content="webthemez" name="author" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', '350点餐后台') - 350点餐后台</title>
        <!-- Bootstrap Styles-->
        <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" />
        <!-- FontAwesome Styles-->
        <link href="{{asset('assets/css/font-awesome.css')}}" rel="stylesheet" />
        {{--checkbox select Style--}}
        <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" >
        <link href="{{asset('assets/css/checkbox3.min.css')}}" rel="stylesheet" >
        <!-- Morris Chart Styles-->
        <link href="{{asset('assets/js/morris/morris-0.4.3.min.css')}}" rel="stylesheet" />
        <!-- Custom Styles-->
        <link href="{{asset('assets/css/custom-styles.css')}}" rel="stylesheet" />
        <!-- Google Fonts-->
        {{--<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />--}}
        {{--<link rel="stylesheet" href="{{asset('assets/js/Lightweight-Chart/cssCharts.css')}}">--}}
        @section('css')
            <style type="text/css">
                label {
                    cursor: pointer;
                    margin-left: 10px;
                }
            </style>
            @stop
    </head>

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7"> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8"> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body>
<!--<![endif]-->


<div id="wrapper">

    @include('admin.layouts.nav')
    @include('admin.layouts._message')
    @yield('content')

</div>


<!-- JS Scripts-->
<!-- jQuery Js -->
<script src="{{asset('assets/js/jquery-1.10.2.js')}}"></script>
<!-- Bootstrap Js -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Js -->
<script src="{{asset('assets/js/jquery.metisMenu.js')}}"></script>
<script src="{{asset('assets/js/select2.full.min.js')}}"></script>
<!-- Morris Chart Js -->
<script src="{{asset('assets/js/morris/raphael-2.1.0.min.js')}}"></script>
<script src="{{asset('assets/js/morris/morris.js')}}"></script>


<script src="{{asset('assets/js/easypiechart.js')}}"></script>
<script src="{{asset('assets/js/easypiechart-data.js')}}"></script>

<script src="{{asset('assets/js/Lightweight-Chart/jquery.chart.js')}}"></script>

<!-- 定制 Js -->
<script src="{{asset('assets/js/custom-scripts.js')}}"></script>


<!-- 图表 Js -->
<script type="text/javascript" src="{{asset('assets/js/chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/chartjs.js')}}"></script>

{{-- laydate时间选择插件 --}}
<script type="text/javascript" src="{{asset('laydate/laydate.js')}}"></script>

@yield('scripts')
</body>>
</html>
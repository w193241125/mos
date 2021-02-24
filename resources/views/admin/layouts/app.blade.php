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

            <!-- Google Font: Source Sans Pro 谷歌字体-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome 字体插件-->
  <link rel="stylesheet" href="{{asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons 图标插件-->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 日期选择器插件-->
  <link rel="stylesheet" href="{{asset('AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck checkbox 选择插件-->
  <link rel="stylesheet" href="{{asset('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap 向量地图插件-->
  <link rel="stylesheet" href="{{asset('AdminLTE/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style 主题样式-->
  <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars 滚动条插件-->
  <link rel="stylesheet" href="{{asset('AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker 范围日期选择插件-->
  <link rel="stylesheet" href="{{asset('daterangepicker/daterangepicker.css')}}">
  <!-- summernote 文本编辑器-->
  <link rel="stylesheet" href="{{asset('AdminLTE/plugins/summernote/summernote-bs4.min.css')}}">
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
<body class="hold-transition sidebar-mini layout-fixed">
<!--<![endif]-->


<div class="wrapper">

    @include('admin.layouts.nav')
    @include('admin.layouts._message')
    @yield('content')

</div>


<!-- jQuery -->
<script src="{{asset('AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('AdminLTE/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('AdminLTE/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('AdminLTE/plugins/sparklines/sparkline.js')}}"></script>

<!-- jQuery Knob Chart -->
<script src="{{asset('AdminLTE/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('AdminLTE/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('AdminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('AdminLTE/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('AdminLTE/dist/js/pages/dashboard.js')}}"></script>
<script>
    //日期选择器配置
    var daterangepicker_config = {
        'daysOfWeek':[
            "日",
            "一",
            "二",
            "三",
            "四",
            "五",
            "六"
        ],
        'monthNames':[
            "一月",
            "二月",
            "三月",
            "四月",
            "五月",
            "六月",
            "七月",
            "八月",
            "九月",
            "十月",
            "十一月",
            "十二月"
        ],
        'format':'YYYY-MM-DD',
    }
    if($('#date').length>0){
        $('#date').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "startDate": @if(!empty($date))"{{$date}}"@else moment()@endif,
            "locale": {
                "format":'YYYY-MM-DD',
                "daysOfWeek": daterangepicker_config.daysOfWeek,
                "monthNames": daterangepicker_config.monthNames,
                "applyLabel": "确认",
                "cancelLabel": "取消",
            }
        });
    }

    if($('#dates').length>0){
        $('#dates').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "startDate": @if(!empty($dates))"{{$dates}}"@else moment()@endif,
            "locale": {
                "format":'YYYY-MM-DD',
                "daysOfWeek": daterangepicker_config.daysOfWeek,
                "monthNames": daterangepicker_config.monthNames,
                "applyLabel": "确认",
                "cancelLabel": "取消",
            }
        });
    }

    if($('#range_date').length>0){
        $('#range_date').daterangepicker({
            "showDropdowns": true,
            "startDate": @if(!empty($start))"{{$start}}"@else moment()@endif,
            "endDate": @if(!empty($end))"{{$end}}"@else moment()@endif,
            "locale": {
                "format":'YYYY-MM-DD',
                "daysOfWeek": daterangepicker_config.daysOfWeek,
                "monthNames": daterangepicker_config.monthNames,
                "applyLabel": "确认",
                "cancelLabel": "取消",
            }
        });
    }

</script>
@yield('scripts')
</body>>
</html>
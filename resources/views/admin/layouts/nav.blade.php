<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
<!-- Left navbar links -->
<ul class="navbar-nav">



  <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
    <a href="{{url('/admin')}}" class="nav-link">首页</a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
    <a href="{{url('/')}}" class="nav-link">去点餐</a>
  </li>


</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
  <li class="nav-item">
    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
      <i class="fas fa-expand-arrows-alt"></i>
    </a>
  </li>
{{--  <li class="nav-item">--}}
{{--    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">--}}
{{--      <i class="fas fa-th-large"></i>--}}
{{--    </a>--}}
{{--  </li>--}}
  <li class="nav-item">
        <a class="nav-link" data-toggle="dropdown" href="#" data-slide="true">
            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user dropdown-menu-right">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out fa-fw"></i> 退出登录</a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="{{url('/')}}" class="brand-link">
  <img src="{{asset('AdminLTE/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
  <span class="brand-text font-weight-light">前往点餐</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar user panel (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{asset('AdminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block">{{Auth::user()->realname}}</a>
    </div>
  </div>


  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
          <a class="nav-link" href="{{url('admin')}}"><i class="nav-icon fas fa-th"></i> <p>主页</p></a>
            </li>
            @if(Auth::user()->state == 3)
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/dayorder')}}"><i class="nav-icon  fa fa-desktop"></i><p> 订单统计</p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/order_summary')}}"><i class="nav-icon  fa fa-desktop"></i> <p> 订单分日统计</p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/order')}}"><i class="nav-icon  fa fa-list"></i> <p> 本周订单列表</p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/companyorder')}}"><i class="nav-icon  fa fa-desktop"></i> <p> 瑞鲨旭力订单统计</p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/allOrder')}}"><i class="nav-icon  fa fa-list"></i> <p> 所有订单列表</p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/shop')}}"><i class="nav-icon  fa fa-list"></i><p> 商家列表</p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/food')}}"><i class="nav-icon  fa fa-list"></i><p> 食物列表</p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/menu')}}"><i class="nav-icon  fa fa-list"></i><p> 菜单列表</p></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('admin/user')}}"><i class="nav-icon  fa fa-user"></i><p> 用户列表</p></a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/setting/timelimited')}}"><i class="nav-icon  fa fa-clock"></i><p> 订餐时间设置</p></a>
            </li>
            <li class="nav-item"> <a class="nav-link"href="{{url('admin/order/countbysort')}}"><i class="nav-icon  fa fa-desktop"></i><p> 分类统计</p></a></li>
                @endif
            @if(Auth::user()->state == 4)
                <li class="nav-item">
                    <a class="nav-link" href="{{url('admin/myorder')}}"><i class="nav-icon  fa fa-desktop"></i> <p> 我的订单列表</p></a>
                    <a class="nav-link" href="{{url('admin/myordercount')}}"><i class="nav-icon  fa fa-desktop"></i><p> 订单统计</p></a>
                    <a class="nav-link" href="{{url('admin/food')}}"><i class="nav-icon  fa fa-desktop"></i><p> 食物设置</p></a>
                    <a class="nav-link" href="{{url('admin/menu')}}"><i class="nav-icon  fa fa-desktop"></i><p> 菜单设置</p></a>
                    @if(Auth::user()->realname == '包大哥' ||  Auth::user()->realname == '客来湘' ||  Auth::user()->realname == '客来湘早餐')
                        <a class="nav-link" href="{{url('admin/order/countbysort')}}"><i class="nav-icon  fa fa-desktop"></i><p> 分类统计</p></a>
                    @endif
                </li>
                @endif

    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>

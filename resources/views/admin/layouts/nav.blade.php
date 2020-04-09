<nav class="navbar navbar-default top-navbar" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{url('/')}}"><strong><i class="icon fa fa-plane"></i> 350点餐后台</strong></a>
        <div id="sideNav" href="">
            <i class="fa fa-bars icon"></i>
        </div>
    </div>

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">

                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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
<!--/. NAV TOP  -->
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> 主页</a>
            </li>
            @if(Auth::user()->state == 3)
            <li>
                <a href="{{url('admin/dayorder')}}"><i class="fa fa-desktop"></i> 订单统计</a>
            </li>
            <li>
                <a href="{{url('admin/order')}}"><i class="fa fa-desktop"></i> 本周订单列表</a>
            </li>
            <li>
                <a href="{{url('admin/companyorder')}}"><i class="fa fa-desktop"></i> 瑞鲨旭力订单统计</a>
            </li>
            <li>
                <a href="{{url('admin/allOrder')}}"><i class="fa fa-desktop"></i> 所有订单列表</a>
            </li>
            <li>
                <a href="{{url('admin/shop')}}"><i class="fa fa-sitemap"></i>商家列表</a>
            </li>
            <li>
                <a href="{{url('admin/food')}}"><i class="fa fa-edit"></i>食物列表</a>
            </li>
            <li>
                <a href="{{url('admin/menu')}}"><i class="fa fa-adn"></i>菜单列表</a>
            </li>
            <li>
                <a href="{{url('admin/user')}}"><i class="fa fa-user"></i>用户列表</a>
            </li>
                <li>
                <a href="{{url('admin/setting/timelimited')}}"><i class="fa fa-user"></i>订餐时间设置</a>
            </li>
                <li> <a href="{{url('admin/order/countbysort')}}"><i class="fa fa-desktop"></i>分类统计</a></li>
                @endif
            @if(Auth::user()->state == 4)
                <li>
                    <a href="{{url('admin/myorder')}}"><i class="fa fa-desktop"></i> 我的订单列表</a>
                    <a href="{{url('admin/myordercount')}}"><i class="fa fa-desktop"></i>订单统计</a>
                    <a href="{{url('admin/food')}}"><i class="fa fa-desktop"></i>食物设置</a>
                    <a href="{{url('admin/menu')}}"><i class="fa fa-desktop"></i>菜单设置</a>
                    @if(Auth::user()->realname == '包大哥' ||  Auth::user()->realname == '客来湘' ||  Auth::user()->realname == '客来湘早餐')
                    <a href="{{url('admin/order/countbysort')}}"><i class="fa fa-desktop"></i>分类统计</a>
                    @endif
                </li>
                @endif
        </ul>

    </div>

</nav>
<!-- /. NAV SIDE  -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
        | Teknomines
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('public/assets/images/favicon.ico') }}" type="image/x-icon">
    <link href="{{ asset('public/assets/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/iCheck/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/iCheck/css/line/line.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/bootstrap-switch/css/bootstrap-switch.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/switchery/css/switchery.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/awesome-bootstrap-checkbox/css/awesome-bootstrap-checkbox.css') }}">
    <link href="{{ asset('public/assets/css/pages/icon.css') }}" rel="stylesheet" type="text/css" />
   
    @yield('header_styles')
<style type="text/css">
    .logo_header_text{
        color: #fff !important;
        margin-top: 10px !important;
    }
</style>


<body class="skin-josh">
<header class="header">
    <a href="{{ route('home') }}" class="logo">
       <h3 class="logo_header_text">Teknomines</h3>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <div class="navbar-right toggle">
            <ul class="nav navbar-nav  list-inline">
                <li class=" nav-item dropdown user user-menu">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        @if(Auth::user()->userProfile == NULL )
                        <img src="{{ asset('public/assets/images/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px" class="rounded-circle img-fluid float-left"/>
                        @elseif(Auth::user()->userProfile->photo == '' )
                        <img src="{{ asset('public/assets/images/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px" class="rounded-circle img-fluid float-left"/>
                        @else
                        <img src="{{ asset('storage/app/'.Auth::user()->userProfile->photo) }}" alt="img" height="35px" width="35px" class="rounded-circle img-fluid float-left"/>
                        @endif
                        
                        <div class="riot">
                            <div>
                                <p class="user_name_max">{{ Auth::user()->name }}</p>
                                <span>
                                        <i class="caret"></i>
                                    </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                        @if(Auth::user()->userProfile == NULL )
                        <img src="{{ asset('public/assets/images/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px" class="rounded-circle img-fluid float-left"/>
                        @elseif(Auth::user()->userProfile->photo == '' )
                        <img src="{{ asset('public/assets/images/authors/no_avatar.jpg') }}" alt="img" height="35px" width="35px" class="rounded-circle img-fluid float-left"/>
                        @else
                        <img src="{{ asset('storage/app/'.Auth::user()->userProfile->photo) }}" alt="img" height="35px" width="35px" class="rounded-circle img-fluid float-left"/>
                        @endif
                            
                            <p class="topprofiletext">{{ Auth::user()->name }}</p>
                        </li>
                        <!-- Menu Body -->
                        <li>
                            <a href="{{route('profile')}}">
                                <i class="livicon" data-name="user" data-s="18"></i>
                                My Profile
                            </a>
                        </li>
                        <li role="presentation"></li>
                        <li>
                            <a href="{{route('changePassword')}}">
                                <i class="livicon" data-name="gears" data-s="18"></i>
                                Account Settings
                            </a>
                        </li>
                        <li role="presentation"></li>
                        <li>
                            <a href="{{ URL::to('admin/logout') }}">
                                <i class="livicon" data-name="sign-out" data-s="18"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>
<div class="wrapper ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side ">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="nav_icons">
                    <ul class="sidebar_threeicons">
                        <!-- <li>
                            <a href="{{ URL::to('admin/advanced_tables') }}">
                                <i class="livicon" data-name="table" title="Advanced tables" data-loop="true"
                                   data-color="#418BCA" data-hc="#418BCA" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/tasks') }}">
                                <i class="livicon" data-name="list-ul" title="Tasks" data-loop="true"
                                   data-color="#e9573f" data-hc="#e9573f" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/gallery') }}">
                                <i class="livicon" data-name="image" title="Gallery" data-loop="true"
                                   data-color="#F89A14" data-hc="#F89A14" data-s="25"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ URL::to('admin/users') }}">
                                <i class="livicon" data-name="user" title="Users" data-loop="true"
                                   data-color="#6CC66C" data-hc="#6CC66C" data-s="25"></i>
                            </a>
                        </li> -->
                    </ul>
                </div>
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
                @include('layouts._left_menu')
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">
        <div id="notific">
        @include('notifications')
        </div>
         @yield('content')
         
    </aside>
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>

<script src="{{ asset('public/assets/js/app.js') }}" type="text/javascript">

</script>
    <script type="text/javascript" src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/vendors/switchery/js/switchery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/vendors/bootstrap-maxlength/js/bootstrap-maxlength.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/vendors/card/lib/js/jquery.card.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/assets/js/pages/radio_checkbox.js') }}"></script>
    

    <script type="text/javascript" src="{{asset('public/assets/js/jquery-2.1.4.js')}}"></script>
     
    <script type="text/javascript" src="{{ asset('public/prettyPhoto/js/jquery.prettyPhoto.js')}}"></script>
@yield('footer_scripts')
</body>
</html>

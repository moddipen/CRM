<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Welcome to Admin panel</title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/bootstrap.css') }}">
    <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('public/assets/images/favicon.png') }}" type="image/x-icon">
    <!--end of global css-->
    <!--page level css starts-->
    <link type="text/css" rel="stylesheet" href="{{asset('public/assets/vendors/iCheck/css/all.css')}}" />
    <link href="{{ asset('public/assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/frontend/login.css') }}">
    <!--end of page level css-->
</head>
<body>
<div class="container">
    <!--Content Section Start -->
    <div class="row">
        <div class="box animation flipInX font_size ">
            <div class="box1" align = 'center'>
               <img src="{{ asset('public/img/logo.png') }}" style="height : 50px; margin-bottom : 25px; " ><br/>
                <h3 class="text-primary">Forgot Password</h3>
                <p>Enter your email to reset your password</p>
                <!-- Notifications -->
                <div id="notific">
                @include('notifications')
                </div>
                <form action="{{route('send.password')}}" class="omb_loginForm" autocomplete="off" method="POST">
                
                @csrf
                <div class="form-group">
                    <label class="sr-only"></label>
                    <input type="email" class="form-control email" name="email" placeholder="Email"
                           value="{!! old('email') !!}">
                    <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                </div>
                <div class="form-group">
                    <input class="form-control btn btn-primary btn-block" type="submit" value="Reset Your Password">
                </div>
            </form>

            <a href="{{ route('login') }}"> Back to login</a>
                
            </div>
                
            
        </div>
    </div>
    <!-- //Content Section End -->
</div>
<!--global js starts-->
<script type="text/javascript" src="{{ asset('public/assets/js/frontend/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/frontend/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/frontend/login_custom.js') }}"></script>
<!--global js end-->
</body>
</html>

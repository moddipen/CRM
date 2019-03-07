@extends('layouts/default')

{{-- Page title --}}
@section('title')
    User Profile
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('public/assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('public/assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/css/pages/wizard.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/prettyPhoto/css/prettyPhoto.css')}}">
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>User Profile</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="{{route('user.index')}}">User</a></li>
            <li class="active">User Profile</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-lg-2 my-3">
            </div>
            <div class="col-md-8 col-sm-8 col-lg-8 my-3">
                <div class="card panel-primary">
                    <div class="card-heading">
                        <h3 class="card-title">
                            <i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            User Profile
                        </h3>
                            <span class="float-right clickable">
                                <i class="fa fa-chevron-up"></i>
                            </span>
                    </div>
                    <div class="card-body">
                        <!--main content-->
                        <form id="commentForm" action="#"
                              method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div id="rootwizard">
                                <ul>
                                    <li class="nav-item"><a href="#tab1" data-toggle="tab"></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane " id="tab1">
                                        
                                        <div class="form-group ">
                                            <div class="row">
                                            <label for="first_name" class="col-sm-2 control-label">First Name *</label>
                                            <div class="col-sm-10">
                                                <input id="name" disabled name="name" type="text"
                                                       placeholder="Name" class="form-control required"
                                                       value="{{ $viewUser['firstname'] }}"/>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">Last Name *</label>
                                                <div class="col-sm-10">
                                                    <input id="email" disabled name="email" placeholder="E-mail" type="text"
                                                           class="form-control required email" value="{{$viewUser['lastname']}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">Address*</label>
                                                <div class="col-sm-10">
                                                    <input id="email" readonly name="email" placeholder="E-mail" type="text"
                                                           class="form-control required email" value="{{$viewUser['address']}}"/>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="form-group ">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">Phone Number*</label>
                                                <div class="col-sm-10">
                                                    <input id="email" readonly name="email" placeholder="E-mail" type="text"
                                                           class="form-control required email" value="{{$viewUser['phone_number']}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">Date Of Birth*</label>
                                                <div class="col-sm-10">
                                                    <input id="email" readonly name="email" placeholder="E-mail" type="text"
                                                           class="form-control required email" value="{{$viewUser['dob']}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">Photo*</label>
                                                <div class="col-sm-10">
                                                    <a rel="prettyPhoto" href="{{ asset('storage/app/'.$viewUser['photo']) }}" width="100px;" height="60px;" ><img width="75px;" height="75px;" src="{{ asset('storage/app/'.$viewUser['photo']) }}"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-lg-2 my-3">
            </div>
        </div>

        <!--row end-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('public/assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('public/assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/pages/adduser.js') }}"></script>
    <script src="{{ asset('public/assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>

   <script type="text/javascript" src="{{ asset('public/prettyPhoto/js/jquery-1.6.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/prettyPhoto/js/jquery.prettyPhoto.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("a[rel^='prettyPhoto']").prettyPhoto({'social_tools':false});
        });
    </script>
@stop

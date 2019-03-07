@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Add User
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
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Add New User</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="{{route('user.index')}}">User</a></li>
            <li class="active">Add New User</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 my-3">
                <div class="card panel-primary">
                    <div class="card-heading">
                        <h3 class="card-title">
                            <i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            Add New User
                        </h3>
                                <span class="float-right clickable">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                    </div>
                    <div class="card-body">
                        <!--main content-->
                        <form id="commentForm" action="{{ route('user.store') }}"
                              method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div id="rootwizard">
                                <ul>
                                    <li class="nav-item"><a href="#tab1" data-toggle="tab"></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane " id="tab1">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                            <div class="row">
                                            <label for="first_name" class="col-sm-2 control-label">Name *</label>
                                            <div class="col-sm-10">
                                                <input id="name" name="name" type="text"
                                                       placeholder="Name" class="form-control required"
                                                       value="{!! old('first_name') !!}"/>

                                                {!! $errors->first('name', '<span id="name_error" class="help-block">:message</span>') !!}
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">Email *</label>
                                                <div class="col-sm-10">
                                                    <input id="email" name="email" placeholder="E-mail" type="text"
                                                           class="form-control required email" value="{!! old('email') !!}"/>
                                                    {!! $errors->first('email', '<span id="email_error" class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                            <div class="row">
                                                <label for="password" class="col-sm-2 control-label">Password *</label>
                                                <div class="col-sm-10">
                                                    <input id="password" name="password" type="password" placeholder="Password"
                                                           class="form-control required" value="{!! old('password') !!}"/>
                                                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                                            <div class="row">
                                            <label for="password_confirm" class="col-sm-2 control-label">Confirm Password *</label>
                                            <div class="col-sm-10">
                                                <input id="password_confirm" name="password_confirm" type="password"
                                                       placeholder="Confirm Password " class="form-control required"/>
                                                {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('role_id', 'has-error') }}">
                                            <div class="row">
                                                <label for="select21" class="col-sm-2 control-label">
                                                        Role *
                                                </label>
                                                <div class="col-sm-10">
                                                    <select id="select21" name="role_id" class="form-control select2">
                                                        <option value="">Select Role</option>
                                                        @foreach($roles as $val){
                                                            <option value="{{$val->id}}">{{$val->name}}</option>
                                                        }
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('role_id', '<span id="select_id" class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                         
                                        <button align = 'center' type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="Create User" id="delButton">Create</button>
                                    
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
    <script>
        function formatState (state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="{{ asset('public/assets/img/countries_flags') }}/'+ state.element.value.toLowerCase() + '.png" class="img-flag" width="20px" height="20px" /> ' + state.text + '</span>'
            );
            return $state;

        }
        $("#countries").select2({
            templateResult: formatState,
            templateSelection: formatState,
            placeholder: "select a country",
            theme:"bootstrap"
        });

        $('#name').on('keyup',function(){
            $('#name_error').hide();
        });

        $('#email').on('keyup',function(){
            $('#email_error').hide();
        });

        $('#select21').on('change',function(){
            $('#select_id').hide();
        });

    </script>

@stop

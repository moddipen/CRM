@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Edit User
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
        <h1>Edit User</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="{{route('user.index')}}">User</a></li>
            <li class="active">Edit User</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 my-3">
                <div class="card panel-primary">
                    <div class="card-heading">
                        <h3 class="card-title">
                            <i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            Editing User : <p class="user_name_max">{!! $editUser->name!!}</p>
                        </h3>
                        <span class="float-right clickable">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                    </div>
                    <div class="card-body">
                        <!--main content-->
                        {!! Form::model($editUser, ['url' =>route('user.update',$editUser->id ), 'method' => 'put', 'class' => 'form-horizontal','id'=>'commentForm', 'enctype'=>'multipart/form-data','files'=> true]) !!}
                        {{ csrf_field() }}
                        <!-- CSRF Token -->

                            <div id="rootwizard">
                                <ul>
                                    <li class="nav-item"><a href="#tab1" data-toggle="tab" ></a></li>
                                   
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane " id="tab1">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Name *</label>
                                                <div class="col-sm-10">
                                                    <input id="first_name" name="name" type="text"
                                                           placeholder="Name" class="form-control required"
                                                           value="{!! old('name', $editUser->name) !!}"/>

                                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                         </div>

                                        <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">Email *</label>
                                                <div class="col-sm-10">
                                                    <input id="email" name="email" placeholder="E-mail" type="text"
                                                           class="form-control required email"   value="{!! old('email', $editUser->email) !!}"/>
                                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
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

                                                        @foreach($role as $val)
                                                            @if($editUser->hasRole($val))
                                                                <option  selected value="{{$val->id}}" > {{$val->name}} </option> 
                                                            @else
                                                                 <option value="{{$val->id}}"> {{$val->name}} </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('role_id', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <button align = 'center' type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="Update User" id="delButton">Update</button>
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
    <script src="{{ asset('public/assets/js/pages/edituser.js') }}"></script>
    <script>
        function formatState (state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="{{asset('public/assets/img/countries_flags')}}/'+ state.element.value.toLowerCase() + '.png" class="img-flag" width="20px" height="20px" /> ' + state.text + '</span>'
            );
            return $state;

        }
        $(".country_field").select2({
            templateResult: formatState,
            templateSelection: formatState,
            placeholder: "select a country",
            theme:"bootstrap"
        });

    </script>
@stop

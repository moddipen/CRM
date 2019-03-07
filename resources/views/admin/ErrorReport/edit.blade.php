@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Edit Error
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
    <link href="{{ asset('public/assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <!--end of page level css-->

@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Edit Error</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="{{route('error.index')}}">Error Report</a></li>
            <li class="active">Edit Error</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 my-3">
                <div class="card panel-primary">
                    <div class="card-heading">
                        <h3 class="card-title">
                            <i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                           
                        </h3>
                        <span class="float-right clickable">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                    </div>
                    <div class="card-body">
                        <!--main content-->
                        {!! Form::model($editError, ['url' =>route('error.update',$editError->id ), 'method' => 'put', 'class' => 'form-horizontal','id'=>'commentForm', 'enctype'=>'multipart/form-data','files'=> true]) !!}
                        {{ csrf_field() }}
                        <!-- CSRF Token -->


                            <div id="rootwizard">
                                <ul>
                                    <li class="nav-item"><a href="#tab1" data-toggle="tab" ></a></li>
                                   
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane " id="tab1">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Title *</label>
                                                <div class="col-sm-10">
                                                    <input id="name" name="title" type="text"
                                                           placeholder="Title" class="form-control required"
                                                           value="{!! old('name', $editError->title) !!}"/>

                                                    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group {{ $errors->first('description', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Description *</label>
                                                    <div class="col-sm-10">
                                                        <input id="name" name="description" type="text"
                                                               placeholder="Description" class="form-control required"
                                                               value="{!! old('description',$editError->description) !!}"/>
                                                        {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('attachment', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Attachment *</label>
                                                    <div class="col-sm-10">
                                                        <input id="name" name="attachment" type="file"
                                                               placeholder="Attachment" class="form-control required"
                                                               value="{!! old('attachment',$editError->attachment) !!}"/>
                                                        {!! $errors->first('attachment', '<span class="help-block">:message</span>') !!}
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('video_link', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Video Link *</label>
                                                    <div class="col-sm-10">
                                                        <input id="name" name="video_link" type="text"
                                                               placeholder="Video Link" class="form-control required"
                                                               value="{!! old('video_link',$editError->video_link) !!}"/>
                                                        {!! $errors->first('video_link', '<span class="help-block">:message</span>') !!}
                                                    </div>
                                            </div>
                                        </div>
                                        <button align = 'center' type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="Update Error" id="delButton">Update</button>
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
     <script src="{{ asset('public/assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/pages/edituser.js') }}"></script>
    <script src="{{asset('public/assets/js/pages/datepicker.js') }}"></script>
    
@stop

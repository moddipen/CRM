@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Apply For Leave
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
        
        <h1> {{  _('Apply For Leave')}}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="#">Apply For Leave</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 my-3">
                <div class="card panel-primary">
                    <div class="card-heading">
                        <h3 class="card-title">
                            <i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            Apply For Leave
                        </h3>
                                <span class="float-right clickable">
                                    <i class="fa fa-chevron-up"></i>
                                </span>
                    </div>
                    <div class="card-body">
                        <!--main content-->
                        <form id="commentForm" action="{{route('post-leave')}}"
                              method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div id="rootwizard">
                                <ul>
                                    <li class="nav-item"><a href="#tab1" data-toggle="tab" ></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane " id="tab1">
                                        
                                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Title*</label>
                                                    <div class="col-sm-10">
                                                        <input id="name" name="title" type="text"
                                                               placeholder="Title" class="form-control required"
                                                               value="{!! old('title') !!}"/>

                                                        {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('start_end_date', 'has-error') }}" >
                                             <div class="row">
                                                <label for="From" class="col-sm-2 control-label">
                                                    Date *
                                                </label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="text" readonly name="start_end_date" class="form-control" id="daterange1" />
                                                            {!! $errors->first('start_end_date', '<span class="help-block">:message</span>') !!}
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Type Of Leave *</label>
                                                    <div class="col-sm-10">
                                                        <input type="radio" id="half" name="type" value="0"  class="square" checked/>Half &nbsp;&nbsp;
                                                        <input type="radio" name="type" id="full" value="1" class="square" />Full
                                                    </div>
                                            </div>
                                        </div>
                                        <div id="slot" style="display:block;" class="form-group {{ $errors->first('name', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Slot*</label>
                                                    <div class="col-sm-10">
                                                        <input type="radio" name="slot" value="0"  class="square" checked/>First &nbsp;&nbsp;
                                                        <input type="radio" name="slot" value="1" class="square" />Second
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('reason', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Reason *</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="name" name="reason" type="text"
                                                               placeholder="Reason" class="form-control required"
                                                               value="{!! old('reason') !!}"></textarea>
                                                        {!! $errors->first('reason', '<span class="help-block">:message</span>') !!}
                                                    </div>
                                            </div>
                                        </div>
                                       
                                        <!-- <div class="form-group {{ $errors->first('employee_id', 'has-error') }}">
                                            <div class="row">
                                                <label for="select21" class="col-sm-2 control-label">
                                                    Employee *
                                                </label>
                                                <div class="col-sm-10">
                                                    <select id="select21" name="employee_id" class="form-control select2">
                                                        <option value="">Select Employee</option>
                                                        @foreach($employee as $val){
                                                           
                                                            <option value="{{$val->id}}">{{$val->name}}</option>
                                                        }
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('employee_id', '<span id="select_id" class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div> -->
                                        
                                        <button align = 'center' type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="Apply For Leave" id="delButton">Create</button>
                                    </div>
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
    <script src="{{ asset('public/assets/js/pages/adduser.js') }}"></script>
    <script src="{{asset('public/assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/pages/datepicker.js') }}"></script>
    <script>
        
        $('#daterange1').daterangepicker(
            { minDate: moment().subtract('days', 0)
        });

       // $('input[type=radio][name=type]').change(function() {
       //      alert("sadasd");
       //      if (this.value == '0') {
       //          alert("Half");
       //      }
       //      else if (this.value == '1') {
       //          alert("Full");
       //      }
       //  });
    $('#half').on('ifChecked', function () { $('#slot').css('display','block'); });
    $('#half').on('ifUnchecked', function () { $('#slot').css('display','none'); })



    </script>
@stop

@extends('layouts/default')

{{-- Page title --}}
@section('title')
    User Profile
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('public/assets/css/app.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/jquery-ui.css') }}">
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
        <h1> User Profile</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{route('home')}}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Dashboard
                </a>
            </li>
            <li><a href="javascript:void">User</a></li>
            <li class="active">User Profile</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 my-3">
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
                        <form action="{{route('profile.store')}}"
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
                                        <div class="form-group {{ $errors->first('firstname', 'has-error') }}">
                                            <div class="row">
                                            <label for="first_name" class="col-sm-2 control-label">First Name *</label>
                                            <div class="col-sm-10">
                                                
                                                <input id="name" name="firstname" type="text"
                                                       placeholder="First Name" class="form-control required"
                                                        @if(isset($profile))
                                                         value="{!! old('firstname',$profile->firstname) !!}" @endif />
                                                
                                                {!! $errors->first('firstname', '<span id="name_error" class="help-block">:message</span>') !!}
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('lastname', 'has-error') }}">
                                            <div class="row">
                                            <label for="last_name" class="col-sm-2 control-label">Last Name *</label>
                                            <div class="col-sm-10">
                                               
                                                <input id="lastname" name="lastname" type="text"
                                                       placeholder="Last Name" class="form-control required"
                                                        @if(isset($profile))
                                                        value="{!! old('lastname',$profile->lastname) !!}" @endif />
                                                
                                                {!! $errors->first('lastname', '<span id="lastname_error" class="help-block">:message</span>') !!}
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('address', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">Address *</label>
                                                    <div class="col-sm-10">
                                                       
                                                        <textarea id="address" name="address" type="text"
                                                               placeholder="Address" class="form-control required"
                                                               > @if(isset($profile)){!! old('address',$profile->address) !!} @endif</textarea>
                                                        
                                                        {!! $errors->first('address', '<span id="address_error" class="help-block">:message</span>') !!}
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('phone_number', 'has-error') }}">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">Number *</label>
                                                <div class="col-sm-10">
                                                   
                                                    <input id="phone_number" name="phone_number" placeholder="Number" type="text"
                                                           class="form-control required email"  @if(isset($profile)) value="{!! old('phone_number',$profile->phone_number) !!}"  @endif/>
                                                   
                                                    {!! $errors->first('phone_number', '<span id="number_error" class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('alternate_number', 'has-error') }}">
                                            <div class="row">
                                                <label for="alternate number" class="col-sm-2 control-label">Alternate Number </label>
                                                <div class="col-sm-10">
                                                    
                                                    <input id="alternate_number" name="alternate_number" type="text" placeholder="Alternate Number"
                                                           class="form-control required"  @if(isset($profile)) value="{!! old('alternate_number',$profile->alternate_number) !!}" @endif/>
                                                    
                                                    {!! $errors->first('alternate_number', '<span id="alternate_error" class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('photo', 'has-error') }}">
                                            <div class="row">
                                                <label for="photo" class="col-sm-2 control-label">Photo </label>
                                                <div class="col-sm-10">
                                                    
                                                    <input id="email" name="photo" placeholder="Photo" type="file"
                                                           class="form-control required email"  value="{!! old('photo') !!}" />

                                                    <div>
                                                        @if(isset($profile) && $profile->photo != '')

                                                        <img  id='photo_img_id' src="{{ asset('storage/app/'.$profile->photo) }}" alt="" width="200px" height="200px">

                                                        <button id='photo_id' class="btn btn-primary">Remove</button>
                                                        @endif
                                                    </div>
                                                    <span id='img_success'></span>
                                                    
                                                    {!! $errors->first('photo', '<span id="email_error" class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('dob', 'has-error') }} ">
                                             <div class="row">
                                                <label for="From" class="col-sm-2 control-label">
                                                    Date Of Birth *
                                                </label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            
                                                            <input type="text" readonly name="dob" class="form-control" id="rangepicker4"  @if(isset($profile)) value="{!! old('dob',$profile->dob)   !!}" @endif />
                                                            
                                                        </div>
                                                            
                                                        
                                                        {!! $errors->first('dob', '<span class="help-block">:message</span>') !!}
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('id_proof', 'has-error') }}">
                                            <div class="row">
                                                <label for="photo" class="col-sm-2 control-label">Id Proof </label>
                                                <div class="col-sm-10">
                                                    
                                                    <input id="email" name="id_proof" placeholder="Id Proof" type="file"
                                                           class="form-control required email" value="{!! old('id_proof') !!}" />
                                                    <div>
                                                        @if(isset($profile) && $profile->id_proof != '')
                                                        <img id="img_id" src="{{ asset('storage/app/'.$profile->id_proof) }}" alt="" width="200px" height="200px">

                                                        <button id="proof_id" class="btn btn-primary">Remove</button>
                                                        @endif
                                                    </div>
                                                    <span id="img_Error"></span>
                                                    
                                                    {!! $errors->first('id_proof', '<span id="email_error" class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                         
                                        <button align = 'center' type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="Update Profile" id="createButton">Create</button>
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
    <script src="{{asset('public/assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{asset('public/assets/js/pages/datepicker.js') }}"></script>
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
        $('#lastname').on('keyup',function(){
            $('#lastname_error').hide();
        });

        $('#email').on('keyup',function(){
            $('#email_error').hide();
        });
        $('#address').on('keyup',function(){
            $('#address_error').hide();
        });
        $('#phone_number').on('keyup',function(){
            $('#number_error').hide();
        });
        $('#alternate_number').on('keyup',function(){
            $('#alternate_error').hide();
        });
        $('#select21').on('change',function(){
            $('#select_id').hide();
        });

    </script>

<script type="text/javascript">
    $("#proof_id" ).on('click',function(){
    var r = confirm("Are you sure want to remove?");
    if (r == true) {

        $("#img_id").remove();        
        $.ajax({
                            
            url : 'profileImg/remove',
            type: 'POST',
            data: { id_proof:'idImg'},   
            success: function (data) {
                $('#img_Error').html('<font color="green">'+data+'</font>');

            }
        });
    } else {
        return false;
    }

    
    
}); 
$("#photo_id" ).on('click',function(){
    var r = confirm("Are you sure want to remove?");
    if (r == true) {

        $("#photo_img_id").remove();        
        $.ajax({
                            
            url : 'profileImg/remove',
            type: 'POST',
            data: { photo:'photoImg'},   
            success: function (data) {
                $('#img_success').html('<font color="green">'+data+'</font>');

            }
        });
    } else {
        return false;
    }
});    
    </script>
@stop

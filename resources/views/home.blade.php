@extends('layouts/default')

{{-- Page title --}}
@section('title')
Dashboard
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link href="{{ asset('assets/vendors/fullcalendar/css/fullcalendar.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/pages/calendar_custom.css') }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" media="all"
      href="{{ asset('assets/vendors/bower-jvectormap/css/jquery-jvectormap-1.2.2.css') }}"/>
<link rel="stylesheet" href="{{ asset('public/assets/vendors/animate/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/pages/only_dashboard.css') }}"/>

<meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" type="text/css"
      href="{{ asset('public/assets/vendors/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css') }}">
<!-- <link href="{{ asset('public/assets/vendors/owl_carousel/css/owl.carousel.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('public/assets/vendors/owl_carousel/css/owl.theme.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('public/assets/vendors/owl_carousel/css/owl.transitions.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('public/assets/css/pages/carousel.css') }}" rel="stylesheet" type="text/css" /> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css" rel="stylesheet" />
<style type="text/css">
ul .slide-li { text-align: center !important;}.bx-wrapper{padding: 20px 0px !important; margin-bottom: 0px !important;}
.justify-left-slide{text-align: left !important;}
.img-circle{
    border-radius: 50%;
}
</style>
@stop

{{-- Page content --}}
@section('content')

    <section class="content-header">
    <h1>Welcome to Dashboard</h1>
    <ol class="breadcrumb">
    <li class=" breadcrumb-item active">
    <a href="#">
    <i class="livicon" data-name="home" data-size="16" data-color="#333" data-hovercolor="#333"></i>
    Dashboard
    </a>
    </li>
    </ol>
</section>
<section class="content indexpage">
    <div class="row">
        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
            <!-- Trans label pie charts strats here-->
            <div class="lightbluebg no-radius">
                <div class="card-body squarebox square_boxs cardpaddng">
                    <div class="row">
                        <div class="col-12 float-left nopadmar">
                            <div class="row">
                                <div class="square_box col-6 text-left">
                                    <span><h3>Total <br>Leaves<h3></span>

                                    <div class="number" id="myTargetElement1"></div>
                                </div>
                                <div class="col-6">

                                    <div class=" float-right" >
                                        <h1>{{$leave}}</h1>
                                    </div>
                                </div>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user()->hasanyrole('Employee'))
        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
            <!-- Trans label pie charts strats here-->
            <div class="redbg no-radius">
                <div class="card-body squarebox square_boxs cardpaddng">
                    <div class="row">
                        <div class="col-12 float-left nopadmar">
                            <div class="row">
                                <div class="square_box col-6 float-left">
                                    <span><h3>Leaves Remaining</h3></span>

                                    <div class="number" id="myTargetElement2"></div>
                                </div>
                                <div class="col-6">
                                    <div class=" float-right" >
                                        <h1>{{ $PendingLeaves }}</h1>
                                    </div>
                                </div>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
            <!-- Trans label pie charts strats here-->
            <div class="redbg no-radius">
                <div class="card-body squarebox square_boxs cardpaddng">
                    <div class="row">
                        <div class="col-12 float-left nopadmar">
                            <div class="row">
                                <div class="square_box col-6 float-left">
                                    <span><h3>Approval Remaining</h3></span>

                                    <div class="number" id="myTargetElement2"></div>
                                </div>
                                <div class="col-6">
                                    <div class=" float-right" >
                                        <h1>{{ $remainingLeave }}</h1>
                                    </div>
                                </div>

                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-6 col-xl-4 col-sm-6 col-md-6 margin_10 animated fadeInDownBig">
            <!-- Trans label pie charts strats here-->
            <div class="goldbg no-radius">
                <div class="card-body squarebox square_boxs cardpaddng">
                    <div class="row">
                        <div class="col-12 float-left nopadmar">
                            <div class="row">
                                <div class="square_box col-6 pull-left">
                                    <span><h3>Total<br> Tickets</h3></span>

                                    <div class="number" id="myTargetElement3"></div>
                                </div>
                             <div class="col-6">
                                <div class=" float-right" >
                                    <h1>{{ $ticket }}</h1>
                                </div>
                             </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 margin_10 animated fadeInRightBig"> -->
            <!-- Trans label pie charts strats here-->
            <!-- <div class="palebluecolorbg no-radius">
                <div class="card-body squarebox square_boxs cardpaddng">
                    <div class="row">
                        <div class="col-12 float-left nopadmar">
                            <div class="row">
                                <div class="square_box col-6 pull-left">
                                    <span>Registered Users</span>

                                    <div class="number" id="myTargetElement4"></div>
                                </div>
                               <div class="col-6">
                                   <i class="livicon float-right" data-name="users" data-l="true" data-c="#fff"
                                      data-hc="#fff" data-s="70"></i>
                               </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <small class="stat-label">Last Week</small>
                                    <h4 id="myTargetElement4.1"></h4>
                                </div>
                                <div class="col-6 text-right">
                                    <small class="stat-label">Last Month</small>
                                    <h4 id="myTargetElement4.2"></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        <!-- </div> -->
    </div>
    <!--/row-->
    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-8 ">
            <div class="card panel-border">
                <div class="card-heading">
                    <h3 class="card-title">
                        <i class="livicon" data-name="dashboard" data-size="20" data-loop="true" data-c="#F89A14"
                           data-hc="#F89A14"></i>
                        Ticket
                        <small>- Ticket </small>
                    </h3>
                </div>
                <div class="card-body">
                    <div id="realtimechart">
                        <div class="card panel-success ">
                            <div class="card-heading">
                                <h4 class="card-title pull-left add_remove_title"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                    Ticket List
                                </h4>
                                @if(Auth::user()->hasAnyPermission(['create-ticket']))
                                <div class="pull-right">                    
                                    <a href="{{route('ticket.create')}}" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="Add New Permission" id="delButton"><i class="fa fa-plus"></i>Add New</a>
                                </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="table-responsive-lg table-responsive-sm table-responsive-md">
                                <table class="table table-bordered width100" id="ticket-table">
                                    <thead>
                                        <tr class="filters">
                                            
                                            <th>Ticket Number</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12  ">
                        <div class="card panel-border">
                            <div class="card-heading">
                                <h3 class="card-title">
                                    <i class="livicon" data-name="calendar" data-size="20" data-loop="true" data-c="#F89A14"
                                       data-hc="#F89A14"></i>
                                        Upcoming Birthdays
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div>
                                    @if(count($bday) == 0)
                                    <div class="item">
                                        <div class="row">
                                            <div class="col-md-3">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                            <h4> No Upcoming Birthday</h4>
                                    </div>
                                    @else
                              
                                <ul class="bxslider1">
                                    @foreach($bday as $val)
                                   <li>
                                       <div class="row">
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-2">
                                                @if($val->photo == '')
                                                <img style="width:50px; " class="img-circle" src="{{asset('storage/app/profile/no_avatar.jpg')}}">   
                                                @else
                                                <img style="width:50px; " class="img-circle" src="{{asset('storage/app/'.$val->photo)}}">
                                                @endif
                                            </div>
                                            <div class="col-md-8 justify-left-slide" >
                                                <h3><b> {{$val -> firstname}} {{$val->lastname}}</b></h3>
                                                Date Of Birth : {{ date('d-m-y',strtotime($val->dob))}}
                                            </div>
                                        </div>
                                    
                                    </li> 
                                     @endforeach                                     
                                </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-12" style="margin-top:8px;">
                        <div class="card panel-border">
                                <div class="card-heading">
                                    <h3 class="card-title">
                                        <i class="livicon" data-name="calendar" data-size="20" data-loop="true" data-c="#F89A14"
                                           data-hc="#F89A14"></i>
                                        Upcoming Holidays
                                        
                                    </h3>
                                </div>
                            <div class="panel-body">
                                                                  
                                <ul class="bxslider">
                                @foreach($holiday as $val)
                                   <li class="slide-li">
                                        <b><h3> {{$val->title}} </h3></b>
                                        Date : {{ date('d-F-Y',strtotime($val->date)) }}   
                                    
                                    </li> 
                                @endforeach                                     
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top:8px;">
                        <div class="card panel-border">
                                <div class="card-heading">
                                    <h3 class="card-title">
                                        <i class="livicon" data-name="calendar" data-size="20" data-loop="true" data-c="#F89A14"
                                           data-hc="#F89A14"></i>
                                        Upcoming Leaves
                                        
                                    </h3>
                                </div>
                            <div class="panel-body">
                                <ul class="bxslider">
                                    @foreach($leaveTaken as $val)
                                    <li class="slide-li">
                                        <b><h3> {{$val->users->name}} </h3></b>
                                        {{ date('d-F-Y',strtotime($val->from)) }} 
                                        To  {{ date('d-F-Y',strtotime($val->to)) }}   
                                    </li> 
                                    @endforeach                                     
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div> 
    </div>
</div>
    <div class="clearfix"></div>
   
    <div class="row">
       <!--  <div class="col-md-4 col-sm-12 col-lg-4 col-12 my-3">
            <div class="card panel-danger">
                <div class="card-heading border-light bg-danger bdr">
                    <h4 class="card-title">
                        <i class="livicon" data-name="mail" data-size="18" data-color="white" data-hc="white"
                           data-l="true"></i>
                        Quick Mail
                    </h4>
                </div>
                <div class="card-body">
                    <div class="compose row">
                        <label class="col-sm-1 col-md-3 d-none d-sm-block" style="padding: 0">To:</label>
                        <input type="text" class="col-sm-11 col-md-9 col-12" placeholder="name@email.com "
                               tabindex="1"/>

                        <div class="clear"></div>
                        <label class="col-sm-1 col-md-3 hidden-xs" style="padding: 0">Subject:</label>
                        <input type="text" class="col-sm-11 col-md-9 col-12" tabindex="1" placeholder="Subject"/>

                        <div class="clear"></div>
                        <div class="box-body">
                            <form>
                                    <textarea class="textarea textarea_home form-control"
                                              placeholder="Write mail content here" cols="6" rows="6"></textarea>
                            </form>
                        </div>
                        <div class="ml-auto my-2">
                            <a href="#" class="btn btn-danger clr">Send</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-lg-8 col-md-8 col-sm-12 my-3">
            <div class="card panel-border">

                <div class="card-heading">
                    <h4 class="card-title pull-left margin-top-10">
                        <i class="livicon" data-name="map" data-size="16" data-loop="true" data-c="#515763"
                           data-hc="#515763"></i>
                        Visitors Map
                    </h4>

                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <i class="livicon" data-name="settings" data-size="16" data-loop="true" data-c="#515763"
                               data-hc="#515763"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a class="panel-collapse collapses" href="#">
                                    <i class="fa fa-angle-up"></i>
                                    <span>Collapse</span>
                                </a>
                            </li>
                            <li>
                                <a class="panel-refresh" href="#">
                                    <i class="fa fa-refresh"></i>
                                    <span>Refresh</span>
                                </a>
                            </li>
                            <li>
                                <a class="panel-config" href="#panel-config" data-toggle="modal">
                                    <i class="fa fa-wrench"></i>
                                    <span>Configurations</span>
                                </a>
                            </li>
                            <li>
                                <a class="panel-expand" href="#">
                                    <i class="fa fa-expand"></i>
                                    <span>Fullscreen</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="card-body nopadmar">
                    <div id="world-map-markers" style="width:100%; height:300px;"></div>
                </div>
            </div>
        </div> -->
    </div>
</section>
<div class="modal fade" id="editConfirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alert</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <p>You are already editing a row, you must save or cancel that row before edit/delete a new row</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

<script src="{{ asset('public/assets/vendors/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- EASY PIE CHART JS -->
<script src="{{ asset('public/assets/js/pages/dashboard.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('public/assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('public/assets/vendors/datatables/js/dataTables.bootstrap4.js') }}" ></script>
<!-- <script src="{{ asset('public/assets/vendors/owl_carousel/js/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/assets/js/pages/carousel.js') }}"></script> -->

    

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteLabel">Delete Ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this Ticket? This operation is irreversible.
                </div>
                <input  type="hidden" id="confirm_id" name="delete_id" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button onclick="deleteComment()" type="button" class="btn btn-danger Remove_square">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
<div class="modal fade stretchRight" id="modal-11" role="dialog" aria-labelledby="modalLabelsidefall2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title" id="modalLabelsidefall2">Ticket</h4>
                </div>
                <div class="modal-body">
                    <h2>Reason For Denying The Ticket</h2>
                      <form class="form-horizontal" id="ticket" action="{{route('post-ticket-denied')}}" method="post">
                        @csrf
                        <div class="form-group " >
                          <label class="control-label col-sm-2" for="email">Comment:</label>
                          <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="email" placeholder="Enter Comment" name="comment"></textarea>
                            
                            <input type="hidden" id="ticket_id" name='id' />
                          </div>
                        </div>    
                        <div class="form-group">        
                          <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit"  class="btn btn-success">Submit</button>
                          </div>
                        </div>
                      </form>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-warning" data-dismiss="modal">Close me!</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js"></script>
<script>


$(function () {

$('.bxslider').bxSlider({
    'pager':false,
    // 'speed':1000,
    'auto':false
});
$('.bxslider1').bxSlider({
    'pager':false,
    // 'speed':2500,
    'auto':false
});


$.fn.dataTable.ext.errMode = 'throw';

    $('#ticket-table').DataTable({

            processing: true,
            serverSide: true,
            paging: false,
            searching: false,
            ajax: '{!! route('get.ticket.dashboard') !!}',

            columns: [               
                { data: 'ticket_number', name: 'ticket_number' },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false } 
            ]
        });


    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});

    // var subm = "";
    // $('input[type="submit"]').click(function(e) {
    // subm = e.target.id;
    // });

    function confirmTicket(id){

        $('#ticket_id').val(id);
       
    }

    function confirmDelete(id) {
        
    $("#delete_confirm").modal("show");
    $("#confirm_id").val(id);
    
    }
function deleteComment(){
    var id = $("#confirm_id").val();
    
    $("#form"+id).submit();
}

</script>
@stop
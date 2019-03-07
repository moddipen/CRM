@extends('layouts/default')

{{-- Page title --}}
@section('title')
Employee Leave List
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/vendors/datatables/css/dataTables.bootstrap4.css') }}" />
<link href="{{ asset('public/assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Employee Leave</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('home') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="{{route('employee.leave.index')}}">Employee Leave</a></li>
       
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="col-12">
        <div class="card panel-success ">
            <div class="card-heading">
                <h4 class="card-title pull-left add_remove_title"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Employee Leave
                </h4>
                @if(Auth::user()->hasAnyPermission(['create-employee-leave']))
                <div class="pull-right">                    
                    <a href="{{route('employee.leave.create')}}" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="Add New Employee Leave" id="delButton"><i class="fa fa-plus"></i>Add New</a>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive-lg table-responsive-sm table-responsive-md">
                <table class="table table-bordered width100" id="users-table">
                    <thead>
                        
                        <tr class="filters">
                            <th>User</th>
                            <th>Title</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Type of Leave</th>
                            <th>Total Days</th>
                            <th>Reason</th>
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
    </div><!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('public/assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('public/assets/vendors/datatables/js/dataTables.bootstrap4.js') }}" ></script>

<script>
    
</script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteLabel">Delete Employee Leave</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this Employee Leave? This operation is irreversible.
                </div>
                <input type="hidden" id="confirm_id" name="delete_id"   />
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
                    <h4 class="modal-title" id="modalLabelsidefall2">Employee Leave</h4>
                </div>
                <div class="modal-body">
                    <h2>Reason For Denying The Employee Leave</h2>
                      <form class="form-horizontal" id="ticket" action="{{route('post-employeeleave-denied')}}" method="post">
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
    <!-- /.modal-dialog -->
<script>
$(function () {
$.fn.dataTable.ext.errMode = 'throw';

     $('#users-table').DataTable({

            processing: true,

            serverSide: true,

            sort: false,

            ajax: '{!! route('get.employee.leave') !!}',

            columns: [               
                { data: 'name', name: 'name' },
                { data: 'title', name: 'title' },
                { data: 'from', name: 'from' },
                { data: 'to', name: 'to' },
                { data: 'type', name: 'type' },
                { data: 'total_days', name: 'total_days' },
                { data: 'reason', name: 'reason' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]

        });

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});

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

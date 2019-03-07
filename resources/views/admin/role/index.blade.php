@extends('layouts/default')

{{-- Page title --}}
@section('title')
Role List
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
    <h1>Roles</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('home') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="{{route('role')}}">Role</a></li>
       
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="col-12">
        <div class="card panel-success ">
            <div class="card-heading">
                <h4 class="card-title pull-left add_remove_title"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Role List
                </h4>
                @if(Auth::user()->hasAnyPermission(['create-role']))
                <div class="pull-right">	                
	                <a href="{{route('role.create')}}" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="left" data-original-title="Add New Role" id="delButton"><i class="fa fa-plus"></i>Add New</a>
	            </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive-lg table-responsive-sm table-responsive-md">
                <table class="table table-bordered width100" id="permission-table">
                    <thead>
                        <tr class="filters">
	                        <th>Name</th>
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
                    <h4 class="modal-title" id="deleteLabel">Delete Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this Role? This operation is irreversible.
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
    <!-- /.modal-dialog -->
<script>
$(function () {
$.fn.dataTable.ext.errMode = 'throw';

	$('#permission-table').DataTable({

            processing: true,

            serverSide: true,

            ajax: '{!! route('get.role') !!}',

            columns: [               
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
                
            ]

        });


	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
// var $url_path = '{!! url('/') !!}';
// $('#delete_confirm').on('show.bs.modal', function (event) {
//     var button = $(event.relatedTarget)
//     var $recipient = button.data('id');
//     var modal = $(this)
//     modal.find('.modal-footer a').prop("href",$url_path+"/admin/role/"+$recipient+"/delete");
// })

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

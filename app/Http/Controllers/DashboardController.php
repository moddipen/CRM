<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Ticket;
use Mail;
use Yajra\Datatables\Datatables;
use App\Mail\TicketAcknowledgement;

class DashboardController extends Controller
{
   	public function getTicketData()
    {

    	if(Auth::user()->hasanyrole(['Employee'])){
            $tickets = Ticket::where('employee_id',Auth::user()->id)->orderBy('created_at','desc')->get();    
        }
        else{
            $tickets = Ticket::orderBy('created_at','desc')->get();
        }
    	return Datatables::of($tickets)->
                editColumn('status', function($ticket) {

                    if($ticket->status == 0){
                       $ticket->status = '<span class="badge badge-pill badge-info">Pending</span>'; 
                    }
                    else if($ticket->status == 1){
                        $ticket->status = '<span class="badge badge-pill badge-success">Approved</span>';
                    }
                    else{
                        $ticket->status = '<span class="badge badge-pill badge-danger">Denied</span>';
                    }

                    return $ticket->status;

                })->
                
        		addColumn('action', function ($ticket) {
                    $html = "";
                    if(Auth::user()->hasAnyPermission(['approve-ticket']) && $ticket->status != 1){
                        $html .= '<form id="form'.$ticket->id.'" action="'.route('ticket.delete',$ticket->id).'"  method="post"><a href="'.route('ticket.approve',$this->encrypt($ticket->id)).'" class = "btn btn-primary" ><i class="fa fa-check"></i></a>&nbsp;';
                    }
                    else{
                        $html .= '<form id="form'.$ticket->id.'" action="'.route('ticket.delete',$ticket->id).'"  method="post">';
                    }
                    if(Auth::user()->hasAnyPermission(['denied-ticket']) && $ticket->status != 2){
                        $html .= '<a href="'.route('ticket.denied',$this->encrypt($ticket->id)).'" onclick="confirmTicket('.$ticket->id.')"  class = "btn btn-danger" data-toggle="modal" data-target="#modal-11"><i class="fa fa-close"></i></a>&nbsp;';
                    }
                    else{
                        $html .= '<form id="form'.$ticket->id.'" action="'.route('ticket.delete',$ticket->id).'"  method="post">';
                    }
                    if(Auth::user()->hasAnyPermission(['show-ticket'])){
                        $html .= '
                        <a href="'.route('ticket.view',$this->encrypt($ticket->id)).'" class = "btn btn-info"   ><i class="fa fa-eye"></i></a>&nbsp;';
                    }
                    else{
                        $html .= '<form id="form'.$ticket->id.'" action="'.route('ticket.delete',$ticket->id).'"  method="post">';
                    }

                    if(Auth::user()->hasAnyPermission(['edit-ticket'])){
                        $html .= '<a href="'.route('ticket.edit',$this->encrypt($ticket->id)).'" class = "btn btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                    }
                    else{
                         $html .= '';

                    }
                    if(Auth::user()->hasAnyPermission(['delete-ticket'])){
                        $html .= ''.method_field("delete").csrf_field().' 
                        <button class="btn btn-danger" onclick="confirmDelete('.$ticket->id.')" type="button"><i class="fa fa-trash"> </i></button>
                            </form><script>
                        } </script>';
                    }
                    else{
                        $html .= '</form>';
                    }
                    return $html;
            })

            ->rawColumns(['status','action'])
            ->make(true);

    }
}

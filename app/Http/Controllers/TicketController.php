<?php

namespace App\Http\Controllers;

use App\Mail\Ticket as TicketEmail;
use App\Ticket;
use App\User;
use Redirect;
use Mail;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use App\Mail\TicketAcknowledgement;

class TicketController extends Controller
{


    public function index()
    {

    	return view('admin.ticket.index');
    }	

    public function getData()
    {
        if(Auth::user()->hasanyrole(['Employee'])){
            $tickets = Ticket::where('employee_id',Auth::user()->id)->get();    
        }
        else{
            $tickets = Ticket::orderBy('created_at','DESC')->get();
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
                    if(Auth::user()->hasAnyPermission(['approve-ticket']) && $ticket->status != 1 ){
                        $html .= '<form id="form'.$ticket->id.'" action="'.route('ticket.delete',$ticket->id).'"  method="post"><a href="'.route('ticket.approve',$this->encrypt($ticket->id)).'" class = "btn btn-primary" ><i class="fa fa-check"></i></a>';
                    }
                    else{
                        $html .= '<form id="form'.$ticket->id.'" action="'.route('ticket.delete',$ticket->id).'"  method="post">';
                    }
                    if(Auth::user()->hasAnyPermission(['denied-ticket']) && $ticket->status != 2){
                        $html .= '<a href="'.route('ticket.denied',$this->encrypt($ticket->id)).'" onclick="confirmTicket('.$ticket->id.')"  class = "btn btn-danger" data-toggle="modal" data-target="#modal-11"><i class="fa fa-close"></i></a>';
                    }
                    else{
                        $html .= '<form id="form'.$ticket->id.'" action="'.route('ticket.delete',$ticket->id).'"  method="post">';
                    }
                    if(Auth::user()->hasAnyPermission(['show-ticket'])){
                        $html .= '
                        <a href="'.route('ticket.view',$this->encrypt($ticket->id)).'" class = "btn btn-info"   ><i class="fa fa-eye"></i></a>';
                    }
                    else{
                        $html .= '<form id="form'.$ticket->id.'" action="'.route('ticket.delete',$ticket->id).'"  method="post">';
                    }

                    if(Auth::user()->hasAnyPermission(['edit-ticket'])){
                        $html .= '<a href="'.route('ticket.edit',$this->encrypt($ticket->id)).'" class = "btn btn-primary"><i class="fa fa-edit"></i></a>';
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

    public function create()
    {	
    	$ticket_number = $this->generateRandomString();
    	return view('admin.ticket.create',compact('ticket_number'));

    }
    public function store(Request $request)
    {   
        // $this->printResult($request->all());
        $request->validate([
            'ticket_number' => 'unique:tickets',
            'title' => 'required|max:30',
            'description' => 'required',
        ]);

        $ticketNumber = $request->ticket_number;
    	$storeTicket = new Ticket();
    	$storeTicket->employee_id = Auth::user()->id;
    	$storeTicket->ticket_number = $ticketNumber;
    	$storeTicket->title = $request->title;
    	$storeTicket->description = $request->description;
    	
    	$storeTicket->save();
        $admin = User::role('Admin')->get();
        $employee = User::where('id',Auth::user()->id)->first();
        $data = [

                'ticket_number' => $ticketNumber,
                'title' => $request->title,
                'description' => $request->description,
                'email' => $employee->email,
                'name' => $employee->name,
            ];

        foreach ($admin as $val) {
            $data['adminName'] = $val->name; 
            $receiver = $val->email;
            Mail::to($receiver)->send(new TicketEmail($data));    
        }

    	return Redirect::to('admin/ticket')
            ->with('success', 'The Ticket has been Added Successfully.');
    }

    public function edit($id)
    {
        $id = $this->decrypt($id);
        $editTicket = Ticket::find($id);
    	return view('admin.ticket.edit',compact('editTicket'));
    }
    public function update($id,Request $request)
    {
        $request->validate([

            'title' => 'required|max:30',
            'description' => 'required',
        ]);
    	$updateTicket = Ticket::find($id);
    	$updateTicket->employee_id = Auth::user()->id;
    	$updateTicket->title = $request->title;
    	$updateTicket->description = $request->description;
    	$updateTicket->save();


    	return Redirect::to('admin/ticket')
            ->with('success', 'The Ticket has been Added Successfully.');
    }

    public function delete($id)
    {
        $deleteTicket = Ticket::find($id);
        $deleteTicket->delete();
        return Redirect::back()
            ->with('success', 'The Ticket has been Deleted Successfully.');
    }

    public function showTicket($id)
    {
        $id = $this->decrypt($id);
        $showTicket = Ticket::find($id);
       
        return view('admin.ticket.show',compact('showTicket'));
    }

    public function approveMail($id)
    {
        $id = $this->decrypt($id);
        $ticket = Ticket::find($id);

        if($ticket->status == 1)
        {
            return view('common')->with('error','The Ticket has been Already Approved');
        }
        
        else{
            $ticket->status = 1;
            $ticket->save();
            $user = User::find($ticket->employee_id);
            $data = [
                    'name' => 'Admin',
                    'title' => $ticket->title,
                    'ticket_number' => $ticket->ticket_number,
                    'description' => $ticket->description,
                    'message' => 'Ticket Approved',
                    'comment' =>     '',
                ];
            $receiver = $user->email;
            
            Mail::to($receiver)->send(new TicketAcknowledgement($data));
            return Redirect::back()->with('success','The Ticket has been  Approved');

        }
    }

    public function deniedMail($id)
    {
        $id = $this->decrypt($id);
        $ticket = Ticket::find($id);
        if($ticket->status == 2){
            return view('common')
            ->with('error', 'Ticket has been already Denied.'); 
        }
        
        else{
            return view('admin.ticket.index')->with('data',$ticket);
        }
    }
    public function postDenied(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:30',
            
        ]);
        $ticket = Ticket::find($request->id);
        $ticket->comment = $request->comment;
        $ticket->status = 2;
        $ticket->save();
        $user = User::find($ticket->employee_id);
        $data = [
            'title' => $ticket->title,
            'ticket_number' => $ticket->ticket_number,
            'description' => $ticket->description,
            'name' => 'Admin',
            'message' => ' Reason For Denying the Ticket is described below',
            'comment' => $request->comment

        ];
        $receiver = $user->email;
        Mail::to($receiver)->send(new TicketAcknowledgement($data));
        return Redirect::back()
            ->with('success', 'Ticket Denied Successfully.');
    }



}



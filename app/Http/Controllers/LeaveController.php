<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralLeave;
use Redirect,Auth;
use App\User;
use Mail;
use App\Mail\GeneralLeave as LeaveMail;
use Yajra\Datatables\Datatables;
use PDF;

class LeaveController extends Controller
{ 

    /*
      This function is created at 10th Jan and used to view the index page of leave 
    */

    public function index()
    {
      return view('admin.leave.index');
    }

    /*
      This function is created at 10th Jan and used to get the data  of general leave 
    */

    public function getData()
    {
      $leave = new GeneralLeave;
      $leaves = GeneralLeave::all();
        
        if (Auth::user()->hasAnyPermission(['edit-general-leave']) && Auth::user()->hasAnyPermission(['delete-general-leave'])) {
          return Datatables::of($leaves) ->addColumn('action', function ($leave) {   
                $html = "";
               
                if(Auth::user()->hasAnyPermission(['edit-general-leave'])){
                    $html .= '<form id="form'.$leave->id.'" action="'.route('general.leave.delete',$leave->id).'"  method="post">
                        <a href="'.route('general.leave.edit',$this->encrypt($leave->id)).'" class = "btn btn-primary" ><i class="fa fa-edit"></i></a>';
                }
                else{
                    $html .= '<form id="form'.$leave->id.'" action="'.route('user.delete',$leave->id).'"  method="post">';
                }
                if(Auth::user()->hasAnyPermission(['delete-general-leave'])){
                    $html .= ''.method_field("delete").csrf_field().' 
                    <button class="btn btn-danger" onclick="confirmDelete('.$leave->id.')" type="button"><i class="fa fa-trash"></i></button>
                    </form><script> </script>';
                }
                else{
                    $html .= '</form>';
                }
                return  $html;
                     
            })->make(true);
        } else {
          return Datatables::of($leaves) ->addColumn('action', function ($leave) {   
                $html = "";
               
                if(Auth::user()->hasAnyPermission(['edit-general-leave'])){
                    $html .= '<form id="form'.$leave->id.'" action="'.route('general.leave.delete',$leave->id).'"  method="post">
                        <a href="'.route('general.leave.edit',$this->encrypt($leave->id)).'" class = "btn btn-primary" ><i class="fa fa-edit"></i></a>';
                }
                else{
                    $html .= '<form id="form'.$leave->id.'" action="'.route('user.delete',$leave->id).'"  method="post">';
                }
                if(Auth::user()->hasAnyPermission(['delete-general-leave'])){
                    $html .= ''.method_field("delete").csrf_field().' 
                    <button class="btn btn-danger" onclick="confirmDelete('.$leave->id.')" type="button"><i class="fa fa-trash"></i></button>
                    </form><script> </script>';
                }
                else{
                    $html .= '</form>';
                }
                return  $html;
                     
            })->removeColumn('action')
            ->make(true);
        }

        
    }

    /*
      This function is created at 10th Jan and used to show create page of leave 
    */

    public function create()
    {
      return view('admin.leave.create');
    }

    /*
      This function is created at 10th Jan and used to store data  of general leave 
    */

    public function store(Request $request)
    {
      $validator = $request->validate([
            'title' => 'required|max:30',
            'date' => 'required',
            
            ]);

      $generalLeave = new GeneralLeave;
      $generalLeave->title = $request->title;
      $generalLeave->date = date('Y-m-d',strtotime($request->date));
      $generalLeave->save();
      return Redirect::to('admin/general/leaves')
            ->with('success', 'General Leave has been Added Successfully.');
    }

    /*
      This function is created at 10th Jan and used to get edit details  of general leave 
    */

    public function edit($id)
    {
      $id = $this->decrypt($id);
      $editLeave = GeneralLeave::find($id);
      
       $editLeave->date = date('m/d/Y',strtotime($editLeave->date));
      if($editLeave){
        return view('admin.leave.edit',compact('editLeave'));       
          
      }
      else{
        return abort(404);
      }
      
    }

    /*
      This function is created at 10th Jan and used to update the data of general leave 
    */

    public function update($id,Request $request)
    {
      // echo "<pre>";
      // print_r($request->all());
      // exit();

      $validator = $request->validate([
            'title' => 'required|max:30',
            'date' => 'required',
           
            
            ]);
       
      $updateLeave = GeneralLeave::find($request->id);
      $updateLeave->title = $request->title;
      $updateLeave->date = date('Y-m-d',strtotime($request->date));
      
      $updateLeave->save();
      return Redirect::to('admin/general/leaves')
            ->with('success', 'General Leave has been Updated Successfully.');
    }

    /*
      This function is created at 10th Jan and used to delete the data  of general leave 
    */

    public function delete($id)
    {
      $deleteLeave = GeneralLeave::find($id);
      $deleteLeave->delete();
      return Redirect::to('admin/general/leaves')
            ->with('success', 'General Leave has been Deleted Successfully.');
    } 

    /*
      This function is created at 10th Jan and used to send  the  general leave to all  
    */

    public function sendLeave()
    {
        $generalLeave = GeneralLeave::all();
        $pdf = PDF::loadView('admin.leave.generalLeavepdf', compact('generalLeave'));
        $pdf->save(storage_path('app/Leaves/leave.pdf'));
        $employee = User::all();
        $year = date('Y');
        foreach ($employee as $key => $value) {
          $email = $value->email;
          // Mail::to($email)->send(new LeaveMail());
          Mail::send(['html'=>'admin.leave.generalLeavepdfblank'],[],function($message) use ($email,$pdf,$year) {
            $message->to($email);
            $message->subject('Leave-'.$year);
            $message->setBody('', 'text/html');
            $message->attach(storage_path('app/Leaves/leave.pdf'),['as'=>'Leave-'.$year.'.pdf','mime'=>'application/pdf']);
          });
        }
        return Redirect::to('admin/general/leaves')
            ->with('success', 'General Leave Sent Successfully.');
    }

    public function showGeneralLeave($id)
    {
        $id = $this->decrypt($id);
        $showLeave = GeneralLeave::find($id);
       
        return view('admin.leave.show',compact('showLeave'));
    }
} 

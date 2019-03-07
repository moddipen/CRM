<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeLeave;
use App\User;
use Yajra\Datatables\Datatables;
use App\Mail\ApplyLeave;
use App\Mail\Acknowledgement;
class EmployeeLeaveController extends Controller
{   
    /*
        This function is used to view the index page of employee leave
    */

    public function index()
    {
        return view('admin.employeeLeave.index');
    }

    /*
        This function is used to get the data of employee leave
    */

    public function getData()
    {
        // $employeeLeave = new EmployeeLeave;
        if(Auth::user()->hasanyrole('Employee')){
            $employeeleaves = EmployeeLeave::with('users')->where('employee_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        }
        else{
            $employeeleaves = EmployeeLeave::with('users')->orderBy('created_at','desc')->get();   
        }
        return Datatables::of($employeeleaves)->
                editColumn('type', function($employeeLeave) {
                    if($employeeLeave->type == 1){
                        $leaveType = 'Full';
                    }
                    else if($employeeLeave->type == 0 && $employeeLeave->slot == 0){
                        $leaveType = 'Half-First';

                    }
                    else{
                        $leaveType = 'Half-Second';
                    }
                    return $leaveType;
                    
                })->
                editColumn('status', function($employeeLeave) {
                    if ($employeeLeave->status == 0) {
                        $employeeLeave->status = '<span class="badge badge-pill badge-success">Approved</span>' ;
                    } else if ($employeeLeave->status == 1) {
                        $employeeLeave->status = '<span class="badge badge-pill badge-danger">Denied</span>';
                    } else {
                        $employeeLeave->status = '<span class="badge badge-pill badge-info">Pending</span>';
                    }
                    return $employeeLeave->status;
                })->
                editColumn('name',function($employeeLeave){
                    return $employeeLeave->users['name'];
                })->
                addColumn('action', function ($employeeLeave) {
                $html = "";

                if(Auth::user()->hasAnyPermission(['approve-employee-leave']) && ($employeeLeave->status == 1 || $employeeLeave->status == 2)){
                        $html .= '<form id="form'.$employeeLeave->id.'" action="'.route('employee.leave.delete',$employeeLeave->id).'"  method="post"><a href="'.route('employeeLeave.approve',$this->encrypt($employeeLeave->id)).'" class = "btn btn-primary" ><i class="fa fa-check"></i></a>';
                }
                else{
                    $html .= '<form id="form'.$employeeLeave->id.'" action="'.route('employee.leave.delete',$employeeLeave->id).'"  method="post">';
                }
                if(Auth::user()->hasAnyPermission(['denied-employee-leave']) && ($employeeLeave->status == 2 || $employeeLeave->status == 0)){
                    $html .= '<a href="'.route('employeeLeave.denied',$this->encrypt($employeeLeave->id)).'" onclick="confirmTicket('.$employeeLeave->id.')"  class = "btn btn-danger" data-toggle="modal" data-target="#modal-11"><i class="fa fa-close"></i></a>';
                }
                else{
                    $html .= '<form id="form'.$employeeLeave->id.'" action="'.route('employee.leave.delete',$employeeLeave->id).'"  method="post">';
                }
                if(Auth::user()->hasAnyPermission(['show-employee-leave'])){
                    $html .= '<a href="'.route('employee.leave.view',$this->encrypt($employeeLeave->id)).'" class = "btn btn-info" ><i class="fa fa-eye"></i></a>';
                }

                else{
                    $html .= '<form id="form'.$employeeLeave->id.'" action="'.route('employee.leave.delete',$employeeLeave->id).'"  method="post">';
                }

                if(Auth::user()->hasAnyPermission(['edit-employee-leave'])){
                    $html .= '<a href="'.route('employee.leave.edit',$this->encrypt($employeeLeave->id)).'" class = "btn btn-primary" ><i class="fa fa-edit"></i></a>';
                }

                else{
                    $html .= '';
                }
                
                if(Auth::user()->hasAnyPermission(['delete-employee-leave'])){
                    $html .= ''.method_field("delete").csrf_field().' 
                    <button class="btn btn-danger" onclick="confirmDelete('.$employeeLeave->id.')" type="button"><i class="fa fa-trash"> </i></button>
                        </form><script>
                        } </script>';
                }
                else{
                    $html .= '</form>';
                }    
                return  $html;
                     
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    /*
        This function is used to create new employee leave
    */

    public function create()
    {
        $employee = User::role('Employee')->get();
        return view('admin.employeeLeave.create',compact('employee'));
    }

    /*
        This function is used to store the data of employee leave
    */

    public function store(Request $request)
    {
        
        $validator = $request->validate([
            'title' => 'required|max:30',
            'start_end_date' => 'required',
            'reason' => 'required',
            'employee_id' => 'required',
            ]);

        $date = explode('-',$request->start_end_date);
        $storeEmployeeLeave = new EmployeeLeave;
        $storeEmployeeLeave->employee_id = $request->employee_id;    
        $storeEmployeeLeave->title = $request->title;
        $storeEmployeeLeave->from = date('Y-m-d',strtotime($date[0]));
        $storeEmployeeLeave->to = date('Y-m-d',strtotime($date[1]));
        $storeEmployeeLeave->type = $request->type;
        $date1=date_create($date[0]);
        $date2=date_create($date[1]);
        $diff=date_diff($date1,$date2);
        $total_days = $diff->format("%a");   
        
        if ($request->type == "1" && $total_days == 0) {
            $storeEmployeeLeave->total_days = 1;
        } else if ($request->type == "0" && $total_days == 0) {
            $storeEmployeeLeave->total_days = 0.5;
        } else if ($request->type == "0" && $total_days > 0) {
            $count = ($total_days * 0.5);
            $storeEmployeeLeave->total_days = $count;
        } else {
            $storeEmployeeLeave->total_days = $total_days;
        }

        $storeEmployeeLeave->reason = $request->reason;
        $storeEmployeeLeave->status = 2;

        // echo '<pre>';
        // print_r($storeEmployeeLeave->total_days);
        // exit();
        
        $storeEmployeeLeave->save();
        // $admin = User::role('Admin')->get();
        // $employee = User::where('id',Auth::user()->id)->first();
        // $data = array();
        // $data['title'] = $request->title;
        // $data['from'] = date('Y-m-d',strtotime($date[0]));
        // $data['to'] = date('Y-m-d',strtotime($date[1]));
        // $data['total_days'] = $storeEmployeeLeave->total_days;
        // $data['reason'] = $request->reason;
        // $data['name'] = $employee->name;
        // $data['id'] = $employee->id;

        // $email = $employee->email;

        // foreach($admin as $val){
        //     $data['adminName'] = $val->name;
        //     $receiver = $val->email;
        //     /*Mail::to($receiver)->send(new ApplyLeave($data));*/
        //     // Mail::send(['html' => 'emails.sendLeaveToAdmin'], array('data'=>$data), function ($message) use ($email,$val) {
        //     //         $message->to($val->email);
        //     //         $message->setBody('', 'text/html');
        //     //         $message->from($email,'Test');
        //     //         $message->subject('Leave Details');
        //     //     });
        // }

        return Redirect::to('admin/employee/leaves')
            ->with('success', 'Employee Leave has been Added Successfully.');  
    }

    /*
        This function is used to get the edit details of employee leave
    */

    public function edit($id)
    {
        $id = $this->decrypt($id);
        $employee = User::all();
        $editEmployeeLeave = EmployeeLeave::find($id);
        $array = array($editEmployeeLeave->from,$editEmployeeLeave->to);
        $editEmployeeLeave->start_end_date = implode('-', $array);
        return view('admin.employeeLeave.edit',compact('editEmployeeLeave','employee'));
    }

    /*
        This function is used to update details of employee leave
    */

    public function update(Request $request)
    {

        $validator = $request->validate([
            'title' => 'required|max:30',
            'start_end_date' => 'required',
            'reason' => 'required',
            'employee_id' => 'required',
            ]);

        $date = explode('-',$request->start_end_date);
        $updateEmployeeLeave = EmployeeLeave::find($request->id);
        $updateEmployeeLeave->employee_id = $request->employee_id;
        $updateEmployeeLeave->title = $request->title;
        $updateEmployeeLeave->from = date('Y-m-d',strtotime($date[0]));
        $updateEmployeeLeave->to = date('Y-m-d',strtotime($date[1]));
        $updateEmployeeLeave->type = $request->type;
        
        $date1=date_create($date[0]);
        $date2=date_create($date[1]);
        $diff=date_diff($date1,$date2);
        $total_days = $diff->format("%a");
        if($request->type == "1" && $total_days == 0){
            $updateEmployeeLeave->total_days = 1;
        } 
        else if ($request->type == "0" && $total_days = 0) {
            $updateEmployeeLeave->total_days = 0.5;
        }else if ($request->type == "0" && $total_days > 0 ) {
            $count = ($total_days * 0.5);
            $updateEmployeeLeave->total_days = $count;
        } else{
            $updateEmployeeLeave->total_days = $total_days;
        }

        $updateEmployeeLeave->reason = $request->reason;
        $updateEmployeeLeave->status = 2;
        $updateEmployeeLeave->save();
        return Redirect::to('admin/employee/leaves')
            ->with('success', 'Employee Leave has been Updated Successfully.');
    }

    /*
        This function is used to delete the  details of employee leave
    */

    public function delete($id)
    {
        $deleteEmployeeLeave = EmployeeLeave::find($id);
        $deleteEmployeeLeave->delete();
        return Redirect::to('admin/employee/leaves')
            ->with('success', 'Employee Leave has been Deleted Successfully.');
    }

    /*
        This function is used to apply leave  of employee leave
    */

    public function applyForLeave()
    {
        $employee = User::role('Employee')->get();
        
        return view('admin.employeeLeave.applyForLeave',compact('employee'));
    }

    /*
        This function is used to show leave details of employee leave
    */

    public function leaveDetails(Request $request)
    {

        $validator = $request->validate([
            'title' => 'required|max:30',
            'start_end_date' => 'required',
            'reason' => 'required',
            
            ]);

        $date = explode('-', $request->start_end_date);
        $leaveDetails = new EmployeeLeave;
        /*// if(Auth::user()->hasRole(['Admin'])){
            
        // }
        else{
            $leaveDetails->employee_id = Auth::user()->id;
        }*/
        $leaveDetails->employee_id = Auth::user()->id;    
        $leaveDetails->title = $request->title;
        $leaveDetails->from = date('Y-m-d',strtotime($date[0]));
        $leaveDetails->to = date('Y-m-d',strtotime($date[1]));
        $leaveDetails->type = $request->type;
        $leaveDetails->slot = $request->slot;
        $date1 = date_create($date[0]);
        $date2 = date_create($date[1]);
        $diff = date_diff($date1,$date2);
        $total_days = $diff->format("%a");

        if($request->type == "1" && $total_days == 0){
            $leaveDetails->total_days = 1;
        }
        else if($request->type == "0" && $total_days == 0){
            $leaveDetails->total_days = 0.5;
        }
        else if($request->type == "0" && $total_days > 0){
            $count = ($total_days*0.5);
            $leaveDetails->total_days = $count+0.5;
        }
        else{
            $leaveDetails->total_days = $total_days+1;
        }

        $leaveDetails->reason = $request->reason;
        $leaveDetails->status = 2;
        $leaveDetails->save();

        $employee = User::where('id',$request->employee_id)->first();
        $admin = User::role('Admin')->get();
        $employee = User::where('id',Auth::user()->id)->first();
        $data = array();
        $data['title'] = $request->title;
        $data['from'] = date('Y-m-d',strtotime($date[0]));
        $data['to'] = date('Y-m-d',strtotime($date[1]));
        $data['total_days'] = $leaveDetails->total_days;
        $data['reason'] = $request->reason;
        $data['email'] = $employee->email;
        $data['name'] = $employee->name;
        $data['id'] = $this->encrypt($leaveDetails->id);
        foreach($admin as $val){

            $data['adminName'] = $val->name;
            $receiver = $val->email;
            Mail::to($receiver)->send(new ApplyLeave($data));
        }
        
        // Mail::send('emails.sendLeave', array('data'=>$data), function ($message) use ($data) {
        //         $message->to($data['email'])->subject('Leave Details');
        //     });

        return Redirect::to('admin/employee/leaves')
            ->with('success', 'Employee Leave has been Added Successfully.');
    }

    /*
        This function is used to show view of approve leave and to approve leave  of employee leave
    */

    public function approveLeave($id)
    {
        $id = $this->decrypt($id);
        $leave = EmployeeLeave::find($id);

        if ($leave->status == 0) {
            return view('common')
            ->with('error', 'Employee Leave has been already Approved.');    
        }else if($leave->status == 1){
            return view('common')
            ->with('error', 'Employee Leave has been already Denied.'); 
        }   
        else {
            $leave->status = 0;
            $leave->save();
            $user = User::find($leave->employee_id);
            $data['title'] = $leave->title;
            $data['name'] = 'Admin';
            $data['message'] = 'Leave Approved Enjoy';
            $data['comment'] = '';
            $receiver = $user->email;

            Mail::to($receiver)->send(new Acknowledgement($data));


        return view('common')
            ->with('success', 'Employee Leave has been Approved.');    
        }
        
    }

    /*
        This function is used to show denied view  of employee leave
    */

    public function deniedLeave($id)
    {
        $id = $this->decrypt($id);
        $leave = EmployeeLeave::find($id);
        if($leave->status == 1){
            return view('common')
            ->with('error', 'Employee Leave has been already Denied.'); 
        }
        else if($leave->status == 0){
            return view('common')
            ->with('error', 'Employee Leave has been already Approved.');
        }
        else{
            return view('denied')->with('data',$leave);
        }
    }

    /*
        This function is used to denied employee leave
    */

    public function postDenied(Request $request)
    {
       
        $leave = EmployeeLeave::find($request->id);
        $leave->comment = $request->comment;
        $leave->status = 1;
        $leave->save();
        $user = User::find($leave->employee_id);
            $data['title'] = $leave->title;
            $data['name'] = 'Admin';
            $data['message'] = 'Leave Denied Reason Described Below';
            $data['comment'] = $leave->comment;
            $receiver = $user->email;

            Mail::to($receiver)->send(new Acknowledgement($data));
        return view('common')
            ->with('success', 'Employee Leave Denied Successfully.');
    }

    public function showLeave($id)
    {
        $id = $this->decrypt($id);
        $showLeave = EmployeeLeave::find($id);
       
        return view('admin.employeeLeave.show',compact('showLeave'));
    }

    public function approveMail($id)
    {
        $id = $this->decrypt($id);
        $employeeLeave = EmployeeLeave::find($id);
        if($employeeLeave->status == 0)
        {
            return view('common')->with('error','The Employee Leave has been already approved');
        }

        else if($employeeLeave->status == 1){
            return view('common')
            ->with('error', 'Employee Leave has been already Denied.'); 
        }   
        else {
            $employeeLeave->status = 0;
            $employeeLeave->save();
            $user = User::find($employeeLeave->employee_id);
            $data['title'] = $employeeLeave->title;
            $data['name'] = 'Admin';
            $data['message'] = 'Leave Approved Enjoy';
            $data['comment'] = '';
            $receiver = $user->email;

            Mail::to($receiver)->send(new Acknowledgement($data));
            return Redirect::back()->with('success','The Employee Leave has been  Approved');
             
        }
    }
    public function deniedMail($id)
    {
        $id = $this->decrypt($id);
        $employeeLeave = EmployeeLeave::find($id);
        if($employeeLeave->status == 1){
            return view('common')->with('error','The Employee Leave has been already denied');
        }
        else{
            return view('admin.employeeLeave.index')->with('data',$employeeLeave);
        }
    }

    public function postDenied2(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:30',
            
        ]);
        $employeeLeave = EmployeeLeave::find($request->id);
        $employeeLeave->comment = $request->comment;
        $employeeLeave->status = 1;
        $employeeLeave->save();
        $user = User::find($employeeLeave->employee_id);
        $data['title'] = $employeeLeave->title;
            $data['name'] = 'Admin';
            $data['message'] = 'Leave Denied Reason Described Below';
            $data['comment'] = $employeeLeave->comment;
            $receiver = $user->email;
          Mail::to($receiver)->send(new Acknowledgement($data));
        return Redirect::back()
            ->with('success', 'Employee Leave Denied Successfully.');
    }

}

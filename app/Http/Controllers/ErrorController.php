<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErrorReport;
use Redirect,Auth;
use Yajra\Datatables\Datatables;

class ErrorController extends Controller
{   
    /*
        This function is used to view the index page of Error report
    */

    public function index()
    {

        return view('admin.ErrorReport.index');
    }

    /*
        This function is used to get data of Error report
    */

    public function getData()
    {
        
         $errors = ErrorReport::with('users','errorsByUser')->orderBy('status','ASC')->get();    

        return Datatables::of($errors)
        ->editColumn('error_by_name',function($error){
                    return $error->errorsByUser['name'];
                })->
                addColumn('status', function($error) {
                    if ($error->status == 0 && $error->updated_by == NULL) {
                        $spanHtml = '<span class="badge badge-pill badge-info">Pending</span>';
                    } else if ($error->status == 0 && $error->updated_by != NULL) {
                        $spanHtml = '<span class="badge badge-pill badge-danger">Reopened</span>';
                    } else {
                        $spanHtml = '<span class="badge badge-pill badge-success">Fixed</span>';
                    }
                    return $spanHtml;
                })->editColumn('name',function($error){
                    return $error->users['name'];
                })
                ->addColumn('action', function ($error) {
                    $html = "";
                    if(Auth::user()->hasAnyPermission(['show-error-view'])){
                        $html .= '<form id="form'.$error->id.'" action="'.route('error.delete',$error->id).'"  method="post">
                        <a href="'.route('error.view',$this->encrypt($error->id)).'" class = "btn btn-info" ><i class="fa fa-eye"></i></a>';
                    }

                    else{
                        $html .= '<form id="form'.$error->id.'" action="'.route('error.delete',$ticket->id).'"  method="post">';
                    }

                    if(Auth::user()->hasAnyPermission(['edit-error'])){
                        $html .= '<a href="'.route('error.edit',$this->encrypt($error->id)).'" class = "btn btn-primary" ><i class="fa fa-edit"></i></a>';
                    }
                    else{
                         $html .= '';

                    }
                    if(Auth::user()->hasAnyPermission(['delete-error'])){
                        $html .= ''.method_field("delete").csrf_field().' 
                        <button class="btn btn-danger" onclick="confirmDelete('.$error->id.')" type="button"><i class="fa fa-trash"> </i></button>
                            </form>
                            <script>
                            </script>';
                    }
                    else{
                        $html .= '</form>';
                    }
                    return $html;
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    /*
        This function is used create new  Error 
    */

    public function create()
    {
        return view('admin.ErrorReport.create');
    }

    /*
        This function is used to store the data of Error 
    */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:30',
            'description' => 'required',
            'attachment' => 'mimes:jpeg,png,bmp,doc,docx,pdf',
            'video_link' => 'required_without:description|active_url|nullable',
        ]);
        
        $storeError = new ErrorReport;
        $storeError->user_id = Auth::user()->id;
        $storeError->title = $request->title;
        $storeError->description = $request->description;
        if(isset($request->attachment)){
           $storeError->attachment = $request->attachment->store('attachments');
        }
        $storeError->video_link = $request->video_link;
        $storeError->save();
        return Redirect::to('admin/error')
            ->with('success', 'The Error has been Added Successfully.');
    }

    /*
        This function is used to get the edit details of Error 
    */

    public function edit($id)
    {
        $id = $this->decrypt($id);
        $editError = ErrorReport::find($id);
        return view('admin.ErrorReport.edit',compact('editError'));
    }

    /*
        This function is used to update data of Error 
    */

    public function update($id,Request $request)
    {

        $request->validate([
            'title' => 'required|max:30',
            'description' => 'required',
        ]);
        $updateError = ErrorReport::find($id);

        $updateError->title = $request->title;
        $updateError->description = $request->description;
        if(isset($request->attachment)){
            $updateError->attachment = $request->attachment->store('attachments');
        }
        $updateError->video_link = $request->video_link;
        $updateError->save();
        return Redirect::to('admin/error')
            ->with('success', 'The Error has been Updated Successfully.');

    }

    /*
        This function is used to delete data of Error 
    */

    public function delete($id)
    {
        
        $deleteError  = ErrorReport::find($id);
        $deleteError->delete();
        return Redirect::to('admin/error')
            ->with('success', 'The Error has been Deleted successfully.'); 
    }

    /*
        This function is used to view data of Error 
    */

    public function view($id)
    {   
        $id = $this->decrypt($id);
        $viewError = ErrorReport::find($id);
        
        return view('admin.ErrorReport.show',compact('viewError'));
    }

    public function errorFix($id,Request $request)
    {
        $fixError = ErrorReport::find($id);
        if($fixError->status == 0)
        {
            $fixError->status = 1;
            $message = 'The Error has been Fixed.';
        }
        else{
            $fixError->status = 0;
            $message = 'The Error has been Reopened.';   
        }
        $fixError->updated_by = Auth::user()->id;
        $fixError->save();
        return Redirect::back()
            ->with('success', $message ); 
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Redirect,Auth;
use Yajra\Datatables\Datatables;

class PermissionController extends Controller
{
    /*
    	This function is created at 3rd Jan and used for listing the permission 
    */

    public function index()
    {
    	return view('admin.permission.index');
    }

    /*
    	This function is created at 3rd Jan and used to get all the permission 
    */

    public function getData()
    {
        //return Datatables::of(User::query())->make(true);
        $permission = new Permission;
       	$permissions = Permission::all();
       	

        return Datatables::of($permissions)->addColumn('action', function ($permission) {
                $html = "";

                if(Auth::user()->hasAnyPermission(['edit-permission'])){
                    $html .= '<form id="form'.$permission->id.'" action="'.route('permission.delete',$permission->id).'"  method="post">
                        <a href="'.route('permission.edit',$this->encrypt($permission->id)).'" class = "btn btn-primary" ><i class="fa fa-edit"></i></a>'; 
                }
                else{
                    $html .= '<form id="form'.$permission->id.'" action="'.route('permission.delete',$permission->id).'"  method="post">';
                }
                if(Auth::user()->hasAnyPermission(['delete-permission'])){
                    $html .= ''.method_field("delete").csrf_field().' 
                    <button class="btn btn-danger" onclick="confirmDelete('.$permission->id.')" type="button"><i class="fa fa-trash"></i></button>
                    </form><script> </script>';
                }
                else{
                    $html .= '</form>';
                }  

                return $html; 
                  
                     
            })
            ->make(true);
    }

    /*
    	This function is created at 3rd Jan and used to create the permission 
    */

    public function create()
    {
    	return view('admin.permission.create');
    }

    /*
    	This function is created at 3rd Jan and used to store the permission 
    */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',        
        ]);
        
    	$permission = Permission::create(['name' => $request->name]);
    	if($permission){
            return Redirect::to('admin/permission')
            ->with('success', 'The Permission has been Added successfully.'); 
        }
        else{
            return Redirect::Back()->with('error','Unable to Add Permission');
        }
    }

    /*
    	This function is created at 3rd Jan and used to get the edit details of permission 
    */

    public function edit($id)
    {
        $id = $this->decrypt($id);
    	$editPermission = Permission::find($id);
        if($editPermission){
            return view('admin.permission.edit',compact('editPermission'));     
        }
        else{
            return abort(404);
        }
    	
    }

    /*
        This Function is created at 3rd Jan 2019 And Used To Update Pernmission Details
    */

    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required|max:30|unique:permissions',
        ]);
        
    	$updatePermission = Permission::find($id);
    	$input = $request->all();
    	$updatePermission->fill($input)->save();
    	return Redirect::to('admin/permission')
            ->with('success', 'The Permission has been Updated successfully.'); 
    }

    /*
        This Function is created at 3rd Jan 2019 And Used To Delete Particular Permission Details
    */

    public function delete($id)
    {
        $deletePermission  = Permission::find($id);
        $deletePermission->delete();
        return Redirect::to('admin/permission')
            ->with('success', 'The Permission has been Deleted successfully.'); 

    }

}

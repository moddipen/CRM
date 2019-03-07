<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Redirect,Auth;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
{
    /*
    	This function is created at 3rd Jan and used for listing  of the roles 
    */

    public function index()
    {
    	return view('admin.role.index');   
    }

    /*
    	This function is created at 3rd Jan and used to get all the roles 
    */

    public function getData()
    {
        //return Datatables::of(User::query())->make(true);
        $role = new Role;
       	$roles = Role::all();
        return Datatables::of($roles)
            ->addColumn('action', function ($role) { 
                $html = "";

                if(Auth::user()->hasAnyPermission(['edit-role'])){
                    $html .= '<form id="form'.$role->id.'" action="'.route('role.delete',$role->id).'"  method="post" >
                        <a href="'.route('role.edit',$this->encrypt($role->id)).'" class = "btn btn-primary" ><i class="fa fa-edit"></i></a>';
                }
                else {
                    $html .= '<form id="form'.$role->id.'" action="'.route('role.delete',$role->id).'"  method="post" >';
                }

                if(Auth::user()->hasAnyPermission(['delete-role'])){
                    $html .= ''.method_field("delete").csrf_field().'<button class="btn btn-danger" onclick="confirmDelete('.$role->id.')"  type="button"><i class="fa fa-trash"></i></button>
                    </form> 
                    <script> </script>';                   
                }
                else{
                    $html .= '</form>';
                } 

                return $html;              
            })->make(true);
    }

    /*
    	This function is created at 3rd Jan and used to create the role 
    */

    public function create()
    {	

    	$permission = Permission::all();
    	return view('admin.role.createRole',compact('permission'));
    }

    /*
    	This function is created at 3rd Jan and used to store the role 
    */

    public function store(Request $request)
    {
    	
        $validator = $request->validate([
            'name' => 'required|max:30',
            'permission' => 'required',
            ]);
        
    	$role = new Role;
    	$role->name = $request->name;
    	$permission = $request->permission;
    	$role->save();

    	foreach ($permission as $val) {
    		$p = Permission::where('id','=',$val)->firstOrfail();
    		$role = Role::where('name','=',$request->name)->first();
    		$role->givePermissionTo($p); 
    	}

    	return Redirect::to('admin/role')
            ->with('success', 'The Role has been Added successfully.'); 
    }
    
    /*
        This function is created at 3rd Jan and used to get the edit details of the role 
    */

    public function edit($id)
    {
        $id = $this->decrypt($id);
        $permission = Permission::all();
        $editRole = Role::find($id);
        
        if($editRole){
            return view('admin.role.edit',compact('editRole','permission'));    
        }
        else{
            return abort(404);
        }
        
    }

    /*
        This function is created at 3rd Jan and used to update the role 
    */

    public function update($id,Request $request)
    {   
         $request->validate([
            'name' => 'required|max:30',
            'permissions' => 'required',
            ]);
        
        $role = Role::find($id);
        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();
        $p = Permission::all(); 

        foreach($p as $value)
        {
            $role->revokePermissionTo($value);
        } 

        foreach($permissions as $permission)
        {
            $p_all = Permission::where('id','=',$permission)->firstOrfail();
            $role->givePermissionTo($p_all);
        }

        return Redirect::to('admin/role')
            ->with('success', 'The Role has been Updated successfully.');               
    }

    /*
        This function is created at 3rd Jan and used to delete the role 
    */
    
    public function delete($id)
    {
        $deleteRole = Role::find($id);
        $deleteRole->delete();
        return Redirect::to('admin/role')
            ->with('success', 'The Role has been Deleted successfully.');
    }
}

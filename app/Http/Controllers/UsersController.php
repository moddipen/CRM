<?php

namespace App\Http\Controllers;
use Redirect;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;
use Mail;
use App\UserProfile;
use App\Mail\UserMail;
use App\Mail\ForgotPassword;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Show the users list
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
         return view('admin.user.index');
    }

    /**
     * fetch the data of users
     *
     * @return \Illuminate\Http\Response
     */

    /*
        This Function is created at 2 Jan 2019 And Used To Get Employee Details
    */
        
    public function getData()
    {
        //return Datatables::of(User::query())->make(true);
        $user = new User;
        $users = $user->getUserData();
        
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                $html = "";

                if(Auth::user()->hasAnyPermission(['show-user'])  ) {
                    $html .= '<form id="form'.$user->id.'" action="'.route('user.delete',$user->id).'"  method="post"><a href="'.route('user.show',$this->encrypt($user->id)).'" class = "btn btn-info" >
                        <i class="fa fa-eye"></i></a>';
                } else {
                    $html .= '<form id="form'.$user->id.'" action="'.route('user.delete',$user->id).'"  method="post">';
                }
                if(Auth::user()->hasAnyPermission(['edit-user'])  ) {
                    $html .= '<a href="'.route('user.edit',$this->encrypt($user->id)).'" class = "btn btn-primary" >
                        <i class="fa fa-edit"></i></a>';
                } else {
                    $html .= '';
                }

                if(Auth::user()->hasAnyPermission(['delete-user'])  ) {
                    $html .= ''.method_field("delete").csrf_field().'<button class="btn btn-danger" onclick="confirmDelete('.$user->id.')" type="button"><i class = "fa fa-trash "></i></button></form>
                        <script>
                        
                        </script>';
                } else {
                    $html .= '</form>';
                }

                return $html;
            })
            ->removeColumn('password')
            ->make(true);
    }

    /*
        This Function is created at 2 Jan 2019 And Used To Create Employee
    */

    public function create()
    {   
            $roles = Role::all();
            return view('admin/user/create',compact('roles'));
    }

    /*
        This Function is created at 2 Jan 2019 And Used To Store Employee Details
    */

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|unique:users',
            'role_id' => 'required',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            ]);
        
        $user = new User;

        $storeResult = $user->storeUserData($request);
        if($storeResult){

            $data = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            $receiver = $request->email;
            Mail::to($receiver)->send(new UserMail($data));

            return Redirect::to('admin/user')
            ->with('success', 'The User has been Added successfully.'); 
        }
        else{
            return Redirect::Back()->with('error','Unable to Add User');
        }
    }

    /*
        This Function is created at 2 Jan 2019 And Used To Edit Employee Details
    */

    public function edit($id)
    {   
        $id = $this->decrypt($id);
        $role = Role::all();
        $editUser = User::find($id);
        if($editUser){
            return view('admin.user.edit',compact('editUser','role'));    
        }
        else{
            return abort(404);
        }
        
    }

    /*
        This Function is created at 2 Jan 2019 And Used To Update Employee Details
    */

    public function update($id,Request $request)
    {

        $validator = $request->validate([
            'name' => 'required|max:30',
            // 'email' => 'required|email|unique:users,email,'.$id,
            'email' => [
            'required',Rule::unique('users')->ignore($id),],
            'role_id' => 'required',
        ]);

        $updateUser = User::find($id);
        $storeUpdate = $updateUser->updateUser($request);
        if($storeUpdate){
            return Redirect::to('admin/user')->with('success', 'The User has been Updated successfully.'); 
        } else {
            return Redirect::Back()->with('error','Unable to Update User');
        }

    }

    /*
        This Function is created at 2 Jan 2019 And Used To Delete Employee Details
    */

    public function delete($id)
    {
        
        $deleteUser = User::find($id);
        $deleteResult = $deleteUser->deleteUser($id);
        if($deleteResult){
            return Redirect::to('admin/user')->with('success', 'The User has been Deleted successfully.');
        }
    }
    /*
        This Function is used to show change password view 
    */

    public function changePassword()
    {
        $user = User::find(Auth::user()->id);
        
        return view('admin.user.changePassword',compact('user'));
    }

    /*
        This Function is  used to change password  
    */

    public function updatePassword(Request $request)
    {

        $request->validate([
                 'password' => 'required|min:6',
                 'password_confirmation' => 'required|same:password',   
            ]);

        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();
        return Redirect::Back()->with('success','Password Change Successfully');

    }

    /*
        This function is used to show profile  
    */

    public function profile()
    {
        $profile = UserProfile::where('user_id',Auth::user()->id)->first();

        if(isset($profile)){
            $profile->dob = date('m/d/Y',strtotime($profile->dob));
            return view('admin.user.profile',compact('profile'));
            
        }
        else{
            return view('admin.user.profile');    
        }
        
    }

    /*
        This function is used to update the profile
    */

    public function storeProfile(Request $request)
    {   

        $request->validate([
            'firstname' => 'required|max:30',
            'lastname' => 'required|max:30',
            'address' => 'required',
            'phone_number' => 'required|min:8|max:14',
            'alternate_number' => 'min:8|max:14',
            'dob' => 'required',
            'photo' => 'mimes:jpeg,png',
            'id_proof' => 'mimes:jpeg,png'
        ]);
        $profile = UserProfile::where('user_id',Auth::user()->id)->first();
        if(!$profile){
            $profile = new UserProfile;
        }
        
        
        $profile->user_id = Auth::user()->id;
        $profile->firstname = $request->firstname;
        $profile->lastname = $request->lastname;
        $profile->address = $request->address;
        $profile->phone_number = $request->phone_number;
        $profile->alternate_number = $request->alternate_number;
        if(isset($request->photo)){
            $profile->photo = $request->photo->store('profile');
        }
        $profile->dob = date('Y-m-d',strtotime($request->dob));
        if(isset($request->id_proof)){
            $profile->id_proof = $request->id_proof->store('profile');
        }
        $profile->save();
        return Redirect::Back()->with('success','User Profile Changed Successfully');
    } 
    public function removeImg(Request $request)
    {

        if($request['id_proof'] == 'idImg' ){
            $profile = UserProfile::where('user_id',Auth::user()->id)->first();
            unlink('storage/app/'.$profile->id_proof);
            $profile->id_proof = NULL;
            $profile->save();
            echo 'Your Image has been Removed';

        }
        else{
            $profile = UserProfile::where('user_id',Auth::user()->id)->first();
            unlink('storage/app/'.$profile->photo);
            $profile->photo = NULL;
            $profile->save();
            echo 'Your Photo has been Removed';
        }
    }

    public function forgotPassword()
    {
        return view('forgotpwd');
    }

    public function sendPassword(Request $request)
    {

        $userData = User::where('email',$request->email)->first();
        if($userData->remember_token == NULL){
            $userData->remember_token = Str::random(60);
            $userData->save();

        }
        
        if($userData){
                $data = [
                    'id' => $userData->remember_token,
                ];
                $receiver = $request->email;
                Mail::to($receiver)->send(new ForgotPassword($data));
                return Redirect::back()
                ->with('success', 'Reset Password Link Sent Successfully.');  
            }
            else
            {
                return Redirect::Back()->with('error','Please Enter Valid Email');
            }     
       
            
    }
    public function resetPassword($remember_token)
    {
       
        $userEmail = User::where('remember_token',$remember_token)->first();
        if($userEmail){
            return view('resetpwd',compact('id','userEmail'));
        }
        else{
            return abort(404);
        }
       
    }
    public function setPassword($id,Request $request)
    {
        $request->validate([
                 'password' => 'required|min:6',
                 'password_confirmation' => 'required|same:password',   
            ]);
        $setPassword = User::find($id);
        $setPassword->password = bcrypt($request->password);
        $setPassword->remember_token = Str::random(60);
        $setPassword->save();
        return Redirect::to('admin')->with('success','Password Reset Successfully');
    }

    public function viewUser($id)
    {
        $id = $this->decrypt($id);
        $viewUser = UserProfile::with('user')->where('user_id',$id)->first();
       
        return view('admin.user.show',compact('viewUser'));
    }
}

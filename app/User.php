<?php

namespace App;
use Illuminate\Auth\MustVerifyEmail;
use App\Http\Controllers\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable 
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
    */
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    /*
        This Function is created at 2 Jan 2019 And Used To Get Employee Details
    */

    public function getUserData()
    {
        return User::select(['id', 'name', 'email', 'password', 'last_login'])->where('id','<>',Auth::user()->id)->get();
    }

    /*
        This Function is created at 2 Jan 2019 And Used To Store Employee Details
    */

    public function storeUserData($request)
    {   
        $this->name = $request->name;
        $this->email = $request->email;
        $this->password = Hash::make($request->password);
        if($this->save()) {
            $role = $request['role_id'];
            if(isset($role)){
                $role_r = Role::where('id','=',$role)->firstOrfail();
                $this->assignRole($role_r);
                return true;    
            }
            else{
                return false;
            }
        } else {
            return false;
        }
        
    }
    
    /*
        This Function is created at 2 Jan 2019 And Used To Update Employee Details
    */

    public function updateUser($request)
    {   
        $this->name = $request->name;
        $this->email = $request->email;
        
        $updateResult = $this->save();    
        if ($updateResult) {
            $role = $request['role_id'];
            if(isset($role)){
                $r = Role::all();
                foreach ($r as $val) {
                    $this->removeRole($val);
                }
                $r_all = Role::where('id','=',$role)->firstOrfail();
                $this->assignRole($r_all);
                return true;         
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

        
        
    }

    /*
        This Function is created at 2 Jan 2019 And Used To Delete Employee Details
    */

    public function deleteUser($id)
    {
        $delete = User::find($id);
        return $delete->delete();

    }
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class,'user_id');
    }
}

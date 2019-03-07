<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
			

	} 
	public function printResult($result)
	{
        echo "<pre>";
        print_r($result);
        exit();
    }
	public function encrypt($id)
	{
		$encryptId = Crypt::encrypt($id);
			return $encryptId;
	}
	public function decrypt($id)
	{
		try{
			$decryptId = Crypt::decrypt($id);	
			return $decryptId;
		}
		catch(DecryptException $e){
			return abort(404);
		}
	}
	public function generateRandomString($length = 10)
	{
	    $characters = '1234567890';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return '#'.$randomString;
	}	
		
	
}

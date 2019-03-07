<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Sentinel;
use Analytics;
use View;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;
use Charts;
use App\Datatable;
use App\User;
use Illuminate\Support\Facades\DB;
use Spatie\Analytics\Period;
use Illuminate\Support\Carbon;
use App\Ticket;
use App\Models\EmployeeLeave;
use File;
use Auth;
use DateTime;
use App\UserProfile;
use App\Models\GeneralLeave;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */

    public function index()
    {    
        
        // Slot 1 : 1st Apr To 30th Sep
        $slotOneStartDate = date('Y-04-01');    
        $slotOneEndDate = date('Y-09-30');

        // Slot 2 : 1st Oct To 31st Mar + Year dynamic
        $currentMonth = date('m');
        
        if ( $currentMonth == 01 || $currentMonth == 02 || $currentMonth == 03 ) { // Jan,Feb,Mar

            $year = date('Y');
            $year = $year - 1;
            $slotTwoStartDate = date($year.'-10-01');
            $slotTwoEndDate = date('Y-03-31');

        } else if ( $currentMonth == 10 || $currentMonth == 11 || $currentMonth == 12 ) { // Oct,Nov,Dec 

            $year = date('Y');
            $year = $year + 1;
            $slotTwoStartDate = date('Y-10-01');
            $slotTwoEndDate = date($year.'-03-31');

        }

        $today = date('Y-m-d');
        $today=date('Y-m-d', strtotime($today));
        
        // Slot 1 dates
        if (($today > $slotTwoStartDate) && ($today < $slotTwoEndDate)) {
            // Slot 2 query 

            $leave = EmployeeLeave::where('status',0)
                ->where('employee_id','=',Auth::user()->id)
                ->where('from', '>=' ,$slotTwoStartDate)
                ->where('to' ,'<=', $slotTwoEndDate)
                ->sum('total_days');

        } else {

            // Slot 1 Query
            $leave = EmployeeLeave::where('status',0)
                ->where('employee_id','=',Auth::user()->id)
                ->where('from', '>=' ,$slotOneStartDate)
                ->where('to' ,'<=', $slotOneEndDate)
                ->sum('total_days');
        }
        // Pending Leave
        $totalLeaves = 7;
        $leaveTaken = $leave;
        $PendingLeaves = $totalLeaves - $leaveTaken;
        $ticket = Ticket::where('employee_id',Auth::user()->id)->where('status','=',1)->count();

        $start = date('z') + 1;
        $end = date('z') + 1 + 364;
        $bday = UserProfile::whereRaw("DAYOFYEAR(dob) BETWEEN $start AND $end")->orderByRaw('MONTH(dob)','ASC')->orderByRaw('DAY(dob)','ASC')->get();
                
        // $bday = UserProfile::whereMonth('dob','>=',$date->month)
        //                     ->whereDay('dob','>=', $date->day)
        //                     ->orderByRaw('DAY(dob)','ASC')
        //                     ->orderByRaw('MONTH(dob)','ASC')
        //                     ->limit(3)
        //                     ->get();

        $holidayend = date('z') + 1 + 364;

        $holiday = GeneralLeave::whereRaw("DAYOFYEAR(date) BETWEEN $start AND $holidayend")->orderByRaw('MONTH(date)','ASC')->orderByRaw('DAY(date)','ASC')->limit(4)->get();

        // $holiday = GeneralLeave::whereDate('date','>=',$date)
        //                         ->whereMonth('date','>=',$month)
        //                         ->orderByRaw('DAY(date)','ASC')
        //                         ->orderByRaw('MONTH(date)','ASC')
        //                         ->limit(3)
        //                         ->get();

        $remainingLeave = EmployeeLeave::where('status','=',2)->count();

        $leaveTaken = EmployeeLeave::whereRaw("DAYOFYEAR(`from`) BETWEEN $start AND $end")->whereRaw("DAYOFYEAR(`to`) BETWEEN $start AND $end")->orderByRaw('MONTH(`from`)','ASC')->orderByRaw('DAY(`from`)','ASC')->limit(5)->get();
                     
        return view('home',compact('leave','PendingLeaves','ticket','bday','holiday','remainingLeave','leaveTaken'));
        
    }

    
}   



<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\RegisterEmail;
use App\Models\Reportedtime;
use Illuminate\Http\Request;
use App\Models\Reportingtime;
use App\Models\Reportnotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StaffController extends Controller
{
    public function index(Request $request) {
        //dd($request->path());
        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }
        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }
        if ($request->path() == 'login') {
            return redirect('/');
        }
        return view('welcome');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
    public function createStaff(Request $request) {
        $uniqid = uniqid();
        //validate request
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            ]);
            $password = bcrypt($request->password);
            $user = User::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'staff_id' => $uniqid,
                'password' => $password,
                //'role_id' => $request->role_id,
                ]);
    Mail::to($request->email)->send( new RegisterEmail($user));
    return $user;
}

public function getStaffs () {
    return User::orderBy('id', 'desc')->get(['firstName', 'lastName', 'email', 'staff_id', 'created_at']);
}

public function login(Request $request) {

    //return $request->staff_id;
            //validate request
    $this->validate($request, [
        'email' => 'bail|required|email',
        'password' => 'bail|required|min:6',
    ]);
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        //return $user;
        return response()->json([
            'msg' => 'You are logged in',
            'user' => $user
        ]);
    }else {
        return response()->json([
            'msg' => 'Incorrect Admin login'
        ], 401);    }
    

        if (Auth::attempt(['staff_id' => $request->staff_id, 'password' => $request->password])) {
            $user = Auth::user();
            //return $user;
            return response()->json([
                'msg' => 'You are logged in',
                'user' => $user
            ]);
        }else {
            return response()->json([
                'msg' => 'Invalid Staff ID'
            ], 401);    }      
    
}

public function createReportingTime(Request $request, $time) {
    $reportingTime = Reportingtime::create([
        'time' => $time,
    ]);
    return $reportingTime;
}

//get latest reporting time set by the admin
public function get_reportingTime () {
    return Reportingtime::get('time')->last();
}

//get latest reporting time set by the admin
public function get_reportedTimes () {
    return Reportnotification::get();
}

public function createReportedTime(Request $request, $staff_id) {
    //check if there is a user with that staff id
    $checkStaff = User::select()->where('staff_id', $staff_id)->count();
    if ($checkStaff > 0) {
        $call_user = User::select('id', 'staff_id')->where('staff_id', $staff_id)->get();
        $user_id = $call_user[0]->id;
        //$user_staff_id = $call_user[0]->staff_id;
        $reportedTime = Reportedtime::create([
            'staff_id' => $staff_id,
            'user_id' => $user_id,
        ]);
        $reportedTime->save();
        
        //Get the time of the last reporting time set by the admin
        $reportingTime = Reportingtime::get('time')->last();
        $reportingTime = $reportingTime->time;
        
        //get the time of the latest reported time of the user 
        $reportedTime = Reportedtime::select('created_at')->where('staff_id', $staff_id)->get()->last();
        $newreportedTime = $reportedTime->created_at->format('H:i:s');
        
        //get the time difference between the reporting time and reported time 
        $timediff = Carbon::parse($reportingTime)->diffInSeconds($newreportedTime);
        //convert to milliseconds
        $timediff = $timediff * 1000;
        
        //get the user 
        $userreportedTime = Reportedtime::select()->where('staff_id', $staff_id)->get()->last();
        $fullname =  $userreportedTime->user->firstName . ' '. $userreportedTime->user->lastName;
        
        
        //return Carbon::parse($newreportedTime);
        //return 'reporting time: ' . Carbon::parse($reportingTime)->secondsSinceMidnight() . ' reported time: ' . Carbon::parse($newreportedTime)->secondsSinceMidnight();
        if (Carbon::parse($reportingTime)->secondsSinceMidnight() > Carbon::parse($newreportedTime)->secondsSinceMidnight()) {
            $reportedTime = Reportnotification::create([
                'staff_id' => $staff_id,
                'name' => $fullname,
                'reportingtime' => $reportingTime,
                'timereported' => $newreportedTime,
                'timediff' => $timediff,
                'status' => 1
            ]);
            return $reportedTime;
            } else {
            $reportedTime = Reportnotification::create([
                'staff_id' => $staff_id,
                'name' => $fullname,
                'reportingtime' => $reportingTime,
                'timereported' => $newreportedTime,
                'timediff' => $timediff,
                'status' => 0
            ]);
            return $reportedTime;
            
        }
    } else{
        return response()->json([
            'msg' => 'Invalid Staff ID'
        ], 401);
    }

}
public function getDateRange(Request $request, $fromDate, $toDate) {
    //return $fromDate;
    $getDateData = Reportnotification::whereBetween('created_at', [$fromDate, $toDate])->get();
    return $getDateData;

}







}
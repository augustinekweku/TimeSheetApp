<?php

namespace App\Http\Controllers;

use App\Models\Reportnotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getLastNotification() {
        $notifications = Reportnotification::orderBy('id', 'desc')->get();
        //get the count of notifications
        $notifications_count = Reportnotification::all()->count();
        $notifications_count;
        return response()->json([
            'notifications' => $notifications,
            'notifications_count' => $notifications_count
        ], 200); 
    }
}

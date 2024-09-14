<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Rider;
use App\Models\Tracking;
use Illuminate\Http\Request;
use App\Models\VendorCompany;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $admins = Admin::count();
        $users = User::count();
        $riders = Rider::count();
        $companies = VendorCompany::count();
        $data['user_stats'] = [
            'admins' => $admins,
            'users' => $users,
            'riders' => $riders,
            'companies' => $companies,
        ];

        $data['trackings'] = Tracking::whereIn('status_id', [4, 6])->whereDate('time', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->get();
        //return [$admins, $users, $riders, $companies];
        return view('admin.dashboard.dashboard', $data);
    }

    public function ReadNotification($id)
    {
        $userUnreadNotification = auth()->user()
        ->unreadNotifications
        ->where('id', $id)
        ->first();
        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
        }
        return back();
    }
}

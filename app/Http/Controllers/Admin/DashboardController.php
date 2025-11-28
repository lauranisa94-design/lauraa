<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $today = now()->toDateString();
        $todayChecks = Attendance::where('date', $today)->count();
        $recent = Attendance::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact('totalUsers', 'todayChecks', 'recent'));
    }
}

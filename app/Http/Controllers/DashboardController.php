<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show user dashboard with recent activities
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Recent attendances for this user (last 10)
        $activities = Attendance::where('user_id', $user->id)
            ->with('user')
            ->orderBy('date', 'desc')
            ->orderByDesc('check_in')
            ->limit(10)
            ->get();

        return view('dashboard', compact('activities'));
    }
}

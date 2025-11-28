<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::where('user_id', Auth::id())
                        ->orderBy('date', 'desc')
                        ->paginate(10); // pagination
        
        // Ambil attendance hari ini
        $today = Carbon::today();
        $todayAttendance = $attendances->firstWhere('date', $today);

        return view('attendance', compact('attendances', 'todayAttendance'));
    }

    public function checkin(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:5120',
            'location' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500'
        ]);

        $photoPath = $request->file('photo')->store('attendance_photos', 'public');

        $today = Carbon::today();
        $attendance = Attendance::where('user_id', Auth::id())
                        ->where('date', $today)
                        ->first();

        if ($attendance) {
            // Update existing record
            $attendance->update([
                'check_in' => now(),
                'location' => $request->location,
                'note' => $request->note,
                'photo' => $photoPath
            ]);
        } else {
            // Create new record
            Attendance::create([
                'user_id' => Auth::id(),
                'date' => $today,
                'check_in' => now(),
                'location' => $request->location,
                'note' => $request->note,
                'photo' => $photoPath
            ]);
        }

        return redirect()->route('attendance.index')->with('success', 'Absensi berhasil!');
    }

    public function checkout(Request $request)
    {
        $today = Carbon::today();
        $attendance = Attendance::where('user_id', Auth::id())
                        ->where('date', $today)
                        ->first();

        if($attendance) {
            $attendance->update(['check_out' => now()]);
            return redirect()->route('attendance.index')->with('success', 'Absensi berhasil!');
        }

        return redirect()->route('attendance.index')->with('error', 'Absensi hari ini belum ada.');
    }
}

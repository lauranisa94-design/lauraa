<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceReportController extends Controller
{
    /**
     * Display attendance report with filters
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : now()->subMonths(1);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : now();
        $userId = $request->input('user_id');
        $roleFilter = $request->input('role', 'user'); // Default to 'user' (soldiers/staff)

        // Get all users (soldiers/staff only, not admins)
        $users = User::where('role', $roleFilter)->get();

        // Base query
        $query = Attendance::whereBetween('date', [$startDate, $endDate]);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $attendances = $query->with('user')->orderBy('date', 'desc')->paginate(50);

        // Calculate statistics
        $stats = $this->calculateStatistics($startDate, $endDate, $userId, $roleFilter);

        return view('admin.attendance-report', compact('attendances', 'users', 'stats', 'startDate', 'endDate', 'userId'));
    }

    /**
     * Calculate attendance statistics
     */
    private function calculateStatistics($startDate, $endDate, $userId = null, $roleFilter = 'user')
    {
        $query = Attendance::whereBetween('date', [$startDate, $endDate]);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $allAttendances = $query->get();
        $totalDays = $this->countWorkingDays($startDate, $endDate);

        // Get users for comparison
        $usersQuery = User::where('role', $roleFilter);
        if ($userId) {
            $usersQuery->where('id', $userId);
        }
        $users = $usersQuery->get();
        $totalUsers = count($users);

        // Calculate per user
        $userStats = [];
        foreach ($users as $user) {
            $userAttendances = $allAttendances->filter(fn($a) => $a->user_id === $user->id);
            
            $present = $userAttendances->filter(fn($a) => $a->check_in)->count();
            $absent = $totalDays - $present;
            $late = $userAttendances->filter(fn($a) => 
                $a->check_in && $a->check_in->format('H:i') > '08:00'
            )->count();

            $userStats[$user->id] = [
                'name' => $user->name,
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
                'percentage' => $totalDays > 0 ? round(($present / $totalDays) * 100, 2) : 0,
            ];
        }

        return [
            'total_days' => $totalDays,
            'total_users' => $totalUsers,
            'total_present' => $allAttendances->filter(fn($a) => $a->check_in)->count(),
            'total_absent' => ($totalUsers * $totalDays) - $allAttendances->filter(fn($a) => $a->check_in)->count(),
            'total_late' => $allAttendances->filter(fn($a) => 
                $a->check_in && $a->check_in->format('H:i') > '08:00'
            )->count(),
            'avg_attendance_rate' => $totalUsers > 0 ? round(
                ($allAttendances->filter(fn($a) => $a->check_in)->count() / ($totalUsers * $totalDays)) * 100, 2
            ) : 0,
            'user_stats' => $userStats,
        ];
    }

    /**
     * Count working days (Monday-Friday)
     */
    private function countWorkingDays($startDate, $endDate)
    {
        $count = 0;
        $current = $startDate->copy();

        while ($current <= $endDate) {
            // 1 = Monday, 5 = Friday (exclude weekends)
            if ($current->dayOfWeek >= 1 && $current->dayOfWeek <= 5) {
                $count++;
            }
            $current->addDay();
        }

        return $count;
    }

    /**
     * Export attendance report to CSV
     */
    public function exportCSV(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : now()->subMonths(1);
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : now();
        $userId = $request->input('user_id');
        $roleFilter = $request->input('role', 'user');

        $query = Attendance::whereBetween('date', [$startDate, $endDate]);
        if ($userId) {
            $query->where('user_id', $userId);
        }

        $attendances = $query->with('user')->orderBy('date', 'asc')->get();

        $filename = 'attendance_report_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($attendances) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Tanggal', 'Nama', 'Check In', 'Check Out', 'Durasi', 'Lokasi', 'Status']);

            // Data
            foreach ($attendances as $a) {
                $duration = '-';
                if ($a->check_in && $a->check_out) {
                    $diff = $a->check_out->diff($a->check_in);
                    $duration = $diff->h . 'h ' . $diff->i . 'm';
                }

                $status = $a->check_in ? 'Hadir' : 'Absen';
                if ($a->check_in && $a->check_in->format('H:i') > '08:00') {
                    $status .= ' (Terlambat)';
                }

                fputcsv($file, [
                    $a->date->format('Y-m-d'),
                    $a->user->name,
                    $a->check_in ? $a->check_in->format('H:i:s') : '-',
                    $a->check_out ? $a->check_out->format('H:i:s') : '-',
                    $duration,
                    $a->location ?? '-',
                    $status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get monthly summary for all users
     */
    public function monthlySummary(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $roleFilter = $request->input('role', 'user');

        $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $stats = $this->calculateStatistics($startDate, $endDate, null, $roleFilter);
        $users = User::where('role', $roleFilter)->orderBy('name')->get();

        return view('admin.monthly-summary', compact('stats', 'month', 'users'));
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Allow explicit date range via env: SEED_START_DATE and SEED_END_DATE (YYYY-MM-DD)
        $startEnv = env('SEED_START_DATE');
        $endEnv = env('SEED_END_DATE');

        if ($startEnv && $endEnv) {
            $startDate = Carbon::parse($startEnv)->startOfDay();
            $endDate = Carbon::parse($endEnv)->startOfDay();
            if ($endDate->lt($startDate)) {
                // swap if reversed
                [$startDate, $endDate] = [$endDate, $startDate];
            }
            $dates = [];
            $current = $startDate->copy();
            while ($current->lte($endDate)) {
                $dates[] = $current->copy();
                $current->addDay();
            }
        } else {
            // Number of past days to seed (default 14)
            $days = (int) env('SEED_ATTENDANCE_DAYS', 14);
            $dates = [];
            for ($i = 0; $i < $days; $i++) {
                $dates[] = Carbon::today()->subDays($i);
            }
        }

        $users = User::where('role', 'user')->get();
        if ($users->isEmpty()) {
            $this->command->info('No users with role=user found. Skipping attendance seeding.');
            return;
        }

        foreach ($users as $user) {
            foreach ($dates as $date) {
                // simulate weekends as non-working (skip creating attendance)
                if ($date->isWeekend()) {
                    continue;
                }

                // Randomly decide if user is absent (10% chance)
                $isAbsent = rand(1, 100) <= 10;

                if ($isAbsent) {
                    Attendance::updateOrCreate(
                        ['user_id' => $user->id, 'date' => $date->toDateString()],
                        [
                            'check_in' => null,
                            'check_out' => null,
                            'note' => null,
                            'location' => null,
                            'photo' => null,
                        ]
                    );
                    continue;
                }

                // Generate check_in earlier in the morning (pagi)
                // range: 06:00 - 07:30
                $checkInHour = rand(6, 7);
                if ($checkInHour === 7) {
                    $checkInMinute = rand(0, 30);
                } else {
                    $checkInMinute = rand(0, 59);
                }
                $checkIn = Carbon::create($date->year, $date->month, $date->day, $checkInHour, $checkInMinute, 0);

                // Generate check_out in the afternoon (sore)
                // target range: 15:00 - 18:00
                $checkOutHour = rand(15, 18);
                $checkOutMinute = rand(0, 59);
                $checkOut = Carbon::create($date->year, $date->month, $date->day, $checkOutHour, $checkOutMinute, 0);

                // Ensure check_out is after check_in; if not, fallback to add 8 hours
                if ($checkOut->lte($checkIn)) {
                    $checkOut = (clone $checkIn)->addHours(8)->addMinutes(rand(0, 30));
                }

                $statusNote = $checkIn->format('H:i') > '08:00' ? 'Terlambat' : 'Tepat Waktu';

                Attendance::updateOrCreate(
                    ['user_id' => $user->id, 'date' => $date->toDateString()],
                    [
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                        'note' => $statusNote,
                        'location' => 'Kantor',
                        'photo' => null,
                    ]
                );
            }
        }

        $this->command->info('Attendance seeding complete.');
    }
}

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white">📊 Rekap Data Absensi</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Filter dan export laporan kehadiran tentara</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Filter Section -->
            <div class="filter-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">🔍 Filter Data</h3>
                
                <form method="GET" action="{{ route('admin.attendance-report') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <!-- Start Date -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">📅 Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-500 focus:outline-none">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">📅 Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-500 focus:outline-none">
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">👤 Tentara/Staf</label>
                        <select name="user_id" class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-500 focus:outline-none">
                            <option value="">-- Semua --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $userId == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div>
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-2 rounded-lg transition-all duration-300">
                            🔍 Filter
                        </button>
                    </div>

                    <!-- Export Button -->
                    <div>
                        <a href="{{ route('admin.attendance-export', request()->query()) }}" class="block text-center w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 rounded-lg transition-all duration-300">
                            📥 Export CSV
                        </a>
                    </div>
                </form>
            </div>

            <!-- Statistics Section -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                <!-- Total Users -->
                <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-blue-100 text-xs font-medium">Total Tentara</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_users'] }}</p>
                </div>

                <!-- Total Days -->
                <div class="stat-card bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-indigo-100 text-xs font-medium">Total Hari Kerja</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_days'] }}</p>
                </div>

                <!-- Total Present -->
                <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-green-100 text-xs font-medium">Total Hadir</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_present'] }}</p>
                </div>

                <!-- Total Late -->
                <div class="stat-card bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-yellow-100 text-xs font-medium">Terlambat</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_late'] }}</p>
                </div>

                <!-- Attendance Rate -->
                <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-purple-100 text-xs font-medium">Rata-rata Kehadiran</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['avg_attendance_rate'] }}%</p>
                </div>
            </div>

            <!-- Per User Summary Table -->
            @if($userId)
                <div class="user-summary bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">📈 Ringkasan Pengguna</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700 border-b-2 border-gray-200 dark:border-gray-600">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold text-gray-700 dark:text-gray-300">👤 Nama</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">✓ Hadir</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">✕ Absen</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">⏰ Terlambat</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">📊 Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['user_stats'] as $userStat)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $userStat['name'] }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full font-bold">
                                                {{ $userStat['present'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded-full font-bold">
                                                {{ $userStat['absent'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-full font-bold">
                                                {{ $userStat['late'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: {{ $userStat['percentage'] }}%"></div>
                                                </div>
                                                <span class="font-bold text-gray-900 dark:text-white">{{ $userStat['percentage'] }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="user-summary bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">📈 Ringkasan Per Tentara</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700 border-b-2 border-gray-200 dark:border-gray-600">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold text-gray-700 dark:text-gray-300">👤 Nama</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">✓ Hadir</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">✕ Absen</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">⏰ Terlambat</th>
                                    <th class="px-4 py-3 text-center font-bold text-gray-700 dark:text-gray-300">📊 Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['user_stats'] as $userStat)
                                    <tr class="history-item border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-4 py-3 font-semibold text-gray-900 dark:text-white">{{ $userStat['name'] }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full font-bold">
                                                {{ $userStat['present'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded-full font-bold">
                                                {{ $userStat['absent'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-full font-bold">
                                                {{ $userStat['late'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: {{ $userStat['percentage'] }}%"></div>
                                                </div>
                                                <span class="font-bold text-gray-900 dark:text-white">{{ $userStat['percentage'] }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Detailed Attendance Records -->
            <div class="attendance-records bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 text-white">
                    <h3 class="text-2xl font-bold">📋 Data Absensi Detail</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b-2 border-gray-200 dark:border-gray-600">
                            <tr class="text-left">
                                <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">📅 Tanggal</th>
                                <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">👤 Nama</th>
                                <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">⏰ jam masuk</th>
                                <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">🚪 jam keluar</th>
                                <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">⏱️ Durasi</th>
                                <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300"> ruangan</th>
                                <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $a)
                                <tr class="detail-row border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $a->date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $a->user->name }}</td>
                                    <td class="px-6 py-4">
                                        @if($a->check_in)
                                            <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm font-semibold">
                                                {{ $a->check_in->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($a->check_out)
                                            <span class="inline-block bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded-full text-sm font-semibold">
                                                {{ $a->check_out->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        @if($a->check_in && $a->check_out)
                                            @php
                                                $diff = $a->check_out->diff($a->check_in);
                                                $duration = $diff->h . 'h ' . $diff->i . 'm';
                                            @endphp
                                            {{ $duration }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $a->location ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if(!$a->check_in)
                                            <span class="inline-block bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded-full text-sm font-semibold">
                                                🔴 Absen
                                            </span>
                                        @elseif($a->check_in->format('H:i') > '08:00')
                                            <span class="inline-block bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-full text-sm font-semibold">
                                                🟡 Terlambat
                                            </span>
                                        @else
                                            <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm font-semibold">
                                                🟢 Tepat Waktu
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <p>Tidak ada data absensi</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate stat cards
        gsap.from(".stat-card", {
            duration: 0.6,
            y: 30,
            opacity: 0,
            stagger: 0.1,
            ease: "power3.out"
        });

        // Animate filter card
        gsap.from(".filter-card", {
            duration: 0.6,
            y: 30,
            opacity: 0,
            ease: "power2.out"
        });

        // Animate tables
        gsap.from(".user-summary, .attendance-records", {
            duration: 0.7,
            y: 40,
            opacity: 0,
            stagger: 0.2,
            ease: "power3.out",
            delay: 0.3
        });

        // Animate detail rows
        gsap.from(".detail-row, .history-item", {
            duration: 0.4,
            x: -20,
            opacity: 0,
            stagger: 0.03,
            ease: "power2.out",
            delay: 0.5
        });
    });
</script>
@endpush

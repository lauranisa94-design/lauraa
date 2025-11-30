<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white">📈 Ringkasan Bulanan</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Lihat ringkasan kehadiran per bulan untuk seluruh tentara/staf</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Month selector -->
            <div class="filter-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('admin.monthly-summary') }}" class="flex gap-4 items-end">
                    <div>
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">📅 Pilih Bulan</label>
                        <input type="month" name="month" value="{{ $month }}" class="px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">👥 Role</label>
                        <select name="role" class="px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-500 focus:outline-none">
                            <option value="user">User (Tentara/Staf)</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="bg-gradient-to-r from-purple-600 to-purple-700 text-white font-bold py-2 px-4 rounded-lg">Tampilkan</button>
                    </div>
                </form>
            </div>

            <!-- Statistics Section -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-blue-100 text-xs font-medium">Total Hari Kerja</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_days'] }}</p>
                </div>
                <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-green-100 text-xs font-medium">Total Hadir</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_present'] }}</p>
                </div>
                <div class="stat-card bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-red-100 text-xs font-medium">Total Absen</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_absent'] }}</p>
                </div>
                <div class="stat-card bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-yellow-100 text-xs font-medium">Terlambat</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_late'] }}</p>
                </div>
                <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-4 text-white">
                    <p class="text-purple-100 text-xs font-medium">Rata-rata Kehadiran</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['avg_attendance_rate'] }}%</p>
                </div>
            </div>

            <!-- Per-user summary -->
            <div class="user-summary bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">📋 Ringkasan Per Pengguna</h3>
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
                                        <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full font-bold">{{ $userStat['present'] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded-full font-bold">{{ $userStat['absent'] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-full font-bold">{{ $userStat['late'] }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <div class="w-24 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
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
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        gsap.from('.stat-card', { duration: 0.6, y: 30, opacity: 0, stagger: 0.1, ease: 'power3.out' });
        gsap.from('.filter-card, .user-summary', { duration: 0.6, y: 30, opacity: 0, ease: 'power2.out' });
    });
</script>
@endpush

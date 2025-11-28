<div class="history-container bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 text-white">
        <h3 class="text-2xl font-bold">📅 Riwayat Absensi</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700 border-b-2 border-gray-200 dark:border-gray-600">
                <tr class="text-left">
                    <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">📅 Tanggal</th>
                    <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">📝 keterangan</th>
                    <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">🏢 Ruangan</th>
                    <th class="px-6 py-4 font-bold text-gray-700 dark:text-gray-300">📸 Foto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $a)
                    <tr class="history-item border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $a->date->format('d M Y') }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 block">{{ $a->date->format('l') }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                            {{ $a->note ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                            {{ $a->location ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($a->photo)
                                <img src="{{ asset('storage/' . $a->photo) }}"
                                     class="w-12 h-12 object-cover rounded-lg cursor-pointer hover:scale-110 transition-transform"
                                     alt="photo"
                                     onclick="this.classList.toggle('w-96'); this.classList.toggle('h-auto')">
                            @else
                                <span class="text-gray-500 dark:text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="text-3xl mb-2">📋</div>
                            <p>Belum ada data absensi</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
        {{ $attendances->links() }}
    </div>
</div>

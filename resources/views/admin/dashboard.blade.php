<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white">Admin Dashboard</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola dan monitor sistem absensi</p>
            </div>
            <div class="text-right">
                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                    🟢 Sistem Online
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- KPI Cards Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Users Card -->
                <div class="kpi-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative z-10">
                        <p class="text-blue-100 text-sm font-medium">Total Users</p>
                        <p class="text-4xl font-bold mt-3">{{ $totalUsers }}</p>
                        <p class="text-blue-100 text-xs mt-2">✓ Aktif hari ini</p>
                    </div>
                    <div class="text-6xl opacity-20 absolute bottom-2 right-4">👥</div>
                </div>

                <!-- Today Checks Card -->
                <div class="kpi-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative z-10">
                        <p class="text-green-100 text-sm font-medium">yang absen Hari Ini</p>
                        <p class="text-4xl font-bold mt-3">{{ $todayChecks }}</p>
                        <p class="text-green-100 text-xs mt-2">✓ Tepat waktu</p>
                    </div>
                    <div class="text-6xl opacity-20 absolute bottom-2 right-4">✓</div>
                </div>

                <!-- Attendance Rate Card -->
                <div class="kpi-card bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative z-10">
                        <p class="text-green-100 text-sm font-medium">Tingkat Kehadiran</p>
                        <p class="text-4xl font-bold mt-3">92%</p>
                        <div class="w-full bg-green-400 rounded-full h-2 mt-3">
                            <div class="bg-white h-2 rounded-full" style="width: 92%"></div>
                        </div>
                    </div>
                    <div class="text-6xl opacity-20 absolute bottom-2 right-4">📊</div>
                </div>

                <!-- Pending Approvals Card -->
                <div class="kpi-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative z-10">
                        <p class="text-orange-100 text-sm font-medium">Perlu Review</p>
                        <p class="text-4xl font-bold mt-3">3</p>
                        <p class="text-orange-100 text-xs mt-2">⚠️ Tunggu konfirmasi</p>
                    </div>
                    <div class="text-6xl opacity-20 absolute bottom-2 right-4">⏳</div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Recent Attendance List -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
                        <a href="#" class="text-green-600 hover:text-green-700 font-semibold text-sm">Lihat Semua →</a>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse($recent as $r)
                            <div class="activity-item flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-all cursor-pointer">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-100 dark:bg-green-900">
                                        <span class="text-lg">✓</span>
                                    </div>
                                </div>
                                <div class="flex-1 ml-4">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $r->user->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $r->date->format('d M Y') }} • {{ $r->check_in ? $r->check_in->format('H:i') : '-' }}</p>
                                </div>
                                <div class="text-right">
                                    @if($r->check_in)
                                        <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-xs font-semibold">
                                            Masuk
                                        </span>
                                    @else
                                        <span class="inline-block bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-1 rounded-full text-xs font-semibold">
                                            Belum
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <p>Belum ada data absensi</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="space-y-4">
                    <!-- Action Buttons -->
                    <div class="space-y-2">
                        <a href="{{ route('admin.attendance-report') }}" class="action-btn block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-3 px-4 rounded-lg text-center transition-all duration-300">
                            📊 Rekap Data Absensi
                        </a>
                        <a href="{{ route('admin.monthly-summary') }}" class="action-btn block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-4 rounded-lg text-center transition-all duration-300">
                            📈 Ringkasan Bulanan
                        </a>
                    </div>

                    <!-- Top Performer -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                        <h4 class="font-bold text-gray-900 dark:text-white mb-4">⭐ Top Performer</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Andi Wijaya</span>
                                <span class="text-sm font-semibold text-green-600">25/25</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Siti Nurhaliza</span>
                                <span class="text-sm font-semibold text-green-600">24/25</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Bambang Suryanto</span>
                                <span class="text-sm font-semibold text-yellow-600">23/25</span>
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                        <h4 class="font-bold text-gray-900 dark:text-white mb-4">🔧 Status Sistem</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-700 dark:text-gray-300">Database</span>
                                <span class="text-green-600 font-semibold">✓ Online</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700 dark:text-gray-300">Storage</span>
                                <span class="text-green-600 font-semibold">✓ Online</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700 dark:text-gray-300">API</span>
                                <span class="text-green-600 font-semibold">✓ Online</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GSAP Animation Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
        // Animate KPI cards
        gsap.from(".kpi-card", {
            duration: 0.8,
            y: 40,
            opacity: 0,
            stagger: 0.12,
            ease: "power3.out"
        });

        // Animate activity items
        gsap.from(".activity-item", {
            duration: 0.6,
            x: -30,
            opacity: 0,
            stagger: 0.08,
            ease: "power2.out",
            delay: 0.4
        });

        // KPI Card hover effect
        document.querySelectorAll(".kpi-card").forEach(card => {
            card.addEventListener("mouseenter", function() {
                gsap.to(this, {
                    duration: 0.3,
                    y: -15,
                    boxShadow: "0 25px 50px rgba(0,0,0,0.2)",
                    ease: "power2.out"
                });
            });
            
            card.addEventListener("mouseleave", function() {
                gsap.to(this, {
                    duration: 0.3,
                    y: 0,
                    boxShadow: "0 10px 25px rgba(0,0,0,0.1)",
                    ease: "power2.out"
                });
            });
        });

        // Activity item hover effect
        document.querySelectorAll(".activity-item").forEach(item => {
            item.addEventListener("mouseenter", function() {
                gsap.to(this, {
                    duration: 0.2,
                    x: 10,
                    ease: "power2.out"
                });
            });
            
            item.addEventListener("mouseleave", function() {
                gsap.to(this, {
                    duration: 0.2,
                    x: 0,
                    ease: "power2.out"
                });
            });
        });

        // Action button animations
        document.querySelectorAll(".action-btn").forEach(btn => {
            btn.addEventListener("mouseenter", function() {
                gsap.to(this, {
                    duration: 0.3,
                    y: -5,
                    boxShadow: "0 20px 40px rgba(0,0,0,0.2)",
                    ease: "power2.out"
                });
            });
            
            btn.addEventListener("mouseleave", function() {
                gsap.to(this, {
                    duration: 0.3,
                    y: 0,
                    boxShadow: "0 10px 20px rgba(0,0,0,0.1)",
                    ease: "power2.out"
                });
            });
        });

        // Counter animation for numbers
        function animateCounter(element, target) {
            const current = parseInt(element.textContent);
            const increment = Math.ceil((target - current) / 20);
            
            let count = current;
            const timer = setInterval(() => {
                count += increment;
                if (count >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = count;
                }
            }, 50);
        }
    </script>
</x-app-layout>

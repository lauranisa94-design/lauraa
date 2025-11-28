<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white">Dashboard</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Card -->
            <div class="mb-8 dashboard-card">
                <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-lg p-8 text-white overflow-hidden relative">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-5 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <h1 class="text-4xl font-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h1>
                        <p class="text-green-100 text-lg">Anda siap untuk mulai kerja hari ini?</p>
                        <div class="mt-6 flex gap-4">
                            <a href="{{ route('attendance.index') }}" class="inline-block bg-white text-green-600 font-semibold px-6 py-3 rounded-lg hover:shadow-lg transition-all duration-300 hover:scale-105">
                                ✓ Mulai Absensi
                            </a>
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="inline-block bg-green-500 text-white font-semibold px-6 py-3 rounded-lg hover:bg-green-600 transition-all duration-300 hover:scale-105">
                                    ⚙️ Admin Panel
                                </a>
                            @endif
                        </div>
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
        // Animate dashboard cards on load
        gsap.registerPlugin(ScrollTrigger);
        
        // Welcome card animation
        gsap.from(".dashboard-card", {
            duration: 0.8,
            y: 30,
            opacity: 0,
            ease: "power3.out"
        });

        // Stat cards staggered animation
        gsap.from(".stat-card", {
            duration: 0.8,
            y: 40,
            opacity: 0,
            stagger: 0.15,
            ease: "power3.out",
            delay: 0.2
        });

        // Activity items animation
        gsap.from(".activity-item", {
            duration: 0.6,
            x: -30,
            opacity: 0,
            stagger: 0.1,
            ease: "power2.out",
            delay: 0.5
        });

        // Hover animation for stat cards
        document.querySelectorAll(".stat-card").forEach(card => {
            card.addEventListener("mouseenter", function() {
                gsap.to(this, {
                    duration: 0.3,
                    y: -10,
                    boxShadow: "0 20px 40px rgba(0,0,0,0.15)",
                    ease: "power2.out"
                });
            });
            
            card.addEventListener("mouseleave", function() {
                gsap.to(this, {
                    duration: 0.3,
                    y: 0,
                    boxShadow: "0 10px 25px rgba(0,0,0,0.08)",
                    ease: "power2.out"
                });
            });
        });

        // Clock animation
        function updateTime() {
            const timeElement = document.querySelector('[class*="text-lg"]');
            if (timeElement && timeElement.textContent.includes(':')) {
                gsap.to(timeElement, {
                    duration: 0.5,
                    opacity: 0.6,
                    repeat: 1,
                    yoyo: true,
                    ease: "power1.inOut"
                });
            }
        }
        setInterval(updateTime, 1000);
    </script>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .dashboard-card {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</x-app-layout>

<x-guest-layout>
<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-900 via-green-900 to-gray-900 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-green-500 to-emerald-600 opacity-20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-green-600 to-teal-500 opacity-20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="relative z-10 w-full max-w-md px-6">
        <!-- Header with Military Theme -->
        <div class="text-center mb-8">
            <div class="inline-block bg-gradient-to-r from-green-500 to-emerald-600 p-4 rounded-full mb-4 shadow-2xl transform hover:scale-110 transition">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">🎖️ KODIM Absensi</h1>
            <p class="text-green-200 text-lg">Sistem Manajemen Kehadiran Tentara</p>
        </div>

        <!-- Status Message -->
        @if (session('status'))
            <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-md">
                <p class="text-green-700 font-semibold text-sm">✓ {{ session('status') }}</p>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-lg shadow-md">
                <div class="flex items-start">
                    <span class="text-2xl mr-3">❌</span>
                    <div>
                        <p class="text-red-700 font-bold mb-2">Login Gagal!</p>
                        <ul class="list-disc list-inside space-y-1 text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Card -->
        <div class="login-card bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 backdrop-blur-md bg-opacity-95 max-h-[calc(100vh-200px)] overflow-y-auto">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email" class="block text-sm font-bold text-gray-900 dark:text-white mb-2 uppercase tracking-wider">
                        📧 Email Address
                    </label>
                    <input 
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="form-input w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 transition-all @error('email') border-red-500 @enderror"
                        placeholder="nama@email.com"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="block text-sm font-bold text-gray-900 dark:text-white mb-2 uppercase tracking-wider">
                        🔐 Password
                    </label>
                    <input 
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="form-input w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 transition-all @error('password') border-red-500 @enderror"
                        placeholder="••••••••"
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
                        />
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Ingat saya</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-semibold text-green-600 dark:text-green-400 hover:text-green-700 transition">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="submit-btn w-full py-3 px-4 rounded-lg bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white font-bold text-base uppercase tracking-wider shadow-lg hover:shadow-2xl transition-all duration-300 mt-6"
                >
                    ✓ Masuk Sekarang
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-semibold">atau</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center pt-4">
                    <p class="text-gray-700 dark:text-gray-300">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-bold text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition">
                            Daftar di sini →
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-green-200 text-xs">
                © 2025 KODIM Absensi System. Sistem Informasi Manajemen Kehadiran.
            </p>
        </div>
    </div>
</div>

<!-- GSAP Animations -->
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Card entrance animation
        gsap.from(".login-card", {
            duration: 0.8,
            y: 40,
            opacity: 0,
            ease: "power3.out"
        });

        // Form group animations
        gsap.from(".form-group", {
            duration: 0.6,
            y: 20,
            opacity: 0,
            stagger: 0.1,
            ease: "power2.out",
            delay: 0.2
        });

        // Submit button animation
        const submitBtn = document.querySelector(".submit-btn");
        if (submitBtn) {
            submitBtn.addEventListener("mouseenter", function() {
                gsap.to(this, {
                    duration: 0.3,
                    y: -3,
                    ease: "power2.out"
                });
            });

            submitBtn.addEventListener("mouseleave", function() {
                gsap.to(this, {
                    duration: 0.3,
                    y: 0,
                    ease: "power2.out"
                });
            });
        }

        // Input focus glow
        document.querySelectorAll(".form-input").forEach(input => {
            input.addEventListener("focus", function() {
                gsap.to(this, {
                    duration: 0.3,
                    boxShadow: "0 0 0 3px rgba(34, 197, 94, 0.1)",
                    ease: "power2.out"
                });
            });

            input.addEventListener("blur", function() {
                gsap.to(this, {
                    duration: 0.3,
                    boxShadow: "none",
                    ease: "power2.out"
                });
            });
        });
    });
</script>
@endpush
</x-guest-layout>
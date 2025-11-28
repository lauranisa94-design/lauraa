<x-guest-layout>

<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-900 via-green-900 to-gray-900 relative overflow-hidden">

    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-green-500 to-emerald-600 opacity-20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-green-600 to-teal-500 opacity-20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="relative z-10 w-full max-w-md px-6">

        <!-- Status -->
        @if (session('status'))
            <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-md">
                <p class="text-green-700 font-semibold text-sm">✓ {{ session('status') }}</p>
            </div>
        @endif

        <!-- Error -->
        @if ($errors->any())
            <div class="error-alert mb-6 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900 dark:to-rose-900 border-l-4 border-red-500 p-4 rounded-xl shadow-md">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h3 class="text-red-700 dark:text-red-200 font-bold mb-1">❌ Pendaftaran Gagal!</h3>
                        <ul class="list-disc list-inside space-y-0.5 text-red-600 dark:text-red-300 text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="register-header text-center mb-6">
            <div class="inline-block bg-gradient-to-br from-green-600 to-emerald-700 p-3 rounded-full mb-4 shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 
                          11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-1">Buat Akun Baru</h1>
            <p class="text-green-200">Bergabunglah dengan sistem kami</p>
        </div>

        <!-- Form Card -->
        <div class="register-card bg-white dark:bg-gray-700 rounded-2xl shadow-2xl p-8 backdrop-blur-md bg-opacity-95 max-h-[calc(100vh-200px)] overflow-y-auto">

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="block text-sm font-bold text-gray-900 dark:text-white mb-2 uppercase tracking-wider">
                        👤 Nama Lengkap
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="form-input w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 
                               dark:text-white rounded-lg focus:border-green-500 focus:outline-none 
                               focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 transition-all 
                               @error('name') border-red-500 @enderror"
                        placeholder="Masukkan nama lengkap" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="block text-sm font-bold text-gray-900 dark:text-white mb-2 uppercase tracking-wider">
                        📧 Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="form-input w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 
                               dark:bg-gray-700 dark:text-white rounded-lg focus:border-green-500 
                               focus:outline-none focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 
                               transition-all @error('email') border-red-500 @enderror"
                        placeholder="nama@email.com" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="block text-sm font-bold text-gray-900 dark:text-white mb-2 uppercase tracking-wider">
                        🔐 Password
                    </label>
                    <input id="password" type="password" name="password" required
                        class="form-input w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 
                               dark:bg-gray-700 dark:text-white rounded-lg focus:border-green-500 
                               focus:outline-none focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 
                               transition-all @error('password') border-red-500 @enderror"
                        placeholder="Minimal 8 karakter" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm -->
                <div class="form-group">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-900 dark:text-white mb-2 uppercase tracking-wider">
                        ✓ Konfirmasi
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="form-input w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 
                               dark:bg-gray-700 dark:text-white rounded-lg focus:border-green-500 
                               focus:outline-none focus:ring-2 focus:ring-green-200 dark:focus:ring-green-800 
                               transition-all"
                        placeholder="Ulangi password" />
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="submit-btn w-full py-3 px-4 rounded-lg bg-gradient-to-r from-green-600 to-emerald-700 
                           hover:from-green-700 hover:to-emerald-800 text-white font-bold text-base uppercase 
                           tracking-wider shadow-lg hover:shadow-2xl transition-all duration-300 mt-4">
                    ✓ Daftar Sekarang
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-semibold">
                            atau
                        </span>
                    </div>
                </div>

                <!-- Login -->
                <div class="text-center pt-4">
                    <p class="text-gray-700 dark:text-gray-300">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-green-600 dark:text-green-400 hover:text-green-700">
                            Masuk →
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <div class="text-center mt-8">
            <p class="text-green-200 text-xs">© 2025 KODIM Absensi System. Sistem Informasi Manajemen Kehadiran.</p>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    gsap.from(".register-header", { duration: 0.8, opacity: 0, y: -30, ease: "power3.out" });
    gsap.from(".register-card", { duration: 0.8, y: 30, opacity: 0, ease: "power3.out", delay: 0.15 });
    gsap.from(".form-group", { duration: 0.5, y: 20, opacity: 0, stagger: 0.08, ease: "power2.out", delay: 0.3 });

    document.querySelectorAll(".form-input").forEach(input => {
        input.addEventListener("focus", () => gsap.to(input, { duration: 0.3, boxShadow: "0 0 0 3px rgba(34,197,94,0.2)" }));
        input.addEventListener("blur", () => gsap.to(input, { duration: 0.3, boxShadow: "none" }));
    });
});
</script>
@endpush

</x-guest-layout>

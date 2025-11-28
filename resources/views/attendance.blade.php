<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white">Sistem Absensi</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Kehadiran</p>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-black font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                    🚪 Keluar
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert-message mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">✓</span>
                        <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="alert-message mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">✕</span>
                        <p class="text-red-700 font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Check-in Section -->
                <div class="lg:col-span-2">
                    <div class="camera-container bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-green-600 to-emerald-700 p-6 text-white">
                            <h3 class="text-2xl font-bold">📸 Ambil Foto Absensi</h3>
                            <p class="text-purple-100 mt-1">Pastikan pencahayaan cukup dan posisi wajah jelas</p>
                        </div>
                        <div class="p-6">
                            <form id="checkin-form" method="POST" action="{{ route('attendance.checkin') }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">📸 Upload Foto</label>
                                    <div class="relative">
                                        <input 
                                            type="file" 
                                            id="photo-input" 
                                            name="photo" 
                                            accept="image/*" 
                                            required
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700 cursor-pointer"
                                        />
                                        <small class="text-gray-500 dark:text-gray-400 block mt-1">Format: JPG, PNG | Max: 5MB</small>
                                    </div>
                                    <div id="preview" class="mt-4 rounded-lg overflow-hidden border-2 border-green-300 hidden" style="max-height: 300px;">
                                        <img id="preview-img" class="w-full h-full object-cover" alt="preview">
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">📝 keterangan</label>
                                    <input 
                                        type="text"
                                        id="location" 
                                        name="location" 
                                        placeholder="" 
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-green-500 focus:outline-none transition-colors" 
                                    />
                                </div>
                                <div>
                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 block mb-2">🏢 Ruangan</label>
                                    <textarea 
                                        name="note" 
                                        placeholder="" 
                                        class="w-full px-4 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-green-500 focus:outline-none transition-colors" 
                                        rows="2"
                                    ></textarea>
                                </div>
                                <button 
                                    id="checkin-btn"
                                    type="submit" 
                                    class="checkin-btn w-full bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white font-bold py-3 rounded-lg shadow-lg transition-all duration-300"
                                >
                                    ✓ Selesai Absensi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Check-out and Status -->
                <div class="space-y-4">
                    <!-- Check Out Form -->
                    <form method="POST" action="{{ route('attendance.checkout') }}">
                        @csrf
                        <button class="checkout-btn w-full bg-gradient-to-br from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all duration-300 text-lg">
                            🚪 Akhiri
                        </button>
                    </form>
                    <!-- Tips Card -->
                    <div class="tips-card bg-gradient-to-br from-yellow-50 to-amber-50 dark:from-yellow-900 dark:to-amber-900 rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500">
                        <h4 class="font-bold text-yellow-900 dark:text-yellow-100 mb-3">💡 Saran Untuk Foto</h4>
                        <ul class="text-xs text-yellow-800 dark:text-yellow-200 space-y-2">
                            <li>✓ Pastikan cahaya cukup</li>
                            <li>✓ Wajah terlihat jelas</li>
                            <li>✓ Tidak ada bayang-bayang</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- History Section -->
            <x-attendance-history :attendances="$attendances" />
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('🚀 Attendance page loaded - SIMPLIFIED VERSION');
    
    const photoInput = document.getElementById('photo-input');
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('preview-img');
    const checkinForm = document.getElementById('checkin-form');
    const checkinBtn = document.getElementById('checkin-btn');

    photoInput.addEventListener('change', function() {
        console.log('📁 File selected:', this.files[0]?.name);

        if (!this.files || this.files.length === 0) {
            console.log('❌ No file selected');
            return;
        }

        const file = this.files[0];
        console.log('📊 File info:', {
            name: file.name,
            size: file.size,
            type: file.type
        });

        if (file.size > 5 * 1024 * 1024) {
            alert('❌ Ukuran file terlalu besar. Max 5MB');
            this.value = '';
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('❌ File harus berupa gambar (JPG, PNG, dll)');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            console.log('✅ Preview ready');
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');

            gsap.from(previewImg, {
                duration: 0.4,
                scale: 0.8,
                opacity: 0,
                ease: "back.out"
            });

            checkinBtn.disabled = false;
            gsap.to(checkinBtn, {
                duration: 0.3,
                opacity: 1,
                scale: 1.05,
                ease: "elastic.out(1, 0.5)"
            });
        };
        reader.onerror = function() {
            alert('❌ Error membaca file');
            console.error('FileReader error');
        };
        reader.readAsDataURL(file);
    });

    checkinForm.addEventListener('submit', function(e) {
        console.log('📤 Form submitting...');
        
        if (!photoInput.files || photoInput.files.length === 0) {
            e.preventDefault();
            alert('❌ Silakan pilih foto terlebih dahulu');
            console.error('No photo selected');
            return;
        }

        console.log('✓ Form valid, submitting...');
        
        gsap.to(checkinBtn, {
            duration: 0.2,
            opacity: 0.7,
            scale: 0.95
        });
    });

    gsap.from(".camera-container", {
        duration: 0.8,
        y: 40,
        opacity: 0,
        ease: "power3.out"
    });

    gsap.from(".history-container", {
        duration: 0.8,
        y: 40,
        opacity: 0,
        ease: "power3.out",
        delay: 0.2
    });

    gsap.from(".status-card, .tips-card", {
        duration: 0.6,
        x: 40,
        opacity: 0,
        stagger: 0.1,
        ease: "power2.out"
    });

    gsap.from(".history-item", {
        duration: 0.4,
        y: 20,
        opacity: 0,
        stagger: 0.05,
        ease: "power2.out",
        delay: 0.4
    });

    checkinBtn.addEventListener("mouseenter", function() {
        gsap.to(this, {
            duration: 0.3,
            y: -5,
            boxShadow: "0 20px 40px rgba(0,0,0,0.2)",
            ease: "power2.out"
        });
    });

    checkinBtn.addEventListener("mouseleave", function() {
        gsap.to(this, {
            duration: 0.3,
            y: 0,
            boxShadow: "0 10px 20px rgba(0,0,0,0.1)",
            ease: "power2.out"
        });
    });

    console.log('✓ Script ready - file input active');
});
</script>
@endpush

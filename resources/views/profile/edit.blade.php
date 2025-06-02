<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        /* Kelas delay animasi (tambahkan lebih banyak jika perlu) */
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animation-delay-200 { animation-delay: 0.2s; opacity: 0; }
        .animation-delay-300 { animation-delay: 0.3s; opacity: 0; }

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            {{-- Panel Informasi Profil --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp">
                <div class="max-w-xl">
                    {{-- Konten dari profile.partials.update-profile-information-form akan menggunakan styling yang telah disarankan untuk komponennya dan struktur internalnya (lihat respons sebelumnya untuk detail bagian ini jika perlu) --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Panel Ubah Kata Sandi --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp animation-delay-100" style="opacity:0;">
                <div class="max-w-xl">
                    {{-- PANDUAN STYLING UNTUK update-password-form.blade.php ADA DI BAWAH --}}
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Panel Hapus Akun --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-red-950/40 sm:rounded-xl dark:border dark:border-red-700/30 animate-fadeInUp animation-delay-200" style="opacity:0;">
                <div class="max-w-xl">
                    {{-- PANDUAN STYLING UNTUK delete-user-form.blade.php ADA DI BAWAH --}}
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        /* Variasi delay animasi (tambahkan sesuai kebutuhan) */
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animation-delay-200 { animation-delay: 0.2s; opacity: 0; }
        .animation-delay-300 { animation-delay: 0.3s; opacity: 0; }
        .animation-delay-400 { animation-delay: 0.4s; opacity: 0; } /* Untuk panel welcome */

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

        /* Tambahan untuk efek hover pada kartu statistik */
        .stat-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 0 30px rgba(14, 165, 233, 0.3); /* Bayangan standar + glow biru */
        }
        .dark .stat-card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4), 0 0 40px rgba(56, 189, 248, 0.4); /* Bayangan lebih gelap + glow biru lebih intens */
        }

    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-10">

                {{-- Kartu Jumlah Users --}}
                <div class="stat-card p-6 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-sky-700/40 transition-all duration-300 ease-out animate-fadeInUp" style="opacity:0;">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-sky-200">Jumlah Users</h3>
                        {{-- Opsional: Ikon bisa ditambahkan di sini --}}
                        {{-- <svg class="w-8 h-8 text-sky-500" ...></svg> --}}
                    </div>
                    <p class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-blue-500 to-indigo-500 dark:from-sky-300 dark:via-blue-400 dark:to-indigo-400">
                        {{ $usersCount ?? '0' }}
                    </p>
                </div>

                {{-- Kartu Pending Approvals --}}
                <div class="stat-card p-6 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-sky-700/40 transition-all duration-300 ease-out animate-fadeInUp animation-delay-100" style="opacity:0;">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-sky-200">Pending Approvals</h3>
                    </div>
                    <p class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-orange-500 to-red-500 dark:from-amber-300 dark:via-orange-400 dark:to-red-400">
                        {{ $pendingApprovals ?? '0' }}
                    </p>
                </div>

                {{-- Kartu Total Cobit Items --}}
                <div class="stat-card p-6 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-sky-700/40 transition-all duration-300 ease-out animate-fadeInUp animation-delay-200" style="opacity:0;">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-sky-200">Total Cobit Items</h3>
                    </div>
                    <p class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 via-emerald-500 to-green-500 dark:from-teal-300 dark:via-emerald-400 dark:to-green-400">
                        {{ $cobitItemsCount ?? '0' }}
                    </p>
                </div>

            </div>

            {{-- Panel Selamat Datang --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp animation-delay-300" style="opacity:0;">
                <h3 class="mb-4 text-2xl font-bold text-gray-800 dark:text-sky-300">Welcome, Admin!</h3>
                <p class="text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                    Ini adalah dashboard admin Anda. Di sini Anda dapat mengelola pengguna, item Cobit, kategori, level, dan kuesioner. Jelajahi berbagai menu untuk memulai.
                </p>
                {{-- Opsional: Tambahkan tombol aksi atau link di sini --}}
                {{--
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-lg shadow-md hover:shadow-lg hover:shadow-sky-500/40 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-slate-800 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                        Lihat Daftar User
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
                --}}
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight tracking-wide text-gray-700 dark:text-sky-300 animate-fadeInDown">
            {{ __('Progres Kuesioner Saya') }}
        </h2>
    </x-slot>

    {{-- CSS sebaiknya dipindahkan ke file app.css utama Anda --}}
    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInDown {
            animation: fadeInDown 0.6s ease-out forwards;
        }

        .animate-fadeInUp {
            opacity: 0;
            /* Mulai dari transparan untuk animasi */
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Kelas utilitas untuk delay animasi */
        .animation-delay-100 {
            animation-delay: 0.1s;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        .animation-delay-500 {
            animation-delay: 0.5s;
        }

        /* Animasi untuk progress bar */
        .progress-bar-animated>div {
            position: relative;
            overflow: hidden;
        }

        .progress-bar-animated>div::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-image: linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
            background-size: 40px 40px;
            animation: progress-bar-stripes 1s linear infinite;
            z-index: 1;
        }

        @keyframes progress-bar-stripes {
            from {
                background-position: 40px 0;
            }

            to {
                background-position: 0 0;
            }
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div
                class="overflow-hidden bg-white shadow-xl dark:bg-slate-800/70 dark:backdrop-blur-md dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30">
                <div class="p-6 text-gray-900 sm:p-8 dark:text-gray-100 animate-fadeInDown">

                    {{-- Bagian Header Halaman dengan Tombol Download --}}
                    <div class="flex flex-col items-start justify-between mb-10 sm:flex-row sm:items-center">
                        <div>
                            <h3 class="mb-2 text-3xl font-bold text-gray-800 dark:text-sky-200">Halo,
                                {{ $user->name }}!</h3>
                            <p class="text-gray-600 dark:text-gray-300">Berikut adalah ringkasan progres pengerjaan
                                kuesioner Anda.</p>
                        </div>


                        <a href="{{ route('user.progress.download') }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 mt-4 text-sm font-semibold text-white transition-colors duration-300 rounded-lg shadow-md sm:mt-0 bg-sky-600 hover:bg-sky-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download Laporan (PDF)
                        </a>
                        {{-- ▲▲▲ AKHIR DARI TOMBOL DOWNLOAD PDF ▲▲▲ --}}

                    </div>

                    {{-- Konten Utama Progres --}}
                    @if (empty($progressData))
                        <div class="py-12 text-lg text-center text-slate-500 dark:text-slate-400 animate-fadeInUp">
                            Belum ada data progres yang tersedia atau belum ada Cobit Item yang bisa ditampilkan.
                        </div>
                    @else
                        <div class="space-y-10">
                            {{-- Perulangan untuk setiap Cobit Item --}}
                            @foreach ($progressData as $itemIndex => $cobitItem)
                                @php
                                    $itemDelayClass = 'animation-delay-' . (($itemIndex % 5) + 1) . '00';
                                @endphp
                                <div
                                    class="p-5 bg-white shadow-lg sm:p-6 dark:bg-slate-700/40 dark:border dark:border-slate-600/60 rounded-xl animate-fadeInUp {{ $itemDelayClass }}">

                                    {{-- Header per Cobit Item --}}
                                    <div
                                        class="flex flex-col items-start justify-between mb-4 sm:flex-row sm:items-center">
                                        <h4 class="mb-2 text-2xl font-bold text-sky-600 dark:text-sky-300 sm:mb-0">
                                            {{ $cobitItem['nama_item'] }}</h4>
                                        @if ($cobitItem['total_levels_in_item'] > 0)
                                            @php
                                                $itemPercentage =
                                                    ($cobitItem['completed_levels_in_item'] /
                                                        $cobitItem['total_levels_in_item']) *
                                                    100;
                                            @endphp
                                            <span
                                                class="text-sm font-semibold py-1 px-3 rounded-full {{ $itemPercentage == 100 ? 'bg-emerald-100 dark:bg-emerald-500/30 text-emerald-600 dark:text-emerald-300' : 'bg-amber-100 dark:bg-amber-500/30 text-amber-600 dark:text-amber-300' }}">
                                                {{ round($itemPercentage) }}% Selesai
                                                <span
                                                    class="hidden sm:inline">({{ $cobitItem['completed_levels_in_item'] }}
                                                    / {{ $cobitItem['total_levels_in_item'] }} Level)</span>
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Daftar Kategori --}}
                                    @forelse ($cobitItem['kategoris'] as $kategori)
                                        <div
                                            class="mb-6 ml-0 sm:ml-4 pl-4 py-4 border-l-4 rounded-r-lg dark:bg-slate-700/20 {{ $kategori['completed_levels_in_kategori'] == $kategori['total_levels_in_kategori'] && $kategori['total_levels_in_kategori'] > 0 ? 'border-emerald-500 dark:border-emerald-400' : 'border-sky-500 dark:border-sky-400' }}">
                                            <div
                                                class="flex flex-col items-start justify-between mb-3 sm:flex-row sm:items-center">
                                                <h5
                                                    class="mb-1 text-xl font-semibold text-gray-800 dark:text-gray-100 sm:mb-0">
                                                    {{ $kategori['nama_kategori'] }}</h5>
                                                @if ($kategori['total_levels_in_kategori'] > 0)
                                                    @php
                                                        $kategoriPercentage =
                                                            ($kategori['completed_levels_in_kategori'] /
                                                                $kategori['total_levels_in_kategori']) *
                                                            100;
                                                    @endphp
                                                    <span
                                                        class="text-xs font-medium py-0.5 px-2.5 rounded-full {{ $kategoriPercentage == 100 ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400' }}">
                                                        {{ round($kategoriPercentage) }}% Selesai
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Daftar Level dengan Progress Bar --}}
                                            <ul class="mt-2 space-y-4">
                                                @forelse ($kategori['levels'] as $level)
                                                    <li
                                                        class="p-3 transition-shadow duration-300 bg-white rounded-lg shadow-sm sm:p-4 dark:bg-slate-600/30 hover:shadow-md">
                                                        <div
                                                            class="w-full h-3.5 bg-gray-200 dark:bg-slate-700 rounded-full relative overflow-hidden progress-bar-animated">
                                                            <div class="h-3.5 rounded-full transition-all duration-500 ease-out {{ $level['percentage'] == 100 ? 'bg-gradient-to-r from-emerald-500 to-green-400' : 'bg-gradient-to-r from-sky-500 to-blue-500' }}"
                                                                style="width: {{ $level['percentage'] }}%"></div>
                                                        </div>
                                                        <div class="flex items-center justify-between mt-1.5">
                                                            <span
                                                                class="text-xs text-gray-500 dark:text-gray-400">{{ $level['nama_level'] }}</span>
                                                            <p
                                                                class="text-sm font-semibold text-gray-700 dark:text-sky-200">
                                                                {{ $level['percentage'] }}%</p>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <p class="pl-1 text-xs text-gray-500 dark:text-gray-400">Tidak ada
                                                        level dalam kategori ini.</p>
                                                @endforelse
                                            </ul>
                                        </div>
                                    @empty
                                        <p class="pl-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada kategori
                                            dalam item ini.</p>
                                    @endforelse
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Progres Kuesioner Saya') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        /* Variasi delay animasi, tambahkan sesuai kebutuhan */
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animation-delay-200 { animation-delay: 0.2s; opacity: 0; }
        .animation-delay-300 { animation-delay: 0.3s; opacity: 0; }
        .animation-delay-400 { animation-delay: 0.4s; opacity: 0; }
        .animation-delay-500 { animation-delay: 0.5s; opacity: 0; }

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

        /* Animasi untuk progress bar (efek kilau halus) */
        .progress-bar-animated > div {
            position: relative;
            overflow: hidden; /* Penting untuk pseudo-element */
        }
        .progress-bar-animated > div::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-image: linear-gradient(
                -45deg,
                rgba(255, 255, 255, 0.15) 25%,
                transparent 25%,
                transparent 50%,
                rgba(255, 255, 255, 0.15) 50%,
                rgba(255, 255, 255, 0.15) 75%,
                transparent 75%,
                transparent
            );
            background-size: 40px 40px; /* Ukuran pola garis */
            animation: progress-bar-stripes 1s linear infinite;
            z-index: 1;
        }
        @keyframes progress-bar-stripes {
            from { background-position: 40px 0; }
            to { background-position: 0 0; }
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800/70 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp">
                <div class="p-6 sm:p-8 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-bold mb-2 text-gray-800 dark:text-sky-200">Halo, {{ $user->name }}!</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-10">Berikut adalah ringkasan progres pengerjaan kuesioner Anda.</p>

                    @if (empty($progressData))
                        <p class="text-center text-slate-500 dark:text-slate-400 py-12 text-lg">
                            Belum ada data progres yang tersedia atau belum ada Cobit Item yang bisa ditampilkan.
                        </p>
                    @else
                        @foreach ($progressData as $itemIndex => $cobitItem)
                            @php
                                $itemDelayClass = 'animation-delay-' . (($itemIndex % 5) * 100 + 100) . 'ms'; // Staggered delay
                            @endphp
                            <div class="mb-10 p-5 sm:p-6 bg-white dark:bg-slate-700/40 dark:border dark:border-slate-600/60 rounded-xl shadow-lg animate-fadeInUp" style="{{ $itemIndex > 0 ? 'animation-delay: ' . $itemDelayClass : '' }}; opacity: {{ $itemIndex > 0 ? 0 : 1 }};">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                                    <h4 class="text-2xl font-bold text-sky-600 dark:text-sky-300 mb-2 sm:mb-0">{{ $cobitItem['nama_item'] }}</h4>
                                    @if($cobitItem['total_levels_in_item'] > 0)
                                        @php
                                            $itemPercentage = ($cobitItem['completed_levels_in_item'] / $cobitItem['total_levels_in_item']) * 100;
                                        @endphp
                                        <span class="text-sm font-semibold py-1 px-3 rounded-full {{ $itemPercentage == 100 ? 'bg-emerald-100 dark:bg-emerald-500/30 text-emerald-600 dark:text-emerald-300' : 'bg-amber-100 dark:bg-amber-500/30 text-amber-600 dark:text-amber-300' }}">
                                            {{ round($itemPercentage) }}% Selesai
                                            <span class="hidden sm:inline">({{ $cobitItem['completed_levels_in_item'] }} / {{ $cobitItem['total_levels_in_item'] }} Level)</span>
                                        </span>
                                    @endif
                                </div>

                                @if (empty($cobitItem['kategoris']))
                                    <p class="text-sm text-gray-500 dark:text-gray-400 pl-2">Tidak ada kategori dalam item ini.</p>
                                @else
                                    @foreach ($cobitItem['kategoris'] as $kategori)
                                        <div class="mb-6 ml-0 sm:ml-4 pl-4 py-4 border-l-4 rounded-r-lg dark:bg-slate-700/20 {{ $kategori['completed_levels_in_kategori'] == $kategori['total_levels_in_kategori'] && $kategori['total_levels_in_kategori'] > 0 ? 'border-emerald-500 dark:border-emerald-400' : 'border-sky-500 dark:border-sky-400' }}">
                                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3">
                                                <h5 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-1 sm:mb-0">{{ $kategori['nama_kategori'] }}</h5>
                                                @if($kategori['total_levels_in_kategori'] > 0)
                                                    @php
                                                        $kategoriPercentage = ($kategori['completed_levels_in_kategori'] / $kategori['total_levels_in_kategori']) * 100;
                                                    @endphp
                                                    <span class="text-xs font-medium py-0.5 px-2.5 rounded-full {{ $kategoriPercentage == 100 ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400' }}">
                                                        {{ round($kategoriPercentage) }}% Selesai
                                                        <span class="hidden sm:inline">({{ $kategori['completed_levels_in_kategori'] }} / {{ $kategori['total_levels_in_kategori'] }} Level)</span>
                                                    </span>
                                                @endif
                                            </div>

                                            @if (empty($kategori['levels']))
                                                <p class="text-xs text-gray-500 dark:text-gray-400 pl-1">Tidak ada level dalam kategori ini.</p>
                                            @else
                                                <ul class="space-y-4 mt-2">
                                                    @foreach ($kategori['levels'] as $level)
                                                        <li class="p-3 sm:p-4 bg-white dark:bg-slate-600/30 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                                                            {{-- Info Level (Nama Level, Pertanyaan Dijawab/Total) - Opsional, bisa di-uncomment dan styling jika perlu --}}
                                                            {{--
                                                            <div class="flex items-center justify-between mb-2">
                                                                <a href="{{ $level['url'] ?? '#' }}" class="text-md font-medium text-sky-700 dark:text-sky-300 hover:underline">
                                                                    {{ $level['nama_level'] }}
                                                                </a>
                                                                <span class="text-xs font-medium {{ $level['is_completed'] ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-500 dark:text-amber-400' }}">
                                                                    {{ $level['answered_quisioners'] ?? 0 }} / {{ $level['total_quisioners'] ?? 0 }} Pertanyaan
                                                                    @if($level['is_completed']) (Selesai) @endif
                                                                </span>
                                                            </div>
                                                            --}}
                                                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-3.5 relative overflow-hidden progress-bar-animated">
                                                                <div class="h-3.5 rounded-full transition-all duration-500 ease-out {{ $level['percentage'] == 100 ? 'bg-gradient-to-r from-emerald-500 to-green-400' : 'bg-gradient-to-r from-sky-500 to-blue-500' }}" style="width: {{ $level['percentage'] }}%"></div>
                                                            </div>
                                                            <div class="flex justify-between items-center mt-1.5">
                                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $level['nama_level'] }}</span> {{-- Nama level di bawah progress bar --}}
                                                                <p class="text-sm font-semibold text-gray-700 dark:text-sky-200">{{ $level['percentage'] }}%</p>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

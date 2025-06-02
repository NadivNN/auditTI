<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight tracking-wide text-gray-700 dark:text-sky-300 animate-fadeInDown">
            {{ __('Level Kategori - ') . ($kategori->nama ?? 'Kategori Tidak Ditemukan') . ' - ' . ($cobitItem->nama_item ?? 'Item Tidak Ditemukan') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Variasi delay animasi, tambahkan sesuai kebutuhan */
        .animation-delay-100 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
            opacity: 0;
        }

        .animation-delay-500 {
            animation-delay: 0.5s;
            opacity: 0;
        }

        /* ... dan seterusnya jika perlu lebih banyak ... */

        .animate-fadeInDown {
            animation: fadeInDown 0.6s ease-out forwards;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="p-6 overflow-hidden bg-white shadow-xl sm:p-8 dark:bg-slate-800/70 dark:backdrop-blur-md dark:shadow-blue-950/40 sm:rounded-xl animate-fadeInUp dark:border dark:border-blue-700/30">
                <h3 class="mb-8 text-2xl font-bold tracking-tight text-gray-800 dark:text-sky-300">Daftar Levels</h3>

                {{-- Menampilkan flash messages --}}
                @if (session('success'))
                    <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 border rounded-lg dark:bg-green-700/20 dark:text-green-300 border-green-600/30 animate-fadeInDown"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 border rounded-lg dark:bg-red-700/20 dark:text-red-300 border-red-600/30 animate-fadeInDown"
                        role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div
                        class="p-4 mb-6 text-sm text-red-700 bg-red-100 border rounded-lg dark:bg-red-700/20 dark:text-red-300 border-red-600/30 animate-fadeInDown">
                        <p class="font-bold text-red-800 dark:text-red-200">Terdapat kesalahan:</p>
                        <ul class="mt-1 text-red-700 list-disc list-inside dark:text-red-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <ul class="space-y-5">
                    @forelse ($levels as $index => $level)
                        @php
                            $delayClass = 'animation-delay-' . (($index % 5) + 1) . '00';
                        @endphp
                        <li class="p-5 border dark:border-slate-700/70 bg-white dark:bg-slate-700/30 rounded-xl shadow-md hover:shadow-lg dark:hover:shadow-sky-700/20 transition-all duration-300 ease-in-out animate-fadeInUp {{ $delayClass }}"
                            style="opacity:0;">
                            <div
                                class="flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center sm:gap-4">
                                <span
                                    class="flex-grow mb-2 text-lg font-semibold text-gray-800 dark:text-sky-200 sm:mb-0">{{ $level->nama_level }}</span>
                                <div class="flex-shrink-0 w-full mt-2 sm:mt-0 sm:w-auto">
                                    @if ($level->approvedRequest)
                                        {{-- Jika permintaan disetujui → langsung bisa isi ulang --}}
                                        <a href="{{ route('audit.showQuisioner', ['cobitItem' => $cobitItem->id, 'kategori' => $kategori->id, 'level' => $level->id]) }}"
                                            class="w-full sm:w-auto inline-block text-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 rounded-lg shadow-md hover:shadow-lg hover:shadow-green-500/40 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-slate-800 focus:ring-green-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                                            Isi Ulang Kuesioner
                                        </a>
                                    @elseif ($level->pendingRequest)
                                        {{-- Permintaan sedang menunggu persetujuan --}}
                                        <span
                                            class="inline-block w-full px-4 py-2 text-sm font-medium text-center text-yellow-800 bg-yellow-100 border border-transparent rounded-lg sm:w-auto dark:bg-yellow-600/30 dark:text-yellow-200 dark:border-yellow-500/50">
                                            Menunggu Persetujuan
                                        </span>
                                    @elseif ($level->hasAnswers)
                                        {{-- Sudah ada jawaban, tampilkan tombol ajukan ulang --}}
                                        <form action="{{ route('resubmission.request', $level->id) }}" method="POST"
                                            class="inline w-full sm:w-auto">
                                            @csrf
                                            <button type="submit"
                                                class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 rounded-lg shadow-lg hover:shadow-xl hover:shadow-orange-500/50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-slate-800 focus:ring-amber-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                                                Ajukan Pengisian Ulang
                                            </button>
                                        </form>
                                    @else
                                        {{-- Belum pernah isi jawaban --}}
                                        <a href="{{ route('audit.showQuisioner', ['cobitItem' => $cobitItem->id, 'kategori' => $kategori->id, 'level' => $level->id]) }}"
                                            class="w-full sm:w-auto inline-block text-center px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 dark:from-sky-700 dark:to-blue-800 dark:hover:from-sky-800 dark:hover:to-blue-900 rounded-lg shadow-md hover:shadow-lg dark:hover:shadow-sky-700/40 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-slate-800 focus:ring-sky-600 transition-all duration-300 ease-in-out transform hover:scale-105">
                                            Isi Kuesioner
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @empty
                        <li>
                            <p class="py-10 text-lg text-center text-slate-500 dark:text-slate-400">Tidak ada level yang
                                tersedia untuk kategori ini.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

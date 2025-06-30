<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight tracking-wide text-gray-700 dark:text-sky-300 animate-fadeInDown">
            {{ __('Audit Cobit') }}
        </h2>
    </x-slot>

    {{-- CSS untuk Animasi dan Efek Visual Kartu --}}
    <style>
        /* Animasi Keyframes */
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

        /* Kelas Utilitas Animasi */
        .animate-fadeInDown {
            animation: fadeInDown 0.6s ease-out forwards;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Kelas Utilitas untuk Stagger Effect (Delay) */
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

        /* Efek Border Gradien untuk Kartu */
        .gradient-border::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 0.75rem;
            padding: 2px;
            background: linear-gradient(120deg, #0ea5e9, #6366f1, #ec4899);
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
            opacity: 0.6;
            transition: opacity 0.3s ease-in-out;
        }

        .group:hover .gradient-border::before {
            opacity: 1;
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($cobitItems as $index => $item)
                    @php
                        // ▼▼▼ LOGIKA PEMERIKSAAN STATUS DIMULAI ▼▼▼
                        // Memanggil method dari model untuk memeriksa apakah item ini sudah diselesaikan
                        // oleh pengguna yang sedang login.
                        $isCompleted = $item->isCompletedByUser(auth()->user());
                        // ▲▲▲ LOGIKA PEMERIKSAAN STATUS SELESAI ▲▲▲

                        // Kalkulasi delay untuk stagger effect pada animasi
                        $delayClass = 'animation-delay-' . (($index % 5) + 1) . '00';
                    @endphp

                    {{-- Card Container --}}
                    <div
                        class="group relative flex flex-col justify-between
                                bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm
                                border border-gray-200 dark:border-transparent
                                rounded-xl shadow-lg dark:shadow-slate-900/70
                                transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-2xl
                                dark:hover:shadow-cyan-500/40
                                animate-fadeInUp {{ $delayClass }}">

                        {{-- Efek border gradien (hanya aktif di dark mode) --}}
                        <div class="absolute inset-0 hidden overflow-hidden pointer-events-none dark:block rounded-xl">
                            <div class="gradient-border"></div>
                        </div>

                        {{-- Konten Kartu --}}
                        <div class="relative flex flex-col justify-between h-full p-6 bg-transparent rounded-xl">
                            {{-- Bagian Atas: Judul dan Deskripsi --}}
                            <div>
                                <h5
                                    class="mb-3 text-2xl font-bold tracking-tight text-gray-800 transition-colors duration-300 dark:text-sky-300 group-hover:dark:text-sky-200">
                                    {{ $item->nama_item }}
                                </h5>
                                <p class="mb-6 text-sm font-normal leading-relaxed text-gray-600 dark:text-gray-400">
                                    {{ \Illuminate\Support\Str::limit($item->deskripsi, 150) }}
                                </p>
                            </div>

                            {{-- ▼▼▼ BAGIAN TOMBOL DINAMIS ▼▼▼ --}}
                            {{-- Bagian Bawah: Tombol Aksi akan berubah berdasarkan status $isCompleted --}}
                            <div class="mt-auto">
                                @if ($isCompleted)
                                    {{-- TAMPILAN JIKA AUDIT SUDAH SELESAI --}}
                                    <button disabled
                                        class="inline-flex items-center justify-center self-start px-5 py-2.5 text-sm font-semibold text-center text-white bg-green-600 rounded-lg opacity-75 cursor-not-allowed dark:bg-green-700">
                                        Audit Selesai
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                @else
                                    {{-- TAMPILAN JIKA AUDIT BELUM SELESAI --}}
                                    <a href="{{ route('audit.showCategories', $item->id) }}"
                                        class="inline-flex items-center justify-center self-start
                                              px-5 py-2.5 text-sm font-semibold text-center text-white
                                              rounded-lg transition-all duration-300 ease-in-out
                                              bg-gradient-to-r from-sky-500 via-cyan-500 to-blue-600
                                              hover:from-sky-600 hover:via-cyan-600 hover:to-blue-700
                                              focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800
                                              transform hover:scale-105 hover:shadow-lg hover:shadow-cyan-500/50">
                                        Lihat Kategori
                                        <svg class="w-4 h-4 ml-2 transition-transform duration-300 rtl:rotate-180 group-hover:translate-x-0.5"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            {{-- ▲▲▲ AKHIR BAGIAN TOMBOL DINAMIS ▲▲▲ --}}
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>

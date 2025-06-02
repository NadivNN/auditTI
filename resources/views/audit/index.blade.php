<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Audit Cobit') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi ini ada di file CSS utama atau tag <style> di layout.
         Anda bisa menggabungkannya dengan CSS animasi dari contoh sebelumnya. --}}
    <style>
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        /* Anda bisa menambahkan lebih banyak variasi delay jika dibutuhkan */
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animation-delay-200 { animation-delay: 0.2s; opacity: 0; }
        .animation-delay-300 { animation-delay: 0.3s; opacity: 0; }
        .animation-delay-400 { animation-delay: 0.4s; opacity: 0; }
        .animation-delay-500 { animation-delay: 0.5s; opacity: 0; }

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

        /* Untuk efek border gradien pada kartu (opsional, bisa disesuaikan) */
        .gradient-border::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 0.75rem; /* sesuaikan dengan rounded kartu */
            padding: 2px; /* ketebalan border */
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

    <div class="py-12 dark:bg-slate-950"> {{-- Latar belakang sedikit lebih gelap untuk kontainer utama di dark mode --}}
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($cobitItems as $index => $item)
                    @php
                        // Kalkulasi sederhana untuk delay animasi yang berbeda (maksimal 500ms)
                        $delayClass = 'animation-delay-' . (($index % 5) + 1) . '00';
                    @endphp
                    <div class="group relative flex flex-col justify-between max-w-sm p-0.5 {{-- Untuk padding border gradien --}}
                                bg-white dark:bg-slate-800/80 dark:backdrop-blur-sm {{-- Glassmorphism di dark mode --}}
                                border border-gray-200 dark:border-transparent {{-- Hilangkan border default di dark, diganti gradien --}}
                                rounded-xl shadow-lg dark:shadow-slate-900/70
                                transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-2xl
                                dark:hover:shadow-cyan-500/40
                                animate-fadeInUp {{ $delayClass }}"
                                style="opacity:0;"> {{-- opacity:0; untuk animasi --}}

                        {{-- Efek border gradien (hanya di dark mode atau bisa diatur sesuai keinginan) --}}
                        <div class="absolute inset-0 rounded-xl overflow-hidden pointer-events-none">
                             <div class="hidden dark:block gradient-border"></div>
                        </div>


                        <div class="relative p-6 bg-white dark:bg-transparent rounded-xl h-full flex flex-col justify-between"> {{-- Konten di atas border gradien --}}
                            <div>
                                <h5 class="mb-3 text-2xl font-bold tracking-tight text-gray-800 dark:text-sky-300 group-hover:dark:text-sky-200 transition-colors duration-300">
                                    {{ $item->nama_item }}
                                </h5>
                                <p class="mb-6 font-normal text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit($item->deskripsi, 150) }} {{-- Sedikit lebih panjang --}}
                                </p>
                            </div>

                            <a href="{{ route('audit.showCategories', $item->id) }}"
                               class="inline-flex items-center justify-center self-start mt-auto {{-- self-start agar tidak full-width, mt-auto untuk ke bawah --}}
                                      px-5 py-2.5 text-sm font-semibold text-center text-white
                                      rounded-lg transition-all duration-300 ease-in-out
                                      bg-gradient-to-r from-sky-500 via-cyan-500 to-blue-600
                                      hover:from-sky-600 hover:via-cyan-600 hover:to-blue-700
                                      focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800
                                      transform hover:scale-105 hover:shadow-lg hover:shadow-cyan-500/50">
                                Lihat Kategori
                                <svg class="w-4 h-4 ml-2 rtl:rotate-180 transition-transform duration-300 group-hover:translate-x-0.5"
                                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

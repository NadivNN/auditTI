<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Kategori Cobit - ') . $cobitItem->nama_item }}
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
        /* ... dan seterusnya jika perlu lebih banyak ... */

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

        /* Opsional: Efek border gradien untuk kartu utama (jika diinginkan) */
        .futuristic-gradient-border::before {
            content: "";
            position: absolute;
            inset: -1px; /* Sedikit keluar agar border terlihat penuh */
            border-radius: 0.80rem; /* Sesuaikan dengan rounded-xl kartu + padding border */
            padding: 2px; /* Ketebalan border */
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.4), rgba(99, 102, 241, 0.3), rgba(28,37,66,0.2)); /* Gradien biru ke transparan */
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor; /* atau destination-out */
            mask-composite: exclude; /* atau xor */
            pointer-events: none; /* Agar tidak mengganggu interaksi dengan kartu */
            transition: background 0.3s ease-in-out;
            z-index: -1; /* Di belakang konten kartu */
        }
        .group:hover .futuristic-gradient-border::before { /* Jika ingin border lebih terlihat saat hover kartu utama */
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.7), rgba(99, 102, 241, 0.6), rgba(28,37,66,0.4));
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="group relative p-6 overflow-hidden bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/30 sm:rounded-xl animate-fadeInUp">
                {{-- Kartu utama dengan efek glassmorphism dan border gradien opsional (jika kelas .futuristic-gradient-border ditambahkan) --}}
                {{-- <div class="futuristic-gradient-border"></div> --}} {{-- Uncomment jika ingin border gradien --}}

                <h3 class="mb-8 text-2xl font-bold tracking-tight text-gray-800 dark:text-sky-300">
                    Daftar Kategori
                </h3>

                <ul class="space-y-4">
                    @foreach ($kategoris as $index => $kategori)
                        @php
                            // Kalkulasi sederhana untuk delay animasi yang berbeda (maksimal 500ms)
                            $delayClass = 'animation-delay-' . (($index % 5) + 1) . '00';
                        @endphp
                        <li class="animate-fadeInUp {{ $delayClass }}" style="opacity:0;">
                            <a href="{{ route('audit.showLevels', [$cobitItem->id, $kategori->id]) }}"
                               class="block px-5 py-4 rounded-lg transition-all duration-300 ease-in-out transform
                                      bg-gray-100 dark:bg-slate-700/60
                                      text-gray-700 dark:text-gray-200
                                      hover:shadow-xl hover:scale-[1.02]
                                      hover:bg-gradient-to-r hover:from-sky-500 hover:to-blue-600
                                      dark:hover:from-sky-500/80 dark:hover:to-blue-600/80
                                      hover:text-white dark:hover:text-white
                                      dark:hover:shadow-sky-500/30 focus:outline-none focus:ring-2 focus:ring-sky-500/70">
                                <span class="text-lg font-medium">{{ $kategori->nama }}</span>
                                {{-- Opsional: Tambahkan ikon panah atau chevron di sini yang muncul saat hover --}}
                                {{-- <svg class="inline-block w-5 h-5 ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300" ...></svg> --}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

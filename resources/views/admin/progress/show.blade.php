<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide">
            Detail Progress: <span class="text-white">{{ $user->name }}</span>
        </h2>
    </x-slot>

    {{-- Alpine.js diperlukan untuk accordion. Biasanya sudah ada di layout default Jetstream/Breeze. --}}
    {{-- Jika belum, tambahkan <script src="//unpkg.com/alpinejs" defer></script> di layout utama Anda --}}

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div
                class="p-6 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl">

                {{-- Header Konten dengan Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div>
                        <h3 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-sky-300">
                            Rincian Pengerjaan Audit
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Berikut adalah rincian untuk setiap item, kategori, dan level.
                        </p>
                    </div>
                    <div class="flex space-x-3 mt-4 sm:mt-0">
                        <a href="{{ route('admin.progress.index') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:bg-slate-700 dark:text-gray-200 dark:border-slate-600 dark:hover:bg-slate-600">
                            Kembali
                        </a>
                        <a href="{{ route('admin.progress.downloadPDF', $user) }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 border border-transparent rounded-lg shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            Download PDF
                        </a>
                    </div>
                </div>

                {{-- Accordion untuk menampilkan data progres --}}
                <div class="space-y-4">
                    @forelse ($progressData as $item)
                        <div x-data="{ open: false }"
                            class="bg-gray-50 dark:bg-slate-900/50 rounded-lg border dark:border-slate-700 transition-shadow duration-300 hover:shadow-lg">
                            {{-- Accordion Header untuk Item --}}
                            <button @click="open = !open"
                                class="w-full flex justify-between items-center text-left px-6 py-4">
                                <span
                                    class="font-bold text-lg text-gray-800 dark:text-sky-400">{{ $item['nama_item'] }}</span>
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">
                                        {{ $item['completed_levels_in_item'] }} / {{ $item['total_levels_in_item'] }}
                                        Level Selesai
                                    </span>
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-300"
                                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </button>

                            {{-- Accordion Content untuk Kategori dan Level --}}
                            <div x-show="open" x-collapse class="px-6 pb-4 border-t dark:border-slate-700/50">
                                <div class="mt-4 space-y-3">
                                    @foreach ($item['kategoris'] as $kategori)
                                        <div class="p-4 bg-white dark:bg-slate-800 rounded-md">
                                            <p class="font-semibold text-gray-700 dark:text-sky-200">
                                                {{ $kategori['nama_kategori'] }}</p>
                                            <ul class="mt-2 space-y-2">
                                                @foreach ($kategori['levels'] as $level)
                                                    <li class="flex justify-between items-center text-sm">
                                                        <span
                                                            class="text-gray-600 dark:text-gray-300">{{ $level['nama_level'] }}</span>
                                                        @if ($level['is_completed'])
                                                            <span
                                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold leading-5 text-emerald-700 bg-emerald-100 dark:bg-emerald-500/20 dark:text-emerald-300 border border-emerald-500/30 rounded-full">
                                                                COMPLETED
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold leading-5 text-amber-700 bg-amber-100 dark:bg-amber-500/20 dark:text-amber-300 border border-amber-500/30 rounded-full">
                                                                IN PROGRESS ({{ $level['percentage'] }}%)
                                                            </span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-gray-500 dark:text-gray-400">Data progres untuk user ini tidak ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

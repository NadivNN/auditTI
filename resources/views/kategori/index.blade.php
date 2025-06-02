<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Daftar Kategori') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi dan custom select ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        /* Variasi delay animasi */
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animation-delay-200 { animation-delay: 0.2s; opacity: 0; }

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

        .custom-select-dark {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2338bdf8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); /* sky-400 color for arrow */
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25em 1.25em;
            padding-right: 2.75rem; /* Ensure space for arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8"> {{-- Tambah space-y-8 untuk jarak antar panel --}}

            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-emerald-600/20 border border-green-300 dark:border-emerald-500/40 animate-fadeInDown">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-emerald-300">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-600/20 border border-red-300 dark:border-red-500/40 animate-fadeInDown">
                    <div class="flex">
                        <div class="flex-shrink-0">
                             <svg class="h-5 w-5 text-red-400 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800 dark:text-red-300">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form Filter Cobit Item --}}
            <div class="p-6 bg-white dark:bg-slate-800/60 dark:backdrop-blur-md rounded-xl shadow-xl dark:shadow-blue-950/30 dark:border dark:border-sky-700/30 animate-fadeInUp">
                <form method="GET" action="{{ route('kategori.index') }}">
                    <div class="flex flex-col sm:flex-row items-end gap-4">
                        <div class="w-full sm:w-auto sm:flex-grow">
                            <label for="cobit_item_id_filter" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-sky-200">Filter Berdasarkan Cobit Item:</label>
                            <select name="cobit_item_id" id="cobit_item_id_filter" class="custom-select-dark mt-1 block w-full pl-4 pr-10 py-2.5 text-base border-gray-300 dark:border-slate-600 dark:bg-slate-700/80 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 sm:text-sm rounded-lg shadow-sm">
                                <option value="">Semua Cobit Item</option>
                                @if(isset($cobitItems) && $cobitItems->count() > 0)
                                    @foreach ($cobitItems as $cobitItemOption)
                                        <option value="{{ $cobitItemOption->id }}" {{ (string)$selectedCobitItemId === (string)$cobitItemOption->id ? 'selected' : '' }}>
                                            {{ $cobitItemOption->nama_item }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-lg shadow-md hover:shadow-lg hover:shadow-sky-500/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-800 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                            Filter
                        </button>
                        @if($selectedCobitItemId)
                        <a href="{{ route('kategori.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 border border-sky-500 dark:border-sky-600 text-sm font-semibold rounded-lg shadow-sm text-sky-600 dark:text-sky-300 hover:bg-sky-500/10 dark:hover:bg-sky-400/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-800 transition-all duration-300 ease-in-out transform hover:scale-103">
                            Reset Filter
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Panel Tabel Utama --}}
            <div class="p-0 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp animation-delay-100" style="opacity:0;">
                <div class="overflow-x-auto shadow-md rounded-xl dark:border dark:border-slate-700/80">
                    <table class="min-w-full">
                        <thead class="dark:bg-slate-700/80">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">ID</th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Nama</th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Cobit Item</th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800">
                            @if(isset($kategoris) && $kategoris->count() > 0)
                                @foreach ($kategoris as $kategori)
                                    <tr class="dark:hover:bg-slate-700/60 transition-colors duration-150">
                                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 whitespace-nowrap border-b dark:border-slate-700">
                                            {{ $kategori->id }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-sky-100 whitespace-nowrap border-b dark:border-slate-700">
                                            {{ $kategori->nama }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap border-b dark:border-slate-700">
                                            {{ $kategori->cobitItem->nama_item ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b dark:border-slate-700 space-x-4">
                                            <a href="{{ route('kategori.edit', $kategori->id) }}" class="font-semibold text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-200 transition-colors duration-150">
                                                Edit
                                            </a>
                                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-semibold text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-150">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-slate-400">
                                        Tidak ada data kategori ditemukan.
                                        @if($selectedCobitItemId)
                                            Coba reset filter atau pilih Cobit Item yang lain.
                                        @else
                                            Anda bisa menambahkan kategori baru.
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Paginasi Links --}}
                @if(isset($kategoris) && $kategoris->hasPages())
                    <div class="px-4 py-3 mt-0 bg-transparent dark:bg-transparent sm:px-0 rounded-b-xl">
                         {{-- Idealnya, publish view pagination Tailwind dan sesuaikan di sana --}}
                        {{ $kategoris->appends(request()->query())->links() }}
                    </div>
                @endif

                <div class="mt-8 px-4 sm:px-0">
                    <a href="{{ route('kategori.create') }}"
                       class="inline-flex items-center justify-center px-6 py-3 text-base font-semibold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-lg shadow-lg hover:shadow-xl hover:shadow-sky-500/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-800 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                        Tambah Kategori Baru
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

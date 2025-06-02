<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi dan custom select ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }

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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan sukses tidak ada di kode asli, tapi jika ada, bisa di-style seperti ini:
            @if (session('success'))
                <div class="mb-6 p-4 text-sm rounded-lg text-green-700 bg-green-100 dark:bg-green-700/20 dark:text-green-300 border border-green-600/30 animate-fadeInDown" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            --}}

            <div class="p-6 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp">
                {{-- Anda bisa menambahkan judul di dalam panel jika mau, misal:
                <h3 class="text-2xl font-bold text-gray-800 dark:text-sky-300 mb-8">
                    Formulir Edit Kategori
                </h3>
                --}}
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-sky-200">Nama Kategori:</label>
                        <input type="text" name="nama" id="nama" required
                               value="{{ old('nama', $kategori->nama) }}"
                               class="block w-full border-gray-300 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-100 focus:border-sky-500 dark:focus:border-sky-500 focus:ring-sky-500 dark:focus:ring-sky-500 rounded-lg shadow-sm placeholder:text-gray-400 dark:placeholder:text-slate-400 transition-colors duration-150 ease-in-out" />
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cobit_item_id" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-sky-200">Cobit Item:</label>
                        <select name="cobit_item_id" id="cobit_item_id" required
                                class="custom-select-dark block w-full border-gray-300 dark:border-slate-600 dark:bg-slate-700/80 dark:text-gray-100 focus:border-sky-500 dark:focus:border-sky-500 focus:ring-2 focus:ring-sky-500 dark:focus:ring-sky-500 rounded-lg shadow-sm transition-colors duration-150 ease-in-out py-2.5 pl-4">
                            @foreach ($cobitItems as $item)
                                <option value="{{ $item->id }}"
                                        {{ $item->id == old('cobit_item_id', $kategori->cobit_item_id) ? 'selected' : '' }}
                                        class="dark:bg-slate-700 dark:text-gray-200">
                                    {{ $item->nama_item }}
                                </option>
                            @endforeach
                        </select>
                        @error('cobit_item_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 text-base font-semibold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-lg shadow-lg hover:shadow-xl hover:shadow-sky-500/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-800 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                            Update Kategori
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

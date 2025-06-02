<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Edit Cobit Item') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

        /* Styling untuk custom checkbox (PENYEMPURNAAN DI SINI) */
        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 1.375em; /* Sedikit lebih besar: 22px jika base 16px */
            height: 1.375em;
            border-radius: 0.375rem; /* 6px, sedikit lebih rounded */
            border: 2px solid #9ca3af; /* abu-abu dasar untuk light mode */
            background-color: #f9fafb; /* latar sedikit off-white untuk light mode */
            outline: none;
            transition: all 0.2s ease-in-out;
            position: relative;
            cursor: pointer;
            vertical-align: middle;
            flex-shrink: 0; /* Mencegah checkbox mengecil di flex container */
        }
        .dark .custom-checkbox {
            border-color: #4b5563; /* slate-600 */
            background-color: #374151; /* slate-700 */
        }
        .custom-checkbox:checked {
            border-color: #0ea5e9; /* sky-500 */
            background-color: #0ea5e9; /* sky-500 */
        }

        /* Penyempurnaan untuk tanda centang */
        .custom-checkbox:checked::before {
            content: ''; /* Karakter checkmark ✔ */
            display: flex; /* Menggunakan flex untuk centering */
            align-items: center; /* Centering vertikal */
            justify-content: center; /* Centering horizontal */
            width: 100%;
            height: 100%;
            font-size: 0.9em; /* Ukuran tanda centang, bisa disesuaikan */
            font-weight: 700; /* Ketebalan tanda centang (bold) */
            color: white;
            position: absolute;
            top: 0; /* Reset posisi untuk flex centering */
            left: 0;
            line-height: 1; /* Memastikan tidak ada spasi ekstra karena line-height */
            text-align: center; /* Pastikan alignment teks di tengah (untuk beberapa font) */
        }

        .custom-checkbox:focus-visible { /* Menggunakan focus-visible untuk aksesibilitas lebih baik */
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.5); /* sky-500 dengan opacity */
        }
        .dark .custom-checkbox:focus-visible {
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.6); /* sky-400 dengan opacity untuk dark */
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 text-sm rounded-lg text-green-700 bg-green-100 dark:bg-green-700/20 dark:text-green-300 border border-green-600/30 animate-fadeInDown" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp">
                <form action="{{ route('cobititem.update', $cobitItem->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama_item" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-sky-200">Nama Item:</label>
                        <input type="text" name="nama_item" id="nama_item" required
                               value="{{ old('nama_item', $cobitItem->nama_item) }}"
                               class="block w-full border-gray-300 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-100 focus:border-sky-500 dark:focus:border-sky-500 focus:ring-sky-500 dark:focus:ring-sky-500 rounded-lg shadow-sm placeholder:text-gray-400 dark:placeholder:text-slate-400 transition-colors duration-150 ease-in-out" />
                        @error('nama_item')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deskripsi" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-sky-200">Deskripsi:</label>
                        <textarea name="deskripsi" id="deskripsi" required rows="4"
                                  class="block w-full border-gray-300 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-100 focus:border-sky-500 dark:focus:border-sky-500 focus:ring-sky-500 dark:focus:ring-sky-500 rounded-lg shadow-sm placeholder:text-gray-400 dark:placeholder:text-slate-400 transition-colors duration-150 ease-in-out">{{ old('deskripsi', $cobitItem->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6"> {{-- Pastikan ada margin bottom jika ini elemen terakhir sebelum tombol --}}
                        <label for="is_visible" class="inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" name="is_visible" id="is_visible" value="1"
                                   {{ old('is_visible', $cobitItem->is_visible) ? 'checked' : '' }}
                                   class="custom-checkbox" />
                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-200">Tampilkan Item</span>
                        </label>
                        @error('is_visible')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 text-base font-semibold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-lg shadow-lg hover:shadow-xl hover:shadow-sky-500/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-800 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                            Update Cobit Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

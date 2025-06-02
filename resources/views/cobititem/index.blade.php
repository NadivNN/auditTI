<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Daftar Cobit Item') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        /* Variasi delay animasi (opsional, bisa ditambahkan jika ada beberapa elemen yang dianimasikan bertahap) */
        /* .animation-delay-100 { animation-delay: 0.1s; opacity: 0; } */

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 text-sm rounded-lg text-green-700 bg-green-100 dark:bg-green-700/20 dark:text-green-300 border border-green-600/30 animate-fadeInDown" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp">
                {{-- Judul Internal Panel (Opsional, jika diperlukan)
                <h3 class="text-2xl font-bold text-gray-800 dark:text-sky-300 mb-6">
                    Manajemen Cobit Item
                </h3>
                --}}

                <div class="overflow-x-auto shadow-lg rounded-xl dark:border dark:border-slate-700/80">
                    <table class="min-w-full table-auto">
                        <thead class="dark:bg-slate-700/80">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">ID</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Nama Item</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Deskripsi</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Visible</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800">
                            @foreach ($cobitItems as $item)
                                <tr class="dark:hover:bg-slate-700/60 transition-colors duration-150">
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200 whitespace-nowrap border-b dark:border-slate-700">
                                        {{ $item->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-sky-100 whitespace-nowrap border-b dark:border-slate-700">
                                        {{ $item->nama_item }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 border-b dark:border-slate-700 max-w-sm truncate hover:whitespace-normal hover:max-w-none transition-all">
                                        {{ $item->deskripsi }}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap border-b dark:border-slate-700">
                                        @if($item->is_visible)
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 text-emerald-700 bg-emerald-100 dark:bg-emerald-500/20 dark:text-emerald-300 border border-emerald-500/30 rounded-full">Ya</span>
                                        @else
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 text-slate-700 bg-slate-100 dark:bg-slate-600/30 dark:text-slate-300 border border-slate-500/30 rounded-full">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap border-b dark:border-slate-700 space-x-4">
                                        <a href="{{ route('cobititem.edit', $item->id) }}"
                                           class="font-semibold text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-200 transition-colors duration-150">
                                            Edit
                                        </a>
                                        <form action="{{ route('cobititem.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="font-semibold text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-150">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    <a href="{{ route('cobititem.create') }}"
                       class="inline-flex items-center justify-center px-6 py-3 text-base font-semibold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-lg shadow-lg hover:shadow-xl hover:shadow-sky-500/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-800 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                        Tambah Cobit Item Baru
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

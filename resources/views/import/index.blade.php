<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300">
            {{ __('Import Data COBIT dari Excel') }}
        </h2>
    </x-slot>

    <div class="py-12 dark:bg-slate-950">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-slate-800/60 shadow-lg rounded-xl dark:border dark:border-sky-700/30">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md dark:bg-emerald-600/10 dark:text-emerald-300">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md dark:bg-red-600/10 dark:text-red-300">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('excel.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="file" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">Pilih File Excel (.xlsx/.xls)</label>
                        <input type="file" name="file" id="file" required
                            class="block w-full text-sm border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 focus:ring focus:ring-blue-500" />
                        @error('file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-md transition-all duration-300">
                            Import Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-sm text-gray-500 dark:text-gray-400">
                    Format Excel harus terdiri dari:
                    <ul class="mt-2 list-disc pl-6 space-y-1">
                        <li>Kolom A: <strong>Nama Item (Cobit)</strong></li>
                        <li>Kolom B: <strong>Deskripsi</strong></li>
                        <li>Kolom C: <strong>Nama Kategori</strong></li>
                        <li>Kolom D: <strong>Nama Level</strong></li>
                        <li>Kolom E: <strong>Pertanyaan</strong></li>
                        <li>Kolom F: <strong>Jawaban (diabaikan, karena otomatis N, P, L, F)</strong></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

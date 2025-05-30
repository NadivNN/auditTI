<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Level Kategori - ') . ($kategori->nama ?? 'Kategori Tidak Ditemukan') . ' - ' . ($cobitItem->nama_item ?? 'Item Tidak Ditemukan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Daftar Levels</h3>

                {{-- Menampilkan flash messages --}}
                @if(session('success'))
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                 @if ($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800">
                        <p class="font-bold">Terdapat kesalahan:</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <ul class="space-y-4">
                    {{-- Pastikan variabel $levels dari controller adalah yang berisi $levelsWithStatus --}}
                    @forelse ($levels as $level)
                        <li class="p-4 border rounded-lg dark:border-gray-700">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                                <span class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2 sm:mb-0">{{ $level->nama_level }}</span>
                                <div class="flex-shrink-0 mt-2 sm:mt-0">
                                    {{-- Debugging di dalam Blade (hapus setelah selesai) --}}
                                    {{--
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Debug: hasAnswers={{ $level->hasAnswers ? 'true':'false' }},
                                        pending={{ $level->pendingRequest ? 'true':'false' }},
                                        approved={{ $level->approvedRequest ? 'true':'false' }},
                                        canRequest={{ $level->canRequestResubmission ? 'true':'false' }}
                                    </div>
                                    --}}

                                    @if ($level->approvedRequest)
                                        {{-- 1. Permintaan disetujui -> Tombol Isi Ulang --}}
                                        <a href="{{ route('audit.showQuisioner', [
                                            'cobitItem' => $cobitItem->id,
                                            'kategori' => $kategori->id,
                                            'level' => $level->id,
                                        ]) }}"
                                           class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Isi Ulang Kuesioner
                                        </a>
                                    @elseif ($level->pendingRequest)
                                        {{-- 2. Permintaan sedang pending -> Teks Status --}}
                                        <span class="px-4 py-2 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-md dark:bg-yellow-700 dark:text-yellow-100">
                                            Menunggu Persetujuan
                                        </span>
                                    @elseif ($level->canRequestResubmission) {{-- Ini kondisi yang seharusnya TRUE berdasarkan dd() Anda --}}
                                        {{-- 3. Sudah dijawab & bisa request ulang (tidak ada request aktif) -> Tombol Ajukan Pengisian Ulang --}}
                                        <form action="{{ route('resubmission.request', $level->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Ajukan Pengisian Ulang
                                            </button>
                                        </form>
                                    @elseif ($level->hasAnswers)
                                        {{-- 4. Sudah dijawab, TAPI tidak bisa request ulang (karena $activeRequest ada tapi BUKAN pending/approved, misal 'rejected' atau 'completed') --}}
                                        <span class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md dark:bg-gray-600 dark:text-gray-300">
                                            Sudah Dijawab
                                        </span>
                                    @else
                                        {{-- 5. Belum dijawab sama sekali -> Tombol Isi Kuesioner --}}
                                        <a href="{{ route('audit.showQuisioner', [
                                            'cobitItem' => $cobitItem->id,
                                            'kategori' => $kategori->id,
                                            'level' => $level->id,
                                        ]) }}"
                                           class="px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-md hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            Isi Kuesioner
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @empty
                        <li>
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada level yang tersedia untuk kategori ini.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

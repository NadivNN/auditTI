<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Kategori Cobit - ') . $cobitItem->nama_item }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Daftar Kategori</h3>

                <ul class="space-y-3">
                    @foreach ($kategoris as $kategori)
                        <li>
                            <a href="{{ route('audit.showLevels', [$cobitItem->id, $kategori->id]) }}"
                                class="block px-4 py-3 transition bg-gray-100 rounded-lg dark:text-white dark:bg-gray-700 hover:bg-blue-600 hover:text-white">
                                {{ $kategori->nama }}
                            </a>
                        </li>
                    @endforeach
                </ul>

            </div>

        </div>
    </div>
</x-app-layout>

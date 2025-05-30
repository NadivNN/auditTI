<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Audit Cobit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($cobitItems as $item)
                    <div
                        class="flex flex-col justify-between max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                        <div>
                            <h5 class="mb-4 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                {{ $item->nama_item }}
                            </h5>
                            <p class="mb-6 font-normal text-gray-700 dark:text-gray-300">
                                {{ \Illuminate\Support\Str::limit($item->deskripsi, 120) }}
                            </p>
                        </div>

                        <a href="{{ route('audit.showCategories', $item->id) }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                            Lihat Kategori
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

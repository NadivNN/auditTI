<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit CobitItem') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 text-green-600 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 overflow-hidden bg-white shadow sm:rounded-lg dark:bg-gray-800">
                <form action="{{ route('cobititem.update', $cobitItem->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nama_item"
                            class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Nama Item:</label>
                        <input type="text" name="nama_item" id="nama_item" required
                            value="{{ old('nama_item', $cobitItem->nama_item) }}"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
                        @error('nama_item')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="deskripsi"
                            class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi:</label>
                        <textarea name="deskripsi" id="deskripsi" required rows="4"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">{{ old('deskripsi', $cobitItem->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="is_visible" class="inline-flex items-center text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="is_visible" id="is_visible" value="1"
                                {{ old('is_visible', $cobitItem->is_visible) ? 'checked' : '' }}
                                class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600" />
                            <span class="ml-2">Tampilkan Item</span>
                        </label>
                        @error('is_visible')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-semibold text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

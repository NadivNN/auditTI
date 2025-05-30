<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="p-6 overflow-hidden bg-white shadow sm:rounded-lg dark:bg-gray-800">
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nama" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                            Kategori:</label>
                        <input type="text" name="nama" id="nama" required
                            value="{{ old('nama', $kategori->nama) }}"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="cobit_item_id"
                            class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Cobit Item:</label>
                        <select name="cobit_item_id" id="cobit_item_id" required
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                            @foreach ($cobitItems as $item)
                                <option value="{{ $item->id }}"
                                    {{ $item->id == old('cobit_item_id', $kategori->cobit_item_id) ? 'selected' : '' }}>
                                    {{ $item->nama_item }}
                                </option>
                            @endforeach
                        </select>
                        @error('cobit_item_id')
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

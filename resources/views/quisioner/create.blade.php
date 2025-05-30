<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Tambah Quisioner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="p-6 overflow-hidden bg-white shadow sm:rounded-lg dark:bg-gray-800">
                <form action="{{ route('quisioner.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="pertanyaan"
                            class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Pertanyaan:</label>
                        <textarea name="pertanyaan" id="pertanyaan" rows="4" required
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">{{ old('pertanyaan') }}</textarea>
                        @error('pertanyaan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="level_id"
                            class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Level:</label>
                        <select name="level_id" id="level_id" required
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}"
                                    {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->nama_level }} - {{ $level->kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-semibold text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Jawab Quisioner - Level: ') . ($level->nama_level ?? 'Belum Ditentukan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 space-y-8 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">

                {{-- Untuk Menampilkan Notifikasi Error dari Server --}}
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600 dark:text-red-400">{{ __('Whoops! Ada yang salah.') }}</div>
                        <ul class="mt-3 text-sm text-red-600 list-disc list-inside dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- Atau jika Anda menggunakan flash message custom --}}
                @if (session('error_custom'))
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                        role="alert">
                        {{ session('error_custom') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert">
                        {{ session('success') }}
                    </div>
                @endif


                <form id="quisionerForm" action="{{ isset($level) ? route('jawaban.store', $level->id) : '#' }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="user_confirmation" id="user_confirmation_input" value="">

                    @if (isset($quisioners) && count($quisioners) > 0)
                        @foreach ($quisioners as $quisioner)
                            <div class="mb-8">
                                <label class="block mb-3 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $quisioner->pertanyaan ?? 'Pertanyaan tidak tersedia' }} <span
                                        class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-10">
                                    @foreach (['N', 'P', 'L', 'F'] as $option)
                                        <label class="inline-flex items-center cursor-pointer select-none">
                                            <input type="radio" name="jawaban[{{ $quisioner->id ?? rand() }}]"
                                                value="{{ $option }}"
                                                class="text-blue-600 form-radio dark:text-blue-400 quisioner-option"
                                                required>
                                            <span
                                                class="ml-2 font-medium text-gray-700 dark:text-white">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('jawaban.' . ($quisioner->id ?? ''))
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-700 dark:text-gray-300">Tidak ada quisioner yang tersedia untuk level ini.
                        </p>
                    @endif

                    <div class="mt-8">
                        <button type="submit" id="submitQuisioner"
                            class="px-6 py-3 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Kirim Jawaban
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi --}}
    <div id="confirmationModal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="max-w-md p-6 mx-auto bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Konfirmasi Penilaian</h3>
            <p class="mb-6 text-sm text-gray-700 dark:text-gray-300">
                Berdasarkan penilaian yang dilakukan,apakah saudara setuju aktivitas tersebut diatas memilikii
                capability level? (semua aktivitas bernilai F)
            </p>
            <div class="flex justify-end space-x-3">
                <button type="button" id="confirmNo"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:text-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Tidak Setuju
                </button>
                <button type="button" id="confirmYes"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Setuju
                </button>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('[MODAL_LOGIC] DOMContentLoaded fired.');

            const form = document.getElementById('quisionerForm');
            const submitButton = document.getElementById('submitQuisioner'); // Tombol utama "Kirim Jawaban"
            const modal = document.getElementById('confirmationModal');
            const confirmYesButton = document.getElementById('confirmYes'); // Tombol "Setuju" di modal
            const confirmNoButton = document.getElementById('confirmNo'); // Tombol "Tidak Setuju" di modal
            const userConfirmationInput = document.getElementById('user_confirmation_input');

            // Pemeriksaan elemen
            if (!form) console.error('[MODAL_LOGIC] Form (#quisionerForm) NOT FOUND');
            if (!submitButton) console.error('[MODAL_LOGIC] Submit Button (#submitQuisioner) NOT FOUND');
            if (!modal) console.error('[MODAL_LOGIC] Modal (#confirmationModal) NOT FOUND');
            if (!confirmYesButton) console.error('[MODAL_LOGIC] Confirm Yes Button (#confirmYes) NOT FOUND');
            if (!confirmNoButton) console.error('[MODAL_LOGIC] Confirm No Button (#confirmNo) NOT FOUND');
            if (!userConfirmationInput) console.error(
                '[MODAL_LOGIC] User Confirmation Input (#user_confirmation_input) NOT FOUND');

            if (form && submitButton && modal && confirmYesButton && confirmNoButton && userConfirmationInput) {
                console.log('[MODAL_LOGIC] All elements found. Attaching listeners.');

                // Listener untuk tombol utama "Kirim Jawaban"
                submitButton.addEventListener('click', function(event) {
                    event.preventDefault(); // Selalu cegah submit standar dulu
                    console.log('[MODAL_LOGIC] "Kirim Jawaban" button clicked.');

                    // Cek validitas form (apakah semua field 'required' sudah diisi)
                    if (!form.checkValidity()) {
                        console.log('[MODAL_LOGIC] Form is not valid. Reporting validity.');
                        form.reportValidity(); // Tampilkan pesan error validasi bawaan browser
                        return; // Hentikan proses jika form tidak valid
                    }

                    console.log('[MODAL_LOGIC] Form is valid. Showing confirmation modal.');
                    // Tampilkan modal
                    modal.classList.remove('hidden');
                    modal.style.display = 'flex'; // Pastikan display flex untuk Tailwind
                    modal.style.opacity = '1';
                    modal.style.visibility = 'visible';
                });

                // Listener untuk tombol "Tidak Setuju" di modal
                // Listener untuk tombol "Tidak Setuju" di modal
                confirmNoButton.addEventListener('click', function() {
                    console.log('[MODAL_LOGIC] "Tidak Setuju" button clicked (v2).');

                    // Cara standar Tailwind untuk menyembunyikan
                    modal.classList.add('hidden');
                    console.log('[MODAL_LOGIC] Attempted to add "hidden" class.');

                    // Paksa display menjadi none secara langsung via style attribute
                    modal.style.display = 'none';
                    console.log('[MODAL_LOGIC] Modal display style forced to "none".');

                    // Anda juga bisa mencoba mengatur visibility jika perlu
                    // modal.style.visibility = 'hidden';
                    // modal.style.opacity = '0';
                    // console.log('[MODAL_LOGIC] Modal visibility/opacity potentially updated.');
                });

                // Listener untuk tombol "Setuju" di modal
                confirmYesButton.addEventListener('click', function() {
                    console.log('[MODAL_LOGIC] "Setuju" button clicked.');
                    userConfirmationInput.value = 'setuju'; // Isi hidden input
                    modal.classList.add('hidden'); // Sembunyikan modal

                    console.log('[MODAL_LOGIC] Submitting form programmatically.');
                    form.submit(); // Submit form
                });

            } else {
                console.error('[MODAL_LOGIC] ERROR: One or more crucial elements were NOT FOUND. Check IDs.');
            }
        });
    </script>


</x-app-layout>

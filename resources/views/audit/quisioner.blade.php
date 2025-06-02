<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            {{ __('Jawab Quisioner - Level: ') . ($level->nama_level ?? 'Belum Ditentukan') }}
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        /* Variasi delay animasi, tambahkan sesuai kebutuhan */
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animation-delay-200 { animation-delay: 0.2s; opacity: 0; }
        .animation-delay-300 { animation-delay: 0.3s; opacity: 0; }
        .animation-delay-400 { animation-delay: 0.4s; opacity: 0; }
        .animation-delay-500 { animation-delay: 0.5s; opacity: 0; }

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

        /* Styling untuk custom radio button (opsional, jika ingin tampilan lebih futuristik) */
        .custom-radio {
            appearance: none;
            -webkit-appearance: none;
            width: 1.25em; /* 20px */
            height: 1.25em; /* 20px */
            border-radius: 50%;
            border: 2px solid #6b7280; /* dark:border-slate-500 */
            outline: none;
            transition: all 0.2s ease-in-out;
            position: relative;
            cursor: pointer;
        }
        .dark .custom-radio {
            border-color: #475569; /* slate-600 */
        }
        .custom-radio:checked {
            border-color: #0ea5e9; /* sky-500 */
            background-color: #0ea5e9; /* sky-500 */
        }
        .custom-radio:checked::before {
            content: '';
            display: block;
            width: 0.625em; /* 10px */
            height: 0.625em; /* 10px */
            border-radius: 50%;
            background-color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .custom-radio:focus {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.4); /* focus:ring-sky-500/40 */
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 sm:p-8 space-y-8 overflow-hidden bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl animate-fadeInUp dark:border dark:border-blue-700/30">

                {{-- Untuk Menampilkan Notifikasi Error dari Server --}}
                @if ($errors->any())
                    <div class="p-4 mb-4 rounded-lg bg-red-100 dark:bg-red-700/20 border border-red-300 dark:border-red-600/30 animate-fadeInDown">
                        <div class="font-semibold text-red-700 dark:text-red-300">{{ __('Whoops! Ada yang salah.') }}</div>
                        <ul class="mt-2 text-sm text-red-600 list-disc list-inside dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error_custom'))
                    <div class="p-4 mb-4 text-sm rounded-lg text-red-700 bg-red-100 dark:bg-red-700/20 dark:text-red-300 border border-red-600/30 animate-fadeInDown" role="alert">
                        {{ session('error_custom') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm rounded-lg text-green-700 bg-green-100 dark:bg-green-700/20 dark:text-green-300 border border-green-600/30 animate-fadeInDown" role="alert">
                        {{ session('success') }}
                    </div>
                @endif


                <form id="quisionerForm" action="{{ isset($level) ? route('jawaban.store', $level->id) : '#' }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_confirmation" id="user_confirmation_input" value="">

                    @if (isset($quisioners) && count($quisioners) > 0)
                        @foreach ($quisioners as $index => $quisioner)
                        @php
                            $delayClass = 'animation-delay-' . (($index % 5) + 1) . '00';
                        @endphp
                            <div class="mb-10 p-1 animate-fadeInUp {{ $delayClass }}" style="opacity:0;">
                                <label class="block mb-4 text-xl font-semibold text-gray-800 dark:text-sky-200">
                                    {{ $loop->iteration }}. {{ $quisioner->pertanyaan ?? 'Pertanyaan tidak tersedia' }} <span class="text-red-500 dark:text-red-400">*</span>
                                </label>
                                <div class="flex flex-wrap items-center gap-x-6 gap-y-3 sm:gap-x-8 justify-start">
                                    @foreach (['N', 'P', 'L', 'F'] as $option)
                                        <label class="group inline-flex items-center cursor-pointer select-none p-2 rounded-md dark:hover:bg-sky-700/20 transition-colors duration-150">
                                            <input type="radio" name="jawaban[{{ $quisioner->id ?? rand() }}]"
                                                   value="{{ $option }}"
                                                   class="custom-radio text-sky-500 dark:text-sky-400 bg-gray-100 dark:bg-slate-700 border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-sky-500 dark:focus:ring-sky-400 dark:focus:ring-offset-slate-800 quisioner-option"
                                                   required>
                                            <span class="ml-3 text-md font-medium text-gray-700 dark:text-gray-100 group-hover:dark:text-sky-200">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('jawaban.' . ($quisioner->id ?? ''))
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    @else
                        <p class="text-center py-10 text-slate-500 dark:text-slate-400 text-lg">Tidak ada quisioner yang tersedia untuk level ini.</p>
                    @endif

                    @if (isset($quisioners) && count($quisioners) > 0) {{-- Hanya tampilkan tombol jika ada quisioner --}}
                    <div class="mt-10 pt-6 border-t dark:border-slate-700/50">
                        <button type="submit" id="submitQuisioner"
                                class="w-full sm:w-auto px-8 py-3 text-base font-semibold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-lg shadow-lg hover:shadow-xl hover:shadow-sky-500/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                            Kirim Jawaban
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi --}}
    <div id="confirmationModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-slate-900/80 backdrop-blur-sm transition-opacity duration-300 ease-in-out opacity-0">
        <div class="max-w-md p-6 sm:p-8 mx-4 bg-white dark:bg-gradient-to-br dark:from-slate-800 dark:to-blue-950/90 rounded-xl shadow-2xl dark:border dark:border-sky-700/50 transform transition-all duration-300 ease-in-out scale-95 opacity-0"
             x-show="open" {{-- Jika menggunakan Alpine untuk transisi modal --}}
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <h3 class="mb-5 text-xl font-bold text-gray-800 dark:text-sky-300">Konfirmasi Penilaian</h3>
            <p class="mb-8 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                Berdasarkan penilaian yang dilakukan, apakah saudara setuju aktivitas tersebut diatas memiliki capability level? (Semua aktivitas harus bernilai F untuk capability level tertinggi).
            </p>
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                <button type="button" id="confirmNo"
                        class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500 rounded-lg shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-slate-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                    Tidak Setuju
                </button>
                <button type="button" id="confirmYes"
                        class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-lg shadow-lg hover:shadow-xl hover:shadow-sky-500/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                    Setuju
                </button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // console.log('[MODAL_LOGIC] DOMContentLoaded fired.');

        const form = document.getElementById('quisionerForm');
        const submitButton = document.getElementById('submitQuisioner');
        const modal = document.getElementById('confirmationModal');
        const modalPanel = modal ? modal.querySelector('div') : null; // Panel dalam modal untuk transisi
        const confirmYesButton = document.getElementById('confirmYes');
        const confirmNoButton = document.getElementById('confirmNo');
        const userConfirmationInput = document.getElementById('user_confirmation_input');

        // Pemeriksaan elemen (opsional, bisa dihapus jika sudah yakin)
        if (!form) console.error('[MODAL_LOGIC] Form (#quisionerForm) NOT FOUND');
        if (!submitButton && (form && form.elements.length > 1)) console.error('[MODAL_LOGIC] Submit Button (#submitQuisioner) NOT FOUND'); // Hanya error jika ada form dan quisioner
        if (!modal) console.error('[MODAL_LOGIC] Modal (#confirmationModal) NOT FOUND');
        if (!modalPanel) console.error('[MODAL_LOGIC] Modal Panel (div child of modal) NOT FOUND');
        if (!confirmYesButton) console.error('[MODAL_LOGIC] Confirm Yes Button (#confirmYes) NOT FOUND');
        if (!confirmNoButton) console.error('[MODAL_LOGIC] Confirm No Button (#confirmNo) NOT FOUND');
        if (!userConfirmationInput) console.error('[MODAL_LOGIC] User Confirmation Input (#user_confirmation_input) NOT FOUND');

        function showModal() {
            if (!modal || !modalPanel) return;
            modal.classList.remove('hidden');
            modal.style.display = 'flex'; // Pastikan display flex
            // Trigger reflow untuk memulai transisi
            modal.offsetHeight;
            modal.classList.remove('opacity-0');
            if (modalPanel) modalPanel.classList.remove('opacity-0', 'scale-95');
            // console.log('[MODAL_LOGIC] Modal shown.');
        }

        function hideModal() {
            if (!modal || !modalPanel) return;
            modal.classList.add('opacity-0');
            if (modalPanel) modalPanel.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.style.display = 'none'; // Pastikan disembunyikan setelah transisi
                // console.log('[MODAL_LOGIC] Modal hidden.');
            }, 300); // Sesuaikan dengan durasi transisi
        }

        if (form && submitButton && modal && confirmYesButton && confirmNoButton && userConfirmationInput && modalPanel) {
            // console.log('[MODAL_LOGIC] All elements found. Attaching listeners.');

            submitButton.addEventListener('click', function(event) {
                event.preventDefault();
                // console.log('[MODAL_LOGIC] "Kirim Jawaban" button clicked.');

                if (!form.checkValidity()) {
                    // console.log('[MODAL_LOGIC] Form is not valid. Reporting validity.');
                    form.reportValidity();
                    return;
                }
                // console.log('[MODAL_LOGIC] Form is valid. Showing confirmation modal.');
                showModal();
            });

            confirmNoButton.addEventListener('click', function() {
                // console.log('[MODAL_LOGIC] "Tidak Setuju" button clicked.');
                hideModal();
            });

            confirmYesButton.addEventListener('click', function() {
                // console.log('[MODAL_LOGIC] "Setuju" button clicked.');
                userConfirmationInput.value = 'setuju';
                hideModal(); // Sembunyikan modal sebelum submit
                // console.log('[MODAL_LOGIC] Submitting form programmatically.');
                setTimeout(() => form.submit(), 50); // Small delay to ensure modal hide transition starts
            });
        } else if (form && form.elements.length <= 1 && !submitButton) {
            // Tidak ada quisioner, jadi tidak ada tombol submit, ini OK.
            // console.log('[MODAL_LOGIC] No questionnaires, submit button not expected.');
        }
        else {
            console.error('[MODAL_LOGIC] ERROR: One or more crucial elements for modal were NOT FOUND. Check IDs.');
        }
    });
    </script>
</x-app-layout>

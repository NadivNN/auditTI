<x-app-layout> {{-- Asumsi Anda menggunakan layout yang sama, atau buat layout khusus admin --}}
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-700 dark:text-sky-300 tracking-wide animate-fadeInDown">
            Admin - Permintaan Pengisian Ulang Kuesioner
        </h2>
    </x-slot>

    {{-- Pastikan CSS animasi ini ada di file CSS utama atau tag <style> di layout. --}}
    <style>
        @keyframes fadeInDown { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        /* Variasi delay animasi */
        .animation-delay-100 { animation-delay: 0.1s; opacity: 0; }
        .animation-delay-200 { animation-delay: 0.2s; opacity: 0; }
        .animation-delay-300 { animation-delay: 0.3s; opacity: 0; }

        .animate-fadeInDown { animation: fadeInDown 0.6s ease-out forwards; }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

        /* Styling tambahan untuk select agar lebih pas dengan tema di dark mode */
        .custom-select-dark {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2360a5fa' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 sm:p-8 bg-white dark:bg-slate-800/70 dark:backdrop-blur-md shadow-xl dark:shadow-blue-950/40 sm:rounded-xl dark:border dark:border-blue-700/30 animate-fadeInUp">
                <h3 class="mb-8 text-2xl font-bold tracking-tight text-gray-800 dark:text-sky-300">
                    Daftar Permintaan Pengisian Ulang
                </h3>

                @if(session('success'))
                    <div class="mb-6 p-4 text-sm rounded-lg text-green-700 bg-green-100 dark:bg-green-700/20 dark:text-green-300 border border-green-600/30 animate-fadeInDown" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 text-sm rounded-lg text-red-700 bg-red-100 dark:bg-red-700/20 dark:text-red-300 border border-red-600/30 animate-fadeInDown" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Filter Status --}}
                <div class="mb-6">
                    <form method="GET" action="{{ route('resubmissions.index') }}" class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <label for="status_filter" class="text-sm font-semibold text-gray-700 dark:text-sky-200">Filter Status:</label>
                        <select name="status" id="status_filter"
                                class="custom-select-dark block w-full sm:w-auto px-4 py-2.5 text-sm bg-white dark:bg-slate-700/80 border border-gray-300 dark:border-slate-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:text-gray-100 transition-colors duration-150"
                                onchange="this.form.submit()">
                            <option value="all" {{ $currentStatus == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $currentStatus == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $currentStatus == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ $currentStatus == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <noscript><button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">Filter</button></noscript>
                    </form>
                </div>

                <div class="overflow-x-auto shadow-lg rounded-xl dark:border dark:border-slate-700/80">
                    <table class="min-w-full">
                        <thead class="dark:bg-slate-700/80">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Pengguna</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Level</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Kategori & Item</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Tgl. Request</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Status</th>
                                <th scope="col" class="px-6 py-4 text-xs font-semibold tracking-wider text-left text-gray-500 dark:text-sky-300 uppercase border-b-2 dark:border-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800">
                            @forelse ($requests as $req)
                                <tr class="dark:hover:bg-slate-700/60 transition-colors duration-150">
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-sky-100 whitespace-nowrap border-b dark:border-slate-700">{{ $req->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap border-b dark:border-slate-700">{{ $req->level->nama_level ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap border-b dark:border-slate-700">
                                        {{ $req->level->kategori->nama ?? 'N/A' }} <br>
                                        <span class="text-xs dark:text-gray-400">{{ $req->level->kategori->cobitItem->nama_item ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap border-b dark:border-slate-700">{{ $req->requested_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b dark:border-slate-700">
                                        @if($req->status == 'pending')
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 text-amber-700 bg-amber-100 dark:bg-amber-500/20 dark:text-amber-300 border border-amber-500/30 rounded-full">Pending</span>
                                        @elseif($req->status == 'approved')
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 text-emerald-700 bg-emerald-100 dark:bg-emerald-500/20 dark:text-emerald-300 border border-emerald-500/30 rounded-full">Approved</span>
                                        @elseif($req->status == 'rejected')
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 text-red-700 bg-red-100 dark:bg-red-500/20 dark:text-red-300 border border-red-500/30 rounded-full">Rejected</span>
                                        @elseif($req->status == 'completed')
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 text-sky-700 bg-sky-100 dark:bg-sky-500/20 dark:text-sky-300 border border-sky-500/30 rounded-full">Completed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 space-x-3 text-sm font-medium whitespace-nowrap border-b dark:border-slate-700">
                                        @if ($req->status == 'pending')
                                            <form action="{{ route('resubmissions.approve', $req->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="font-semibold text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors duration-150">Approve</button>
                                            </form>
                                            <button type="button" onclick="openRejectModal({{ $req->id }}, '{{ addslashes($req->user->name) }}', '{{ addslashes($req->level->nama_level) }}')" class="font-semibold text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-150">
                                                Reject
                                            </button>
                                        @else
                                            <span class="text-gray-400 dark:text-slate-500">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-sm text-center text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                        Tidak ada permintaan yang cocok dengan filter saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{-- Asumsi pagination views sudah di-publish dan bisa di-style jika perlu,
                         atau menggunakan style default Tailwind pagination yang cukup baik. --}}
                    {{ $requests->appends(['status' => $currentStatus])->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Reject dengan Catatan --}}
    <div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-slate-900/80 backdrop-blur-sm transition-opacity duration-300 ease-in-out opacity-0">
        <div class="w-full max-w-md p-6 sm:p-8 mx-4 bg-white dark:bg-gradient-to-br dark:from-slate-800 dark:to-blue-950/90 rounded-xl shadow-2xl dark:border dark:border-sky-700/50 transform transition-all duration-300 ease-in-out scale-95 opacity-0">
            <h3 class="mb-5 text-xl font-bold text-gray-800 dark:text-sky-300">Tolak Permintaan Pengisian Ulang</h3>
            <form id="rejectForm" method="POST" action=""> {{-- Action akan diisi oleh JavaScript --}}
                @csrf
                <p class="mb-4 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                    Anda akan menolak permintaan dari <strong id="rejectUserName" class="font-semibold text-sky-300"></strong> untuk level <strong id="rejectLevelName" class="font-semibold text-sky-300"></strong>.
                </p>
                <div>
                    <label for="admin_notes" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-sky-200">Catatan (Opsional):</label>
                    <textarea name="admin_notes" id="admin_notes" rows="3"
                              class="block w-full mt-1 text-sm border-gray-300 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-100 focus:border-sky-500 dark:focus:border-sky-500 focus:ring-sky-500 dark:focus:ring-sky-500 rounded-lg shadow-sm placeholder:text-gray-400 dark:placeholder:text-slate-400 transition-colors duration-150"></textarea>
                </div>
                <div class="flex flex-col sm:flex-row justify-end mt-8 space-y-3 sm:space-y-0 sm:space-x-4">
                    <button type="button" onclick="closeRejectModal()"
                            class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500 rounded-lg shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-slate-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                        Batal
                    </button>
                    <button type="submit"
                            class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-red-600 via-rose-700 to-red-700 hover:from-red-700 hover:to-rose-800 rounded-lg shadow-lg hover:shadow-xl hover:shadow-red-500/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-red-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                        Tolak Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const rejectModal = document.getElementById('rejectModal');
        const rejectModalPanel = rejectModal ? rejectModal.querySelector('div') : null; // Panel dalam modal
        const rejectForm = document.getElementById('rejectForm');
        const rejectUserName = document.getElementById('rejectUserName');
        const rejectLevelName = document.getElementById('rejectLevelName');

        function showModal(modalElement, panelElement) {
            if (!modalElement || !panelElement) return;
            modalElement.classList.remove('hidden');
            modalElement.style.display = 'flex';
            // Trigger reflow
            modalElement.offsetHeight;
            modalElement.classList.remove('opacity-0');
            panelElement.classList.remove('opacity-0', 'scale-95');
        }

        function hideModal(modalElement, panelElement) {
            if (!modalElement || !panelElement) return;
            modalElement.classList.add('opacity-0');
            panelElement.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modalElement.classList.add('hidden');
                modalElement.style.display = 'none';
                if(modalElement === rejectModal && rejectForm) rejectForm.reset(); // Reset form reject jika itu modal reject
            }, 300); // Sesuaikan durasi transisi
        }

        function openRejectModal(requestId, userName, levelName) {
            if (rejectModal && rejectForm && rejectUserName && rejectLevelName && rejectModalPanel) {
                rejectForm.action = `{{ url('admin/resubmission-requests') }}/${requestId}/reject`; // Sesuaikan dengan route Anda
                rejectUserName.textContent = userName;
                rejectLevelName.textContent = levelName;
                showModal(rejectModal, rejectModalPanel);
            } else {
                console.error('Elemen modal reject tidak ditemukan.');
            }
        }

        function closeRejectModal() {
            if (rejectModal && rejectModalPanel) {
                hideModal(rejectModal, rejectModalPanel);
            }
        }
        // Optional: Klik di luar modal untuk menutup
        if (rejectModal) {
            rejectModal.addEventListener('click', function(event) {
                if (event.target === rejectModal) {
                    closeRejectModal();
                }
            });
        }
    </script>
</x-app-layout>

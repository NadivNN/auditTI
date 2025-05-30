<x-app-layout> {{-- Asumsi Anda menggunakan layout yang sama, atau buat layout khusus admin --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Admin - Permintaan Pengisian Ulang Kuesioner
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <h3 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">
                    Daftar Permintaan
                </h3>

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

                {{-- Filter Status --}}
                <div class="mb-4">
                    <form method="GET" action="{{ route('resubmissions.index') }}" class="flex items-center space-x-2">
                        <label for="status_filter" class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter Status:</label>
                        <select name="status" id="status_filter" class="block w-auto px-3 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" onchange="this.form.submit()">
                            <option value="all" {{ $currentStatus == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $currentStatus == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $currentStatus == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ $currentStatus == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <noscript><button type="submit" class="px-3 py-2 text-sm text-white bg-blue-600 rounded-md">Filter</button></noscript>
                    </form>
                </div>


                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Pengguna</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Level</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Kategori & Item</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Tgl. Request</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Status</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($requests as $req)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">{{ $req->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap dark:text-white">{{ $req->level->nama_level ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">
                                        {{ $req->level->kategori->nama ?? 'N/A' }} <br>
                                        <span class="text-xs">{{ $req->level->kategori->cobitItem->nama_item ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-300">{{ $req->requested_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($req->status == 'pending')
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                                Pending
                                            </span>
                                        @elseif($req->status == 'approved')
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                Approved
                                            </span>
                                        @elseif($req->status == 'rejected')
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                Rejected
                                            </span>
                                        @elseif($req->status == 'completed')
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100">
                                                Completed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 space-x-2 text-sm font-medium whitespace-nowrap">
                                        @if ($req->status == 'pending')
                                            <form action="{{ route('resubmissions.approve', $req->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">Approve</button>
                                            </form>
                                            <button type="button" onclick="openRejectModal({{ $req->id }}, '{{ $req->user->name }}', '{{ $req->level->nama_level }}')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Reject
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        Tidak ada permintaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $requests->appends(['status' => $currentStatus])->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Reject dengan Catatan --}}
    <div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-60">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Tolak Permintaan Pengisian Ulang</h3>
            <form id="rejectForm" method="POST" action=""> {{-- Action akan diisi oleh JavaScript --}}
                @csrf
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-300">
                    Anda akan menolak permintaan dari <strong id="rejectUserName"></strong> untuk level <strong id="rejectLevelName"></strong>.
                </p>
                <div>
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan (Opsional):</label>
                    <textarea name="admin_notes" id="admin_notes" rows="3" class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div>
                <div class="flex justify-end mt-6 space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:text-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Tolak Permintaan</button>
                </div>
            </form>
        </div>
    </div>

    
    <script>
        const rejectModal = document.getElementById('rejectModal');
        const rejectForm = document.getElementById('rejectForm');
        const rejectUserName = document.getElementById('rejectUserName');
        const rejectLevelName = document.getElementById('rejectLevelName');

        function openRejectModal(requestId, userName, levelName) {
            if (rejectModal && rejectForm && rejectUserName && rejectLevelName) {
                // Update action URL form
                // Pastikan URL route benar, contoh: /admin/resubmission-requests/{ID}/reject
                rejectForm.action = `{{ url('resubmission-requests') }}/${requestId}/reject`;
                rejectUserName.textContent = userName;
                rejectLevelName.textContent = levelName;
                rejectModal.classList.remove('hidden');
                rejectModal.style.display = 'flex';
            } else {
                console.error('Elemen modal reject tidak ditemukan.');
            }
        }

        function closeRejectModal() {
            if (rejectModal) {
                rejectModal.classList.add('hidden');
                rejectModal.style.display = 'none';
                if(rejectForm) rejectForm.reset(); // Reset form jika ada
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

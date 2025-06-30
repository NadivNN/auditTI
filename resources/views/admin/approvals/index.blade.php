{{-- resources/views/admin/approvals/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-700 dark:text-sky-300">User Approvals</h2>
    </x-slot>

    <div class="py-12 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white dark:bg-slate-800/70 sm:rounded-lg">

                @if (session('success'))
                    <div
                        class="mb-6 p-4 text-sm rounded-lg text-green-700 bg-green-100 dark:bg-green-700/20 dark:text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto shadow-md rounded-lg">
                    <table class="min-w-full">
                        <thead class="dark:bg-slate-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Name</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800">
                            @forelse($pendingUsers as $user)
                                <tr class="dark:hover:bg-slate-700/60">
                                    <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <form method="POST" action="{{ route('admin.approvals.approve', $user) }}">
                                            @csrf
                                            <button type="submit"
                                                class="font-semibold text-emerald-600 hover:text-emerald-500">Approve</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No pending approvals.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

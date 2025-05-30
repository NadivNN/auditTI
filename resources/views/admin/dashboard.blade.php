<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <h3 class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Jumlah Users</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $usersCount ?? '0' }}</p>
                </div>

                <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <h3 class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Pending Approvals</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $pendingApprovals ?? '0' }}</p>
                </div>

                <div class="p-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <h3 class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">Total Cobit Items</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $cobitItemsCount ?? '0' }}</p>
                </div>

            </div>

            <div class="p-6 mt-10 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <h3 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-300">Welcome, Admin!</h3>
                <p class="text-gray-600 dark:text-gray-400">This is your admin dashboard. You can manage users, Cobit
                    items, categories, levels, and questionnaires here.</p>
            </div>

        </div>
    </div>
</x-app-layout>

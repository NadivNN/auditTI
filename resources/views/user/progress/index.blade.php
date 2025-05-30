<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Progres Kuesioner Saya') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
        <h3 class="text-2xl font-semibold mb-2">Halo, {{ $user->name }}!</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Berikut adalah ringkasan progres pengerjaan kuesioner Anda.</p>
        @if (empty($progressData))
                <p class="text-center text-gray-500 dark:text-gray-400 py-8">
                    Belum ada data progres yang tersedia atau belum ada Cobit Item yang bisa ditampilkan.
                </p>
            @else
                @foreach ($progressData as $cobitItem)
                    <div class="mb-8 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $cobitItem['nama_item'] }}</h4>
                            @if($cobitItem['total_levels_in_item'] > 0)
                                @php
                                    $itemPercentage = ($cobitItem['completed_levels_in_item'] / $cobitItem['total_levels_in_item']) * 100;
                                @endphp
                                <span class="text-sm font-semibold {{ $itemPercentage == 100 ? 'text-green-500' : 'text-yellow-500' }}">
                                    {{ round($itemPercentage) }}% Selesai
                                    ({{ $cobitItem['completed_levels_in_item'] }} / {{ $cobitItem['total_levels_in_item'] }} Level)
                                </span>
                            @endif
                        </div>

                        @if (empty($cobitItem['kategoris']))
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada kategori dalam item ini.</p>
                        @else
                            @foreach ($cobitItem['kategoris'] as $kategori)
                                <div class="mb-6 pl-4 border-l-4 {{ $kategori['completed_levels_in_kategori'] == $kategori['total_levels_in_kategori'] && $kategori['total_levels_in_kategori'] > 0 ? 'border-green-500' : 'border-blue-500' }} dark:{{ $kategori['completed_levels_in_kategori'] == $kategori['total_levels_in_kategori'] && $kategori['total_levels_in_kategori'] > 0 ? 'border-green-400' : 'border-blue-400' }}">
                                    <div class="flex justify-between items-center mb-2">
                                        <h5 class="text-lg font-semibold">{{ $kategori['nama_kategori'] }}</h5>
                                        @if($kategori['total_levels_in_kategori'] > 0)
                                             @php
                                                $kategoriPercentage = ($kategori['completed_levels_in_kategori'] / $kategori['total_levels_in_kategori']) * 100;
                                            @endphp
                                            <span class="text-xs {{ $kategoriPercentage == 100 ? 'text-green-500' : 'text-yellow-500' }}">
                                                {{ round($kategoriPercentage) }}% Selesai
                                                ({{ $kategori['completed_levels_in_kategori'] }} / {{ $kategori['total_levels_in_kategori'] }} Level)
                                            </span>
                                        @endif
                                    </div>

                                    @if (empty($kategori['levels']))
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Tidak ada level dalam kategori ini.</p>
                                    @else
                                        <ul class="space-y-3">
                                            @foreach ($kategori['levels'] as $level)
                                                <li class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-md shadow-sm">
                                                    {{-- <div class="flex items-center justify-between mb-1">
                                                        <a href="{{ $level['url'] }}" class="text-md font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                                                            {{ $level['nama_level'] }}
                                                        </a>
                                                        <span class="text-xs font-medium {{ $level['is_completed'] ? 'text-green-600 dark:text-green-400' : 'text-orange-500 dark:text-orange-400' }}">
                                                            {{ $level['answered_quisioners'] }} / {{ $level['total_quisioners'] }} Pertanyaan
                                                            @if($level['is_completed']) (Selesai) @endif
                                                        </span>
                                                    </div> --}}
                                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                                                        <div class="h-2.5 rounded-full {{ $level['percentage'] == 100 ? 'bg-green-500' : 'bg-blue-500' }}" style="width: {{ $level['percentage'] }}%"></div>
                                                    </div>
                                                    <p class="text-right text-xs mt-1 text-gray-500 dark:text-gray-400">{{ $level['percentage'] }}%</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
</div>
</x-app-layout>
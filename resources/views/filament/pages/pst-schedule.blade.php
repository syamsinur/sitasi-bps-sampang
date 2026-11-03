<x-filament-panels::page>
    {{-- push style custom --}}
    @push('styles')
        @vite('resources/css/app.css')
    @endpush

    {{-- title --}}
    <div class="space-y-4 w-full">
    
        {{-- schedule day --}}
        <div class="flex flex-wrap gap-4 justify-center">
            @foreach($schedulePetugas as $item)
                <div class="w-40 p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border-2! border-orange-400! border-l-8! dark:border-gray-800! text-center flex flex-col items-center justify-between">
                    <div>
                        <span class="text-sm font-bold uppercase tracking-wider text-primary-600 dark:text-primary-400">
                            {{ $item['hari'] }}
                        </span>
                    </div>

                    <div class="my-4">
                        @if($item['petugas'])
                            {{-- foto --}}
                            <div class="w-24 h-24">
                            <img src="{{ asset('storage/' . $item['petugas']->foto) }}" 
                                alt="{{ $item['petugas']->name }}" 
                                class="w-full h-full object-cover rounded-xl">
                            </div>
                            <p class="mt-2 font-semibold text-sm text-gray-900 dark:text-white">
                                {{ $item['petugas']->name }}
                            </p>
                        @else
                            <div class="w-14 h-14 mx-auto rounded-full bg-gray-50 dark:bg-gray-800/50 flex items-center justify-center mb-2">
                                <span class="text-xs text-gray-400">-</span>
                            </div>
                            <p class="text-xs text-gray-400 italic">Belum dijadwalkan</p>
                        @endif
                    </div>

                    <div class="text-xs text-gray-400">
                        {{ $item['petugas']->nomor_hp }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- line --}}
    <hr class="border-gray-200 dark:border-gray-800 my-6">

    {{-- master petugas --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold tracking-tight text-gray-950 dark:text-white">Daftar Petugas PST</h2>
        </div>

        <div class="bg-white dark:bg-gray-900 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800">
            {{-- table petugas --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-orange-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3">Urutan</th>
                            <th class="px-4 py-3">Nama Petugas</th>
                            <th class="px-4 py-3">Kontak / Keterangan</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugasPst as $index => $petugas)
                            <tr class="border-b dark:border-gray-800">
                                <td class="px-4 py-3 font-bold text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $petugas->name }}</td>
                                <td class="px-4 py-3">{{ $petugas->nomor_hp ?? '-' }}</td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    {{-- Tombol Geser ke Atas --}}
                                    <button wire:click="moveOfficer({{ $petugas->id }}, 'up')" 
                                            class="px-2.5 py-1 bg-gray-100 hover:bg-green-500! text-gray-700 hover:text-white! rounded-lg text-xs font-bold transition dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                            title="Geser ke Atas">
                                        &uarr; Naik
                                    </button>
                                    
                                    {{-- Tombol Geser ke Bawah --}}
                                    <button wire:click="moveOfficer({{ $petugas->id }}, 'down')" 
                                            class="px-2.5 py-1 bg-gray-100 hover:bg-red-500! text-gray-700 hover:text-white! rounded-lg text-xs font-bold transition dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                                            title="Geser ke Bawah">
                                        &darr; Turun
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-gray-400">Belum ada data petugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
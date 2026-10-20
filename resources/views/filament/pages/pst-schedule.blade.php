<x-filament-panels::page>
    {{-- title --}}
    <div class="space-y-4 w-full">
        <h2 class="text-lg font-bold tracking-tight text-gray-950 dark:text-white">Jadwal Petugas PST Mingguan</h2>
    
        {{-- schedule day --}}
        <div class="flex flex-wrap gap-4 justify-center">
            @foreach($schedulePetugas as $item)
                <div class="p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 text-center flex flex-col items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-primary-600 dark:text-primary-400">
                            {{ $item['hari'] }}
                        </span>
                    </div>

                    <div class="my-4">
                        @if($item['petugas'])
                            {{-- foto --}}
                            <div class="w-16 h-16">
                            <img src="{{ asset('storage/' . $item['petugas']->foto) }}" 
                                alt="{{ $item['petugas']->name }}" 
                                class="w-full h-full object-cover rounded-full">
                            </div>
                            <p class="font-semibold text-sm text-gray-900 dark:text-white">
                                {{ $item['petugas']->name }}
                            </p>
                        @else
                            <div class="w-14 h-14 mx-auto rounded-full bg-gray-50 dark:bg-gray-800/50 flex items-center justify-center mb-2">
                                <span class="text-xs text-gray-400">-</span>
                            </div>
                            <p class="text-xs text-gray-400 italic">Belum dijadwalkan</p>
                        @endif
                    </div>

                    <div class="text-[10px] text-gray-400">
                        PST BPS Sampang
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- GARIS PEMBATAS -->
    <hr class="border-gray-200 dark:border-gray-800 my-6">

    <!-- BAGIAN BAWAH: DAFTAR / MASTER DATA PETUGAS -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold tracking-tight text-gray-950 dark:text-white">Daftar Master Petugas PST</h2>
        </div>

        <div class="bg-white dark:bg-gray-900 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800">
            <!-- Tabel sederhana atau list master data petugas -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama Petugas</th>
                            <th class="px-4 py-3">Kontak / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugasPst as $index => $petugas)
                            <tr class="border-b dark:border-gray-800">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $petugas->name }}</td>
                                <td class="px-4 py-3">{{ $petugas->nomor_hp ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-gray-400">Belum ada data petugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-filament-panels::page>
<div
    class="mx-3 mt-6 p-4 bg-white dark:bg-gray-900 rounded-2xl shadow-sm !border border-orange-200 dark:border-gray-800 text-center flex flex-col items-center justify-between">
    <p class="text-[11px] font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 mb-3">
        Petugas Hari Ini ({{ $namaHariIni }})
    </p>

    @if (isset($petugasHariIni) && $petugasHariIni)
        <div
            class="w-20 h-20 mt-2 mb-3 rounded-full overflow-hidden shadow-sm border-2 border-orange-300 dark:border-gray-700 shrink-0 flex items-center justify-center"
            style="width: 80px; height: 80px; min-width: 80px; min-height: 80px;">
            @if ($petugasHariIni->foto_url)
                <img src="{{ $petugasHariIni->foto_url }}" alt="{{ $petugasHariIni->name }}"
                    class="w-full h-full rounded-full object-cover"
                    style="width: 80px; height: 80px; object-fit: cover;">
            @else
                <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="currentColor"
                        viewBox="0 0 24 24" style="width: 40px; height: 40px;">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>
            @endif
        </div>

        <p class="font-bold text-sm text-gray-900 dark:text-white">
            {{ $petugasHariIni->name }}
        </p>

        <p class="text-xs text-gray-400 mt-1">
            {{ $petugasHariIni->nomor_hp ?? '-' }}
        </p>
    @else
        <p class="text-xs text-gray-400 italic py-4">Tidak ada jadwal</p>
    @endif
</div>

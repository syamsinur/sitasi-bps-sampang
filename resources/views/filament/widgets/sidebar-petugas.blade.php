<div class="mx-3 mt-6 p-4 bg-white dark:bg-gray-900 rounded-2xl shadow-sm !border border-orange-200 dark:border-gray-800 text-center flex flex-col items-center justify-between">
    <p class="text-[11px] font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400 mb-3">
        Petugas Hari Ini ({{ $namaHariIni }})
    </p>
    
    @if(isset($petugasHariIni) && $petugasHariIni)
        <div class="w-20 h-20 mt-2 mb-3 rounded-xl overflow-hidden shadow-sm border border-orange-300 dark:border-gray-700">
            <img src="{{ asset('storage/' . $petugasHariIni->foto) }}" 
                 alt="{{ $petugasHariIni->name }}" 
                 class="w-full h-full object-cover">
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
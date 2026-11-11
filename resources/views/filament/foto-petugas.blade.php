@php
    $petugas = $getRecord();
    $fotoUrl = $petugas?->foto_url;
@endphp

<div class="flex items-center justify-center py-2">
    <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700 shadow-sm border-2 border-orange-200 dark:border-gray-600 shrink-0 flex items-center justify-center" style="width: 128px; height: 128px; min-width: 128px; min-height: 128px;">
        @if ($fotoUrl)
            <img src="{{ $fotoUrl }}" alt="{{ $petugas->name }}" class="w-full h-full rounded-full object-cover" style="width: 128px; height: 128px; object-fit: cover;">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px;">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </div>
        @endif
    </div>
</div>

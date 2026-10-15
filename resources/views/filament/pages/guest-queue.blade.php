<x-filament-panels::page>
    <div wire:poll.3s class="grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- Kolom kiri: PST --}}
        <div class="rounded-xl border border-green-200 bg-white p-8 text-center shadow-sm dark:border-green-900 dark:bg-gray-900">

            <h2 class="text-xl font-bold text-green-600">
                ANTREAN PST
            </h2>

            <p class="mt-6 text-5xl font-extrabold text-green-600">
                {{ $pst['nomor'] }}
            </p>

            <p class="mt-4 text-sm text-gray-500">
                Total tamu bulan ini
            </p>

            <p class="text-2xl font-bold">
                {{ $pst['total'] }} tamu
            </p>
        </div>

        {{-- Kolom kanan: Non PST --}}
        <div class="rounded-xl border border-blue-200 bg-white p-8 text-center shadow-sm dark:border-blue-900 dark:bg-gray-900">

            <h2 class="text-xl font-bold text-blue-600">
                ANTREAN NON PST
            </h2>

            <p class="mt-6 text-5xl font-extrabold text-blue-600">
                {{ $nonPst['nomor'] }}
            </p>

            <p class="mt-4 text-sm text-gray-500">
                Total tamu bulan ini
            </p>

            <p class="text-2xl font-bold">
                {{ $nonPst['total'] }} tamu
            </p>
        </div>

    </div>
</x-filament-panels::page>

<x-filament-panels::page>
    <div wire:poll.3s class="space-y-6">
        {{-- Informasi pembaruan --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Ringkasan Antrean
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Nomor antrean dan jumlah tamu bulan berjalan.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 rounded-full border border-green-200 bg-green-50 px-3 py-2 text-xs font-medium text-green-700 dark:border-green-900 dark:bg-green-950 dark:text-green-400">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-green-500"></span>
                </span>
                Pembaruan otomatis
            </div>
        </div>


        {{-- Kartu Antrean: Kiri dan Kanan --}}
        <div class="grid grid-cols-2 gap-4 xl:gap-8">

            {{-- PST: KIRI --}}
            <div class="relative overflow-hidden rounded-2xl border-2 border-emerald-500 bg-white shadow-lg dark:border-emerald-400 dark:bg-gray-900">

                <div class="h-3 bg-emerald-500"></div>

                <div class="p-4 sm:p-6 lg:p-8">

                    {{-- Header PST --}}
                    <div class="flex flex-col items-center gap-3 text-center sm:flex-row sm:text-left">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200 sm:h-16 sm:w-16">
                            <x-heroicon-o-building-office-2 class="h-8 w-8 sm:h-9 sm:w-9" />
                        </div>

                        <div>
                            <h4 class="text-xl font-black text-gray-900 dark:text-white sm:text-2xl lg:text-3xl">
                                ANTREAN PST
                            </h4>
                            <p class="mt-1 text-sm font-medium text-gray-600 dark:text-gray-300 sm:text-base">
                                Pelayanan Statistik Terpadu
                            </p>
                        </div>
                    </div>

                    {{-- Nomor Antrean PST --}}
                    <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-2 py-8 text-center dark:border-emerald-800 dark:bg-emerald-950 sm:mt-8 sm:px-4 sm:py-10 lg:py-14">

                        <p class="text-sm font-extrabold uppercase tracking-widest text-emerald-800 dark:text-emerald-200 sm:text-base lg:text-lg">
                            NOMOR ANTREAN
                        </p>

                        <p class="mt-4 break-words text-5xl font-black leading-tight tracking-tight text-emerald-700 sm:text-6xl lg:text-7xl xl:text-8xl dark:text-emerald-300">
                            {{ $pst['nomor'] }}
                        </p>

                        <div class="mx-auto mt-5 h-1.5 w-20 rounded-full bg-emerald-500 sm:w-28"></div>
                    </div>

                    {{-- Total Tamu PST --}}
                    <div class="mt-6 flex flex-col items-center justify-between gap-3 border-t-2 border-gray-100 pt-5 dark:border-gray-700 sm:flex-row">

                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                <x-heroicon-o-users class="h-6 w-6" />
                            </div>

                            <div>
                                <p class="text-sm font-bold text-gray-700 dark:text-gray-200 sm:text-base">
                                    TOTAL TAMU
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                                    Bulan berjalan
                                </p>
                            </div>
                        </div>

                        <div class="flex items-baseline gap-2">
                            <p class="text-4xl font-black text-gray-900 dark:text-white sm:text-5xl lg:text-6xl">
                                {{ number_format($pst['total'], 0, ',', '.') }}
                            </p>
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-300 sm:text-base">
                                orang
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            {{-- NON PST: KANAN --}}
            <div class="relative overflow-hidden rounded-2xl border-2 border-blue-500 bg-white shadow-lg dark:border-blue-400 dark:bg-gray-900">

                <div class="h-3 bg-blue-600"></div>

                <div class="p-4 sm:p-6 lg:p-8">

                    {{-- Header Non PST --}}
                    <div class="flex flex-col items-center gap-3 text-center sm:flex-row sm:text-left">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200 sm:h-16 sm:w-16">
                            <x-heroicon-o-user-group class="h-8 w-8 sm:h-9 sm:w-9" />
                        </div>

                        <div>
                            <h4 class="text-xl font-black text-gray-900 dark:text-white sm:text-2xl lg:text-3xl">
                                ANTREAN NON PST
                            </h4>
                            <p class="mt-1 text-sm font-medium text-gray-600 dark:text-gray-300 sm:text-base">
                                Layanan di luar PST
                            </p>
                        </div>
                    </div>

                    {{-- Nomor Antrean Non PST --}}
                    <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 px-2 py-8 text-center dark:border-blue-800 dark:bg-blue-950 sm:mt-8 sm:px-4 sm:py-10 lg:py-14">

                        <p class="text-sm font-extrabold uppercase tracking-widest text-blue-800 dark:text-blue-200 sm:text-base lg:text-lg">
                            NOMOR ANTREAN
                        </p>

                        <p class="mt-4 break-words text-5xl font-black leading-tight tracking-tight text-blue-700 sm:text-6xl lg:text-7xl xl:text-8xl dark:text-blue-300">
                            {{ $nonPst['nomor'] }}
                        </p>

                        <div class="mx-auto mt-5 h-1.5 w-20 rounded-full bg-blue-600 sm:w-28"></div>
                    </div>

                    {{-- Total Tamu Non PST --}}
                    <div class="mt-6 flex flex-col items-center justify-between gap-3 border-t-2 border-gray-100 pt-5 dark:border-gray-700 sm:flex-row">

                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                <x-heroicon-o-users class="h-6 w-6" />
                            </div>

                            <div>
                                <p class="text-sm font-bold text-gray-700 dark:text-gray-200 sm:text-base">
                                    TOTAL TAMU
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                                    Bulan berjalan
                                </p>
                            </div>
                        </div>

                        <div class="flex items-baseline gap-2">
                            <p class="text-4xl font-black text-gray-900 dark:text-white sm:text-5xl lg:text-6xl">
                                {{ number_format($nonPst['total'], 0, ',', '.') }}
                            </p>
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-300 sm:text-base">
                                orang
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
</x-filament-panels::page>
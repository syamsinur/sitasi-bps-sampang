<x-filament-panels::page>
    <div wire:poll.3s="checkForNewQueue" class="space-y-2">
        {{-- Informasi pembaruan --}}
        <div
            class="inline-flex items-center gap-2 rounded-full border border-green-200 bg-green-50 px-3 text-xs font-medium text-green-700 dark:border-green-900 dark:bg-green-950 dark:text-green-400">
            <span class="relative flex h-2 w-2">
                <span
                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-green-500"></span>
            </span>
            Pembaruan otomatis
        </div>

        {{-- Kartu Antrean: Kiri dan Kanan --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

            {{-- PST: KIRI --}}
            <div
                class="relative min-w-0 overflow-hidden rounded-2xl border-2 border-emerald-500 bg-white shadow-lg dark:border-emerald-400 dark:bg-gray-900">

                <div class="h-3 bg-emerald-500"></div>

                <div class="p-4 sm:p-6 lg:p-8">

                    {{-- Header PST --}}
                    <div class="flex flex-col items-center gap-3 text-center sm:flex-row sm:text-left">
                        <div
                            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200 sm:h-16 sm:w-16">
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
                    <div
                        class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-2 py-8 text-center dark:border-emerald-800 dark:bg-emerald-950 sm:mt-8 sm:px-4 sm:py-10 lg:py-14">

                        <p
                            class="text-sm font-extrabold uppercase tracking-widest text-emerald-800 dark:text-emerald-200 sm:text-base lg:text-lg">
                            NOMOR ANTREAN
                        </p>

                        <p
                            class="mt-4 break-words text-4xl font-black leading-tight tracking-tight text-emerald-700 sm:text-5xl lg:text-6xl xl:text-7xl dark:text-emerald-300">
                            {{ $pst['nomor'] }}
                        </p>

                        <div class="mx-auto mt-5 h-1.5 w-20 rounded-full bg-emerald-500 sm:w-28"></div>
                    </div>

                    {{-- Total Tamu PST --}}
                    <div
                        class="mt-6 flex flex-col items-center justify-between gap-3 border-t-2 border-gray-100 pt-5 dark:border-gray-700 sm:flex-row">

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
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
                            <p class="text-3xl font-black text-gray-900 dark:text-white sm:text-4xl lg:text-5xl">
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
            <div
                class="relative min-w-0 overflow-hidden rounded-2xl border-2 border-emerald-500 bg-white shadow-lg dark:border-emerald-400 dark:bg-gray-900">

                <div class="h-3 bg-blue-600"></div>

                <div class="p-4 sm:p-6 lg:p-8">

                    {{-- Header Non PST --}}
                    <div class="flex flex-col items-center gap-3 text-center sm:flex-row sm:text-left">
                        <div
                            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200 sm:h-16 sm:w-16">
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
                    <div
                        class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 px-2 py-8 text-center dark:border-blue-800 dark:bg-blue-950 sm:mt-8 sm:px-4 sm:py-10 lg:py-14">

                        <p
                            class="text-sm font-extrabold uppercase tracking-widest text-blue-800 dark:text-blue-200 sm:text-base lg:text-lg">
                            NOMOR ANTREAN
                        </p>

                        <p
                            class="mt-4 wrap-break-words text-4xl font-black leading-tight tracking-tight text-blue-700 sm:text-5xl lg:text-6xl xl:text-7xl dark:text-blue-300">
                            {{ $nonPst['nomor'] }}
                        </p>

                        <div class="mx-auto mt-5 h-1.5 w-20 rounded-full bg-blue-600 sm:w-28"></div>
                    </div>

                    {{-- Total Tamu Non PST --}}
                    <div
                        class="mt-6 flex flex-col items-center justify-between gap-3 border-t-2 border-gray-100 pt-5 dark:border-gray-700 sm:flex-row">

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
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
                            <p class="text-3xl font-black text-gray-900 dark:text-white sm:text-4xl lg:text-5xl">
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

    {{-- petugas hari ini --}}
    @if (isset($petugasHariIni) && $petugasHariIni)
        <div
            class=" absolute top-32 right-8 flex items-center gap-3 bg-white dark:bg-gray-900 px-4 py-2.5 rounded-2xl shadow-sm border !border-orange-200 dark:border-gray-800 animate-pulse">
            <div
                class="w-12 h-12 rounded-full overflow-hidden shadow-sm border border-orange-300 dark:border-gray-700 shrink-0 flex items-center justify-center"
                style="width: 48px; height: 48px; min-width: 48px; min-height: 48px;">
                @if ($petugasHariIni->foto_url)
                    <img src="{{ $petugasHariIni->foto_url }}" alt="{{ $petugasHariIni->name }}"
                        class="w-full h-full rounded-full object-cover"
                        style="width: 48px; height: 48px; object-fit: cover;">
                @else
                    <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="currentColor"
                            viewBox="0 0 24 24" style="width: 32px; height: 32px;">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>
                @endif
            </div>
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-wider text-orange-600 dark:text-orange-400">
                    Petugas Hari Ini ({{ $namaHariIni }})
                </p>
                <p class="text-xs font-bold text-gray-900 dark:text-white">
                    {{ $petugasHariIni->name }}
                </p>
            </div>
        </div>
    @endif


    {{-- Modal QR Code --}}
    @if ($showModal && $activeModalQueue)
        <div wire:key="queue-modal-{{ $activeModalQueue->id }}" x-data="{
            timer: 300,
            interval: null,
            endTime: null,
        
            init() {
                this.endTime = Date.now() + (300 * 1000);
        
                this.updateTimer();
        
                this.interval = setInterval(() => {
                    this.updateTimer();
                }, 250);
            },
        
            updateTimer() {
                const remaining = Math.max(
                    0,
                    Math.ceil((this.endTime - Date.now()) / 1000)
                );
        
                this.timer = remaining;
        
                if (remaining <= 0) {
                    this.destroy();
                    $wire.closeModal();
                }
            },
        
            destroy() {
                if (this.interval) {
                    clearInterval(this.interval);
                    this.interval = null;
                }
            }
        }" x-init="init()"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div
                class="bg-white dark:bg-gray-900 rounded-3xl p-8 max-w-lg w-full shadow-2xl text-center border border-gray-200 dark:border-gray-800">

                <div class="flex justify-between items-center mb-2">
                    <span
                        class="bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 text-xs font-extrabold px-3.5 py-1.5 rounded-full tracking-wider">
                        Antrean Baru Terdaftar!
                    </span>

                    <span class="text-xs font-bold text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full">
                        Tutup otomatis dalam
                        <span x-text="timer" class="text-emerald-600 font-black"></span>s
                    </span>
                </div>

                <h2 class="mt-4 text-4xl font-black text-gray-900 dark:text-white">
                    {{ $activeModalQueue->nomor_antrean }}
                </h2>

                <p class="mt-1 text-lg font-bold text-gray-700 dark:text-gray-200">
                    {{ $activeModalQueue->name }}
                    <span class="text-sm font-normal text-gray-500">
                        ({{ $activeModalQueue->instansi }})
                    </span>
                </p>

                <p class="text-xs text-gray-500 mt-2">
                    Silakan scan QR code di bawah ini menggunakan HP untuk memantau antrean secara real-time:
                </p>

                <div class="mt-4 inline-block bg-white p-4 rounded-2xl border shadow-md">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=170x170&data={{ route('cek.antrean', $activeModalQueue->token) }}"
                        alt="QR Code Antrean" class="rounded mx-auto">
                </div>

                <div
                    class="mt-3 bg-gray-50 dark:bg-gray-800 p-2.5 rounded-xl text-xs font-mono text-emerald-600 dark:text-emerald-400 break-all select-all">
                    {{ route('cek.antrean', $activeModalQueue->token) }}
                </div>

                <div class="mt-6 flex gap-3">
                    <button wire:click="closeModal"
                        class="w-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-bold py-3 px-6 rounded-2xl transition text-sm">
                        Tutup Sekarang
                    </button>
                </div>

            </div>
        </div>
    @endif
</x-filament-panels::page>

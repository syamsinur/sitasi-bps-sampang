<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Antrean PST BPS Sampang</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 dark:bg-slate-500 flex items-center justify-center min-h-screen p-4">
    @php
        /** @var \App\Models\WaitingList|\App\Models\GuestBook $data */
        $ratingService = app(\App\Services\QueueRatingService::class);
        $isSelesai = isset($data->status) && $data->status === 'Selesai';
        $sudahDinilai = $isSelesai ? $ratingService->hasRated($data) : false;
    @endphp

    <div class="bg-white dark:bg-slate-600 w-full max-w-md rounded-2xl shadow-lg p-6 text-center space-y-6 border border-gray-100">
        <div>
            <span class="text-xs font-semibold tracking-wider text-blue-600 uppercase bg-blue-50 px-3 py-1 rounded-full">
                Sistem Antrean Tamu
            </span>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mt-3">Halo, {{ $data->name }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-200">{{ $data->instansi }}</p>
        </div>

        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 space-y-3">
            <div>
                <p class="text-xs text-gray-500">Keperluan</p>
                <p class="font-medium text-gray-800">
                    {{ $data->keperluan }}
                    @if (!empty($data->detail_keperluan))
                        ({{ $data->detail_keperluan }})
                    @endif
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Petugas yang Melayani</p>
                <p class="font-medium text-gray-800">{{ $data->petugas ?? 'Menunggu Penugasan' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Nomor Antrean</p>
                <p class="font-medium text-gray-800">{{ $data->nomor_antrean ?? '-' }}</p>
            </div>
        </div>

        <!-- Indikator Status -->
        <div class="p-4 rounded-xl
            @if($data->status === 'Menunggu') bg-yellow-50 text-yellow-800 border border-yellow-200
            @elseif($data->status === 'Diproses') bg-blue-50 text-blue-800 border border-blue-200
            @else bg-green-50 text-green-800 border border-green-200
            @endif">
            <p class="text-xs uppercase tracking-wider font-semibold">Status Saat Ini:</p>
            <p class="text-xl font-bold mt-1">{{ $data->status }}</p>
        </div>

        @if (session('rating_success'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-xs font-medium text-emerald-800">
                {{ session('rating_success') }}
            </div>
        @endif

        @if (session('rating_error'))
            <div class="rounded-xl bg-red-50 border border-red-200 p-3 text-xs font-medium text-red-700">
                {{ session('rating_error') }}
            </div>
        @endif

        @if ($isSelesai)
            @if ($sudahDinilai)
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800">
                    Terima kasih! Penilaian Anda untuk layanan ini sudah tersimpan.
                </div>
            @else
                <div class="text-left bg-gray-50 rounded-xl p-4 border border-gray-200 space-y-4">
                    <div>
                        <h2 class="text-sm font-bold text-gray-800 text-center">Penilaian Kepuasan Layanan</h2>
                        <p class="text-xs text-gray-500 text-center mt-0.5">
                            Kasih rating yuk buat <span class="font-semibold text-gray-700">{{ $data->petugas ?? '-' }}</span>
                        </p>
                    </div>

                    <form action="{{ route('cek.antrean.rating.store', ['token' => $data->token]) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            
                            <div class="flex items-center justify-center gap-2 flex-wrap">
                                @for ($bintang = 1; $bintang <= 5; $bintang++)
                                    <label class="cursor-pointer">
                                        <input
                                            type="radio"
                                            name="rating"
                                            value="{{ $bintang }}"
                                            class="peer sr-only"
                                            {{ (int) old('rating') === $bintang ? 'checked' : '' }}
                                        >
                                        <span class="inline-flex h-10 min-w-11 items-center justify-center rounded-lg border border-gray-300 bg-white px-2.5 text-sm font-bold text-gray-700 transition peer-checked:border-amber-500 peer-checked:bg-amber-500 peer-checked:text-white hover:bg-gray-100">
                                            {{ $bintang }} ★
                                        </span>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="mt-1 text-xs text-red-600 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="comment" class="block text-xs font-semibold text-gray-700 mb-1">
                                comment / Masukan buat <span class="font-semibold text-gray-700">{{ $data->petugas ?? '-' }}</span> (Opsional)
                            </label>
                            <textarea
                                id="comment"
                                name="comment"
                                rows="3"
                                maxlength="500"
                                placeholder="Tuliskan saran atau kesan pelayanan..."
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:border-blue-500 focus:outline-none"
                            >{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-blue-600 text-white font-bold px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition cursor-pointer"
                        >
                            Kirim Penilaian
                        </button>
                    </form>
                </div>
            @endif

            <p class="text-xs text-gray-400">
                Silakan isi survey kepuasan layanan di bawah ini.
            </p>

            {{-- TOMBOL CTA GOOGLE FORM --}}
            <div class="mt-6">
                <a href="https://skd.bps.go.id/skd/s/3527" target="_blank" class="inline-block bg-blue-600 text-white font-bold px-6 py-3 rounded-lg shadow hover:bg-blue-700">
                    📝 Survei Kepuasan Layanan
                </a>
            </div>
        @else
            <p class="text-xs text-gray-400">
                Silakan tunggu di ruang tunggu. Halaman ini akan memperbarui status layanan Anda.
            </p>
        @endif
    </div>
</body>
</html>
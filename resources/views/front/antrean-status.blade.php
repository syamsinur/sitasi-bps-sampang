<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Antrean PST BPS Sampang</title>
    <!-- Menggunakan Tailwind CSS via CDN agar tampilannya rapi -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6 text-center space-y-6 border border-gray-100">
        @if (isset($data->status) && $data->status === 'Selesai')
            <div>
                <span class="text-xs font-semibold tracking-wider text-blue-600 uppercase bg-blue-50 px-3 py-1 rounded-full">
                    Sistem Antrean Tamu
                </span>
                <h1 class="text-2xl font-bold text-gray-800 mt-3">Halo, {{ $data->name }}</h1>
                <p class="text-sm text-gray-500">{{ $data->instansi }}</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 space-y-3">
                <div>
                    <p class="text-xs text-gray-500">Keperluan</p>
                    <p class="font-medium text-gray-800">{{ $data->keperluan }} ({{ $data->detail_keperluan }})</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Petugas yang Melayani</p>
                    <p class="font-medium text-gray-800">{{ $data->petugas ?? 'Menunggu Penugasan' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Nomor Antrean</p>
                    <p class="font-medium text-gray-800">{{ $data->nomor_antrean }}</p>
                </div>
            </div>

            <!-- Indikator Status -->
            <div class="p-4 rounded-xl  bg-green-50 text-green-800 border border-green-200">
                <p class="text-xs uppercase tracking-wider font-semibold">Status Saat Ini:</p>
                <p class="text-xl font-bold mt-1">{{ $data->status }}</p>
            </div>

            <p class="text-xs text-gray-400">
                Silakan isi survey kepuasan layanan di bawah ini.
            </p>

                {{-- TOMBOL CTA GOOGLE FORM --}}
                <div class="mt-6">
                    <a href="https://skd.bps.go.id/skd/s/3527" target="_blank" class="inline-block bg-blue-600 text-white font-bold px-6 py-3 rounded-lg shadow hover:bg-blue-700">
                        📝 Survei Kepuasan Layanan 
                    </a>
                </div>
            </div>
        @else 
            <div>
                <span class="text-xs font-semibold tracking-wider text-blue-600 uppercase bg-blue-50 px-3 py-1 rounded-full">
                    Sistem Antrean Tamu
                </span>
                <h1 class="text-2xl font-bold text-gray-800 mt-3">Halo, {{ $data->name }}</h1>
                <p class="text-sm text-gray-500">{{ $data->instansi }}</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 space-y-3">
                <div>
                    <p class="text-xs text-gray-500">Keperluan</p>
                    <p class="font-medium text-gray-800">{{ $data->keperluan }} ({{ $data->detail_keperluan }})</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Petugas yang Melayani</p>
                    <p class="font-medium text-gray-800">{{ $data->petugas ?? 'Menunggu Penugasan' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Nomor Antrean</p>
                    <p class="font-medium text-gray-800">{{ $data->nomor_antrean }}</p>
                </div>
            </div>

            <!-- Indikator Status -->
            <div class="p-4 rounded-xl 
                @if($data->status === 'Menunggu') bg-yellow-50 text-yellow-800 border border-yellow-200
                @elseif($data->status === 'Diproses') bg-blue-50 text-blue-800 border border-blue-200
                @endif">
                <p class="text-xs uppercase tracking-wider font-semibold">Status Saat Ini:</p>
                <p class="text-xl font-bold mt-1">{{ $data->status }}</p>
            </div>

            <p class="text-xs text-gray-400">
                Silakan tunggu di ruang tunggu. Halaman ini akan memperbarui status layanan Anda.
            </p>
    </div>
        @endif
        
</body>
</html>
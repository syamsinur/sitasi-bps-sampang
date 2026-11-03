<div class="p-6 text-center flex flex-col items-center justify-center space-y-4">
    <h3 class="text-xl font-bold text-gray-800">Antrean Tamu: {{ $record->name }}</h3>
    <p class="text-sm text-gray-600">Instansi: {{ $record->instansi }}</p>
    
    <!-- Tampilkan QR Code -->
    <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-200 inline-block">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ url('/antrean/' . $record->token) }}" 
             alt="QR Code Antrean" 
             class="mx-auto rounded-lg">
    </div>

    <!-- Menampilkan Link Teks untuk Cadangan -->
    <div class="p-3 bg-gray-50 rounded-lg w-full max-w-sm">
        <p class="text-xs text-gray-500 mb-1">Link Cek Antrean:</p>
        <code class="text-xs font-mono text-primary-600 break-all">{{ url('/antrean/' . $record->token) }}</code>
    </div>

    <p class="text-xs text-gray-500">
        Silakan minta tamu untuk men-scan QR code di atas menggunakan HP mereka untuk memantau status antrean secara real-time.
    </p>
</div>
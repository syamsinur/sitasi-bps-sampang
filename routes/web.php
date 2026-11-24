<?php

use App\Models\GuestBook;
use App\Models\WaitingList;
use App\Services\QueueRatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/antrean/{token}', function ($token) {
    // 1. Cari dulu di Ruang Tamu (Waiting List) yang masih aktif/proses
    $antrean = WaitingList::where('token', $token)->first();

    // 2. Jika tidak ketemu, berarti sudah selesai dan pindah ke Buku Tamu
    if (!$antrean) {
        $antrean = GuestBook::where('token', $token)->firstOrFail();
    }

    // Tampilkan ke view yang sama
    return view('front.antrean-status', [
        'data' => $antrean
    ]);
})->name('cek.antrean');

Route::post('/antrean/{token}/rating', function ($token, Request $request, QueueRatingService $service) {
    $antrean = WaitingList::where('token', $token)->first();

    if (!$antrean) {
        $antrean = GuestBook::where('token', $token)->firstOrFail();
    }

    $validated = $request->validate([
        'rating'  => ['required', 'integer', 'min:1', 'max:5'],
        'comment' => ['nullable', 'string', 'max:500'],
    ], [
        'rating.required' => 'Silakan pilih nilai bintang 1 sampai 5.',
        'rating.min'      => 'Nilai rating minimal 1 bintang.',
        'rating.max'      => 'Nilai rating maksimal 5 bintang.',
        'comment.max'     => 'comment maksimal 500 karakter.',
    ]);

    try {
        $service->storeRating(
            record: $antrean,
            rating: (int) $validated['rating'],
            comment: $validated['comment'] ?? null,
        );

        return redirect()
            ->route('cek.antrean', ['token' => $antrean->token])
            ->with('rating_success', 'Terima kasih! Penilaian Anda telah berhasil disimpan.');
    } catch (\Throwable $e) {
        return redirect()
            ->route('cek.antrean', ['token' => $antrean->token])
            ->withInput()
            ->with('rating_error', $e->getMessage());
    }
})->name('cek.antrean.rating.store');
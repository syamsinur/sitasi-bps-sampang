<?php

use App\Models\GuestBook;
use App\Models\WaitingList;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/antrean/{waiting_list:token}', function (WaitingList $waiting_list) {
//     $antrean = $waiting_list->token;
//     if(!$antrean) {
//         $antrean = GuestBook::where('token', $waiting_list->token)->firstOrFail();
//     }


//     return view('front.antrean-status', [
//         'antrean' => $waiting_list
//     ]);
// });

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
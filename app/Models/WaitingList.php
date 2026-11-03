<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable([
    'nomor_antrean',
    'name',
    'instansi',
    'keperluan',
    'detail_keperluan',
    'keperluan_lainnya',
    'no_hp',
    'petugas',
    'status'])]
class WaitingList extends Model
{
    protected static function booted()
    {
        static::creating(function ($waitingList) {
            // random string
            $waitingList->token = Str::random(6);
            
            // prefix
            $prefix = ($waitingList->keperluan === 'PST') ? 'TP' : 'TN';
            
            // Batasi rentang bulan berjalan
            $awalBulan = now()->startOfMonth();
            $awalBulanDepan = now()->addMonthNoOverflow()->startOfMonth();

            // Cari nomor antrean terbesar pada bulan ini
            $nomorTerakhir = static::query()
                ->where('keperluan', $waitingList->keperluan)
                ->whereBetween('created_at', [$awalBulan, $awalBulanDepan])
                ->pluck('nomor_antrean')
                ->map(function ($nomor) use ($prefix) {
                    if (!is_string($nomor) || !preg_match('/^' . preg_quote($prefix, '/') . '-(\d+)$/', $nomor, $matches)) {
                        return 0;
                    }
                    return (int) $matches[1];
                })
                ->max() ?? 0;

            // Otomatis isi kolom nomor_antrean dengan format TP-001 / TN-001 berikutnya
            $waitingList->nomor_antrean = sprintf('%s-%03d', $prefix, $nomorTerakhir + 1);
        });
    }
}

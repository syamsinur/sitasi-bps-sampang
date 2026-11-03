<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'nomor_antrean',
    'name',
    'instansi',
    'keperluan',
    'detail_keperluan',
    'keperluan_lainnya',
    'no_hp',
    'petugas',
    'catatan_konsultasi',
    'dokumentasi',
    'status'])]
class GuestBook extends Model
{
    //
}

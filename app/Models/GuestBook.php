<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nomor_antrean', 'name', 'instansi', 'keperluan', 'detail_keperluan', 'keperluan_lainnya', 'no_hp', 'catatan_konsultasi', 'dokumentasi'])]
class GuestBook extends Model
{
    //
}

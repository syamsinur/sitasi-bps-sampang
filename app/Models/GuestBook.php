<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'instansi', 'keperluan', 'detail_keperluan', 'no_hp', 'petugas', 'catatan_konsultasi', 'dokumentasi'])]
class GuestBook extends Model
{
    //
}

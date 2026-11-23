<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable('guest_book_id', 'pst_officer_id', 'rating', 'comment', 'keperluan')]
class QueueRating extends Model
{
    protected function casts() : array
    {
        return [
            'rating' => 'integer',
        ];
    }

    public function pstOfficer() : BelongsTo
    {
        return $this->belongsTo(PstOfficer::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['no_urut', 'name', 'nip', 'work_team_id', 'nomor_hp', 'jenis', 'foto', 'rating'])]
class PstOfficer extends Model
{
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->no_urut) {
                $model->no_urut = static::max('no_urut') + 1;
            }
        });
    }

    public function work_team() : BelongsTo
    {
        return $this->belongsTo(WorkTeam::class);
    }

    public function guestRatings() : HasMany
    {
        return $this->hasMany(QueueRating::class);
    }

    public function getFotoUrlAttribute(): ?string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::disk('public')->url($this->foto);
        }

        return null;
    }
}

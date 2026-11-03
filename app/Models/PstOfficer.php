<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['no_urut', 'name', 'nip', 'work_team_id', 'nomor_hp', 'foto'])]
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

    public function work_team()
    {
        return $this->belongsTo(WorkTeam::class);
    }
}

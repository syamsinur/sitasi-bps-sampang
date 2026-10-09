<?php

namespace App\Observers;

use App\Models\PstOfficer;
use Illuminate\Support\Facades\Storage;

class PstOfficerObserver
{
    /**
     * Handle the PstOfficer "created" event.
     */
    public function created(PstOfficer $pstOfficer): void
    {
        //
    }

    /**
     * Handle the PstOfficer "updated" event.
     */
    public function updated(PstOfficer $pstOfficer): void
    {
        // cek foto berubah atau tidak
        if ($pstOfficer->isDirty('foto')) {
            // ambil foto lama
            $oldFoto = $pstOfficer->getOriginal('foto');

            // hapus foto lama
            if ($oldFoto && Storage::disk('public')->exists($oldFoto)) {
                Storage::disk('public')->delete($oldFoto);
            }
        }
    }

    /**
     * Handle the PstOfficer "deleted" event.
     */
    public function deleted(PstOfficer $pstOfficer): void
    {
        // Hapus foto saat baris data dihapus
        if ($pstOfficer->foto && Storage::disk('public')->exists($pstOfficer->foto)) {
            Storage::disk('public')->delete($pstOfficer->foto);
        }
    }

    /**
     * Handle the PstOfficer "restored" event.
     */
    public function restored(PstOfficer $pstOfficer): void
    {
        //
    }

    /**
     * Handle the PstOfficer "force deleted" event.
     */
    public function forceDeleted(PstOfficer $pstOfficer): void
    {
        //
    }
}

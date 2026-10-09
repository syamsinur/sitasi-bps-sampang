<?php

namespace App\Observers;

use App\Models\GuestBook;
use Illuminate\Support\Facades\Storage;

class GuestBookObserver
{
    /**
     * Handle the GuestBook "created" event.
     */
    public function created(GuestBook $guestBook): void
    {
        //
    }

    /**
     * Handle the GuestBook "updated" event.
     */
    public function updated(GuestBook $guestBook): void
    {
        // cek dokumentas berubah atau tidak
        if($guestBook->isDirty('dokumentasi')) {
            // ambil dokumentasi lama
            $oldDokumentasi = $guestBook->getOriginal('dokumentasi');

            // hapus dokumentasi lama
            if($oldDokumentasi && Storage::disk('public')->exists($oldDokumentasi)) {
                Storage::disk('public')->delete($oldDokumentasi);
            }
        }
    }

    /**
     * Handle the GuestBook "deleted" event.
     */
    public function deleted(GuestBook $guestBook): void
    {
        // hapus foto saat baris data dihapus
        if($guestBook->dokumentasi && Storage::disk('public')->exists($guestBook->dokumentasi)) {
            Storage::disk('public')->delete($guestBook->dokumentasi);
        }
    }

    /**
     * Handle the GuestBook "restored" event.
     */
    public function restored(GuestBook $guestBook): void
    {
        //
    }

    /**
     * Handle the GuestBook "force deleted" event.
     */
    public function forceDeleted(GuestBook $guestBook): void
    {
        //
    }
}

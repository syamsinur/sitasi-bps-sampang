<?php

namespace App\Services;

use App\Models\GuestBook;
use App\Models\WaitingList;
use App\Models\QueueRating;
use App\Models\PstOfficer;
use Illuminate\Support\Facades\DB;

class QueueRatingService
{
    public function resolveGuestBook(WaitingList|GuestBook $record): ?GuestBook
    {
        if ($record instanceof GuestBook) {
            return $record;
        }

        if (!empty($record->token)) {
            $byToken = GuestBook::where('token', $record->token)
                ->latest('id')
                ->first();

            if ($byToken) {
                return $byToken;
            }
        }

        if (!empty($record->nomor_antrean)) {
            return GuestBook::where('nomor_antrean', $record->nomor_antrean)
                ->latest('id')
                ->first();
        }

        return null;
    }

    public function resolveOfficerId(?string $petugas): ?int
    {
        $name = trim((string) $petugas);

        if ($name === "") {
            return null;
        }

        $officer = PstOfficer::query()
            ->where('name', $name)
            ->orWhereRaw('LOWER(name) = ?', [mb_strtolower($name)])
            ->first();

        return $officer?->id;
    }

    public function hasRated(WaitingList|GuestBook $record): bool
    {
        $guestBook = $this->resolveGuestBook($record);

        if (! $guestBook) {
            return false;
        }

        return QueueRating::query()
            ->where('guest_book_id', $guestBook->id)
            ->exists();
    }

    public function recalculateOfficerRating(int $officerId): void
    {
        $avgRating = QueueRating::query()
            ->where('pst_officer_id', $officerId)
            ->avg('rating');

        PstOfficer::query()
            ->whereKey($officerId)
            ->update([
                'rating' => $avgRating !== null ? round((float) $avgRating, 2) : 0.00,
            ]);
    }

    public function storeRating(WaitingList|GuestBook $record, int $rating, ?string $comment = null): QueueRating
    {
        if (($record->status ?? null) !== 'Selesai') {
            throw new \RuntimeException('Rating hanya dapat diberikan setelah status antrean Selesai.');
        }

        $guestBook = $this->resolveGuestBook($record);

        if (! $guestBook) {
            throw new \RuntimeException('Data kunjungan di buku tamu belum ditemukan.');
        }

        if (QueueRating::query()->where('guest_book_id', $guestBook->id)->exists()) {
            throw new \RuntimeException('Penilaian untuk kunjungan ini sudah pernah dikirim.');
        }

        $officerId = $this->resolveOfficerId($guestBook->petugas ?? $record->petugas);

        if (! $officerId) {
            throw new \RuntimeException('Data petugas pada kunjungan ini tidak ditemukan di daftar petugas PST.');
        }

        return DB::transaction(function () use ($record, $guestBook, $officerId, $rating, $comment) {
            $queueRating = QueueRating::query()->create([
                'guest_book_id'  => $guestBook->id,
                'pst_officer_id' => $officerId,
                'keperluan'      => $guestBook->keperluan ?: $record->keperluan,
                'rating'         => $rating,
                'comment'        => $comment !== null && trim($comment) !== '' ? trim($comment) : null,
            ]);

            $this->recalculateOfficerRating($officerId);

            return $queueRating;
        });
    }
}
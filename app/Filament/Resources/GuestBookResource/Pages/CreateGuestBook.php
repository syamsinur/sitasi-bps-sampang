<?php

namespace App\Filament\Resources\GuestBookResource\Pages;

use App\Filament\Resources\GuestBookResource;
use App\Models\GuestBook;
use Filament\Resources\Pages\CreateRecord;

class CreateGuestBook extends CreateRecord
{
    protected static string $resource = GuestBookResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $keperluan = $data['keperluan'] ?? null;

        $prefix = match ($keperluan) {
            'PST' => 'TP',
            'NON PST' => 'TN',
            default => throw new \InvalidArgumentException(
                'Keperluan tamu tidak valid.'
            ),
        };

        $awalBulan = now()->startOfMonth();
        $awalBulanDepan = now()->addMonthNoOverflow()->startOfMonth();

        $nomorTerakhir = GuestBook::query()
            ->where('keperluan', $keperluan)
            ->whereBetween('created_at', [
                $awalBulan,
                $awalBulanDepan,
            ])
            ->pluck('nomor_antrean')
            ->map(function ($nomor) use ($prefix) {
                if (
                    ! is_string($nomor) ||
                    ! preg_match(
                        '/^' . $prefix . '-(\d+)$/',
                        $nomor,
                        $matches
                    )
                ) {
                    return 0;
                }

                return (int) $matches[1];
            })
            ->max() ?? 0;

        $data['nomor_antrean'] = sprintf(
            '%s-%03d',
            $prefix,
            $nomorTerakhir + 1
        );

        return $data;
    }
}
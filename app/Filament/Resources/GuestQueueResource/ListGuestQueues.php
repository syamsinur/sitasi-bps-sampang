<?php

namespace App\Filament\Resources\GuestQueueResource;

use App\Filament\Resources\GuestQueueResource as GuestQueueResource;
use App\Models\GuestBook;
use Filament\Resources\Pages\Page;

class ListGuestQueues extends Page
{
    protected static string $resource = GuestQueueResource::class;

    protected static string $view = 'filament.pages.guest-queue';

    protected static ?string $title = 'Antrean Tamu';

    protected function getViewData(): array
    {
        return [
            'pst' => $this->getAntrean('PST', 'TP'),
            'nonPst' => $this->getAntrean('NON PST', 'TN'),
        ];
    }

    private function getAntrean(
        string $keperluan,
        string $prefix
    ): array {
        $awalBulan = now()->startOfMonth();

        $awalBulanDepan = now()
            ->addMonthNoOverflow()
            ->startOfMonth();

        $query = GuestBook::query()
            ->where('keperluan', $keperluan)
            ->where('created_at', '>=', $awalBulan)
            ->where('created_at', '<', $awalBulanDepan);

        $nomorTerakhir = (clone $query)
            ->pluck('nomor_antrean')
            ->map(function ($nomor) use ($prefix) {
                if (
                    ! is_string($nomor) ||
                    ! preg_match(
                        '/^' . preg_quote($prefix, '/') . '-(\d+)$/',
                        $nomor,
                        $matches
                    )
                ) {
                    return 0;
                }

                return (int) $matches[1];
            })
            ->max() ?? 0;

        return [
            'nomor' => sprintf('%s-%03d', $prefix, $nomorTerakhir),
            'total' => (clone $query)->count(),
        ];
    }
}
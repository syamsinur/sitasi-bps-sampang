<?php

namespace App\Filament\Resources\GuestBookResource\Pages;

use App\Filament\Resources\GuestBookResource;
use App\Models\GuestBook;
use Filament\Resources\Pages\Page;

class GuestQueue extends Page
{
    protected static string $resource = GuestBookResource::class;
    protected static string $view = 'filament.pages.guest-queue';
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationLabel = 'Antrean Tamu';
    protected static ?string $title = 'Antrean Tamu';
    protected static ?string $navigationGroup = 'Buku Tamu';
    protected static ?int $navigationSort = 2;
    protected static bool $shouldRegisterNavigation = true;
    protected function getViewData(): array
    {
        return [
            'pst' => $this->getAntrean('PST', 'TP'),
            'nonPst' => $this->getAntrean('NON PST', 'TN'),
        ];
    }

    private function getAntrean(string $keperluan, string $prefix): array
    {
        $awalBulan = now()->startOfMonth();
        $awalBulanDepan = now()->addMonthNoOverflow()->startOfMonth();

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
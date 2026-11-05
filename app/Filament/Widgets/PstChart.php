<?php

namespace App\Filament\Widgets;

use App\Models\GuestBook;
use Filament\Widgets\ChartWidget;

class PstChart extends ChartWidget
{
    // title chart
    protected static ?string $heading = 'Layanan PST dan NON PST';

    // sort
    protected static ?int $sort = 1;

    // function get data
    protected function getData(): array
    {
        // get data
        $allData = GuestBook::query()
            ->whereIn('keperluan', ['PST', 'NON PST'])
            ->selectRaw('keperluan, count(*) as total')
            ->groupBy('keperluan')
            ->pluck('total', 'keperluan');

        $layananPst = $allData['PST'] ?? 0;
        $layananNonPst = $allData['NON PST'] ?? 0;

        // return data
        return [
            'datasets' => [
                [
                    'label' => 'Persentase layanan PST dan NON PST',
                    'data' => [$layananPst, $layananNonPst],
                    'backgroundColor' => ['#3b82f6', '#22c55e'],
                ]
            ],
            'labels' => ['PST', 'NON PST'],
        ];
    }

    // tipe chart
    protected function getType(): string
    {
        return 'doughnut';
    }
    
    // option
    protected function getOptions(): ?array
    {
        return [
            'scales' => [
                'x' => [
                    'display' => false,
                    'grid' => ['display' => false]
                ],
                'y' => [
                    'display' => false,
                    'grid' => ['display' => false]
                ]
            ],
        ];
    }
}

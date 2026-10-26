<?php

namespace App\Filament\Widgets;

use App\Models\GuestBook;
use Filament\Widgets\ChartWidget;

class PstChart extends ChartWidget
{
    // title chart
    protected static ?string $heading = 'Layanan PST dan NON PST';


    protected function getData(): array
    {
        $layananPst = GuestBook::where('keperluan', 'PST')->count();
        $layananNonPst = GuestBook::where('keperluan', 'NON PST')->count();

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

    protected function getType(): string
    {
        return 'doughnut';
    }
}

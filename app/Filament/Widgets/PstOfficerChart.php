<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class PstOfficerChart extends ChartWidget
{
    protected static ?string $heading = 'Petugas PST';

    protected function getData(): array
    {
        
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

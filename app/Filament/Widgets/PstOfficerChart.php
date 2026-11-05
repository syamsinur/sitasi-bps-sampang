<?php

namespace App\Filament\Widgets;

use App\Models\GuestBook;
use App\Models\PstOfficer;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PstOfficerChart extends ChartWidget
{
    // title chart
    protected static ?string $heading = 'Performa Petugas PST';

    // sort
    protected static ?int $sort = 2;

    // filter bulan
    protected function getFilters(): ?array
    {
        return [
            'all' => 'Semua Bulan (Tahun Ini)',
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

    // function get data
    protected function getData(): array
    {
        // get filter
        $activeFilter = $this->filter;

        // get data
        $query = GuestBook::query()
            ->selectRaw('petugas, count(*) as total')
            ->whereNotNull('petugas')
            ->where('petugas', '!=', '')
            ->whereYear('created_at', now()->year);
            
        // filter except all
        if ($activeFilter && $activeFilter !== 'all') {
            $query->whereMonth('created_at', $activeFilter);
        } 

        $performa = $query->groupBy('petugas')->pluck('total', 'petugas');

        // return data
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Tamu Dilayani',
                    'data' => $performa->values()->toArray(),
                    'backgroundColor' => '#3b82f6', 
                    'borderColor' => '#2563eb',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $performa->keys()->toArray(),
        ];
    }

    // tipe chart
    protected function getType(): string
    {
        return 'bar';
    }

    // option
    protected function getOptions(): ?array
    {
        return [
            'indexAxis' => 'y', // horzontal bar
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0, // bilangan bulat
                    ],
                ],
            ],
        ];
    }
}

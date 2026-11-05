<?php

namespace App\Filament\Widgets;

use App\Models\GuestBook;
use Filament\Widgets\ChartWidget;

class MonthlyChart extends ChartWidget
{
    // title chart
    protected static ?string $heading = 'Pelayanan Keseluruhan';

    // sort
    protected static ?int $sort = 3;

    // full width
    protected int | string | array $columnSpan = 'full';

    // function get data
    protected function getData(): array
    {
        $thisYear = now()->year;

        // Array daftar bulan dalam setahun
        $bulanList = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        // get data
        $allData = GuestBook::query()
            ->selectRaw('MONTH(created_at) as bulan, keperluan, count(*) as total')
            ->whereYear('created_at', $thisYear)
            ->whereIn('keperluan', ['PST', 'NON PST'])
            ->groupBy('bulan', 'keperluan')
            ->get()
            ->groupBy('bulan');

        $dataPst = [];
        $dataNonPst = [];

        // Loop per bulan 
        foreach ($bulanList as $angkaBulan => $namaBulan) {
            // parsing data to int (01, 02) to (1, 2)
            $bulanInt = (int) $angkaBulan;
            
            $dataPst[] = $allData->get($bulanInt)?->firstWhere('keperluan', 'PST')?->total ?? 0;
            $dataNonPst[] = $allData->get($bulanInt)?->firstWhere('keperluan', 'NON PST')?->total ?? 0;
        }

        // return data
        return [
            'datasets' => [
                [
                    'label' => 'PST ',
                    'data' => $dataPst,
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#2563eb',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'NON PST',
                    'data' => $dataNonPst,
                    'backgroundColor' => '#22c55e',
                    'borderColor' => '#10b981',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => array_values($bulanList),
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
            'indexAxis' => 'x', // vertikal chart
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0, // bilangan bulat
                    ],
                ],
            ],
        ];
    }
}

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
        $tahunIni = now()->year;

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

        $dataPst = [];
        $dataNonPst = [];

        // Loop per bulan untuk mengambil total layanan PST dan Non PST berdasarkan created_at
        foreach ($bulanList as $angkaBulan => $namaBulan) {
            // Hitung total PST per bulan pada tahun berjalan
            $dataPst[] = GuestBook::query()
                ->where('keperluan', 'PST')
                ->whereYear('created_at', $tahunIni)
                ->whereMonth('created_at', $angkaBulan)
                ->count();

            // Hitung total NON PST per bulan pada tahun berjalan
            $dataNonPst[] = GuestBook::query()
                ->where('keperluan', 'NON PST')
                ->whereYear('created_at', $tahunIni)
                ->whereMonth('created_at', $angkaBulan)
                ->count();
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

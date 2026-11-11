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
        $activeFilter = $this->filter;

        $query = GuestBook::query()
            ->selectRaw('petugas, keperluan, COUNT(*) as total')
            ->whereNotNull('petugas')
            ->where('petugas', '!=', '')
            ->whereNotNull('keperluan')
            ->where('keperluan', '!=', '')
            ->whereYear('created_at', now()->year);

        if ($activeFilter && $activeFilter !== 'all') {
            $query->whereMonth('created_at', $activeFilter);
        }

        $data = $query
            ->groupBy('petugas', 'keperluan')
            ->get();

        // Ambil seluruh petugas
        $petugas = $data->pluck('petugas')->unique()->values();

        // Ambil seluruh jenis layanan
        $keperluan = $data->pluck('keperluan')->unique()->values();

        // Warna setiap jenis layanan
        $colors = [
            '#3b82f6',
            '#10b981',
            '#f59e0b',
            '#ef4444',
            '#8b5cf6',
            '#ec4899',
            '#06b6d4',
            '#84cc16',
        ];

        $datasets = [];

        foreach ($keperluan as $index => $jenis) {
            $datasets[] = [
                'label' => $jenis,
                'data' => $petugas->map(function ($namaPetugas) use ($data, $jenis) {
                    return $data
                        ->where('petugas', $namaPetugas)
                        ->where('keperluan', $jenis)
                        ->sum('total');
                })->toArray(),
                'backgroundColor' => $colors[$index % count($colors)],
                'borderWidth' => 1,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $petugas->toArray(),
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
            'indexAxis' => 'y',

            'scales' => [
                'x' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Layanan',
                    ],
                ],

                'y' => [
                    'stacked' => true,
                ],
            ],

            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
        ];
    }
}

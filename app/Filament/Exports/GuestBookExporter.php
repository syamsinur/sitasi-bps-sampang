<?php

namespace App\Filament\Exports;

use App\Models\GuestBook;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class GuestBookExporter extends Exporter
{
    protected static ?string $model = GuestBook::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Nama'),
            ExportColumn::make('instansi')
                ->label('Instansi'),
            ExportColumn::make('keperluan')
                ->label('Keperluan'),
            ExportColumn::make('detail_keperluan')
                ->label('Detail Keperluan'),
            ExportColumn::make('no_hp')
                ->label('No HP'),
            ExportColumn::make('catatan_konsultasi')
                ->label('Catatan Konsultasi'),
            ExportColumn::make('dokumentasi')
                ->label('Dokumentasi'),
            ExportColumn::make('created_at')
                ->label('Tanggal'),
        ];
    }

    public function getFileName(Export $export): string
    {
        return 'BUKU TAMU ' . date('Y');
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Proses export selesai dan ' . number_format($export->successful_rows) . ' ' . str('baris')->plural($export->successful_rows) . ' terexport.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' proses export gagal';
        }

        return $body;
    }
}

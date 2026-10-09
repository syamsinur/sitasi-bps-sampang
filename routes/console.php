<?php

use Filament\Actions\Exports\Models\Export;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    // Ambil export lama
    $oldExports = Export::where('created_at', '<', now()->subDay())->get();

    foreach($oldExports as $export) {
        $export_path = "filament_exports/{$export->id}";

        if (Storage::disk('local')->exists($export_path)) {
            Storage::disk('local')->deleteDirectory($export_path);
        }

        // Hapus baris data
        $export->delete();
    }
})->daily();

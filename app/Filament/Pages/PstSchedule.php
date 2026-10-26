<?php

namespace App\Filament\Pages;

use App\Models\PstOfficer;
use Carbon\Carbon;
use Filament\Pages\Page;

class PstSchedule extends Page
{
    // icon
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    // title nav
    protected static ?string $navigationLabel = 'Jadwal Petugas PST';

    // title
    protected static ?string $title = 'Jadwal Petugas PST Mingguan';

    // sort
    protected static ?int $navigationSort = 3;

    // group
    protected static ?string $navigationGroup = 'PST';

    // view
    protected static string $view = 'filament.pages.pst-schedule';

    public function getViewData(): array
    {
        // retrieve data
        $petugasPst = PstOfficer::all();

        // dd($petugasPst);
        
        // total petugas
        $totalPetugas = $petugasPst->count();
        
        // get week and year
        $currentWeek = Carbon::now()->weekOfYear;
        $currentYear = Carbon::now()->year;

        // suffle petugas using crc32
        $petugasShuffled = $petugasPst->sortBy(function ($petugas) use ($currentWeek, $currentYear) {
            return crc32($petugas->id . '-' . $currentWeek . '-' . $currentYear);
        })->values();

        // working day
        $workDay = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $schedulePetugas = [];
        
        // assign petugas to schedule
        foreach($workDay as $index => $day) {
            $schedulePetugas[] = [
                'hari' => $day,
                'petugas' => $totalPetugas > 0 ? $petugasShuffled->get($index % $totalPetugas) : null
            ];
        }

        // return to view
        return [
            'schedulePetugas' => $schedulePetugas,
            'petugasPst' => $petugasPst,
            'totalPetugas' => $totalPetugas
        ];
    }
}

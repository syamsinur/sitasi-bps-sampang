<?php

namespace App\Filament\Pages;

use App\Models\PstOfficer;
use Filament\Pages\Page;

class PstSchedule extends Page
{
    // icon
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    // title
    protected static ?string $title = 'Jadwal PST';

    // sort
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.pst-schedule';

    public function getViewData(): array
    {
        // retrieve data
        $petugasPst = PstOfficer::all();

        // dd($petugasPst);

        // suffle data dan re-index
        $petugasSuffled = $petugasPst->shuffle()->values();
        $totalPetugas = $petugasPst->count();

        // working day
        $workDay = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $schedulePetugas = [];
        
        // assign petugas
        foreach($workDay as $index => $day) {
            $schedulePetugas[] = [
                'hari' => $day,
                'petugas' => $totalPetugas > 0 ? $petugasSuffled->get($index % $totalPetugas) : null,
            ];
        }

        return [
            'schedulePetugas' => $schedulePetugas,
            'petugasPst' => $petugasPst,
            'totalPetugas' => $totalPetugas
        ];
    }
}

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
    protected static ?string $title = 'Jadwal Petugas PST';

    // slug
    protected static ?string $slug = 'jadwal-petugas-pst';

    // sort
    protected static ?int $navigationSort = 5;

    // group
    protected static ?string $navigationGroup = 'PST';

    // view
    protected static string $view = 'filament.pages.pst-schedule';

    public function getViewData(): array
    {
        // ==========================================================
        // CARA TESTING / SIMULASI WAKTU
        // ==========================================================
        // Coba ganti-ganti minggu untuk melihat pergeseran petugas:
        Carbon::setTestNow(Carbon::now()); // Minggu ini (posisi awal)
        // Carbon::setTestNow(Carbon::now()->addWeek()); // Maju 1 minggu ke depan
        // Carbon::setTestNow(Carbon::now()->addWeeks(2)); // Maju 2 minggu ke depan
        // ==========================================================

        // retrieve data
        $petugasPst = PstOfficer::orderBy('no_urut', 'asc')->orderBy('id', 'asc')->get();
        
        // total petugas
        $totalPetugas = $petugasPst->count();
        
        // working day
        $workDay = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $schedulePetugas = [];

        if($totalPetugas > 0) {
            // get week
            $currentWeek = Carbon::now()->weekOfYear;

            // assign petugas to schedule
            foreach($workDay as $index => $day) {
                $petugasIndex = (($currentWeek - 1) * 5 + $index) % $totalPetugas;

                $schedulePetugas[] = [
                    'hari' => $day,
                    'petugas' => $petugasPst->values()->get($petugasIndex),
                ];
            }
        }

        // return to view
        return [
            'schedulePetugas' => $schedulePetugas,
            'petugasPst' => $petugasPst,
            'totalPetugas' => $totalPetugas
        ];
    }

    // Tambahkan fungsi ini di dalam class Page Filament (tempat getViewData berada)
    public function moveOfficer(int $id, string $direction)
    {
        $officer = PstOfficer::find($id);
        if (!$officer) return;

        if ($direction === 'up') {
            $swapOfficer = PstOfficer::where('no_urut', '<', $officer->no_urut)
                ->orderBy('no_urut', 'desc')
                ->first();
        } else {
            $swapOfficer = PstOfficer::where('no_urut', '>', $officer->no_urut)
                ->orderBy('no_urut', 'asc')
                ->first();
        }

        if ($swapOfficer) {
            $tempOrder = $officer->no_urut;
            $officer->no_urut = $swapOfficer->no_urut;
            $swapOfficer->no_urut = $tempOrder;

            $officer->save();
            $swapOfficer->save();
        }

        // Refresh halaman agar jadwal & tabel langsung terupdate
        $this->dispatch('$refresh');
    }
}

<?php

namespace App\Providers;

use App\Models\GuestBook;
use App\Models\PstOfficer;
use App\Observers\GuestBookObserver;
use App\Observers\PstOfficerObserver;
use Carbon\Carbon;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PstOfficer::observe(PstOfficerObserver::class);
        GuestBook::observe(GuestBookObserver::class);

        // View sidebar Filament
        View::composer([
            'filament.widgets.sidebar-petugas',
            'filament.pages.guest-queue',
        ], function ($view) {
            // Logic jadwal harian
            $petugasAll = PstOfficer::orderBy('no_urut', 'asc')->orderBy('id', 'asc')->get();
            $petugasPst = $petugasAll->where('jenis', 'pst');
            $totalPetugas = $petugasPst->count();
            
            $petugasHariIni = null;
            $namaHariIni = Carbon::now()->locale('id')->dayName; // Senin, Selasa, dll

            if ($totalPetugas > 0) {
                $currentWeek = Carbon::now()->weekOfYear;
                $workDay = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                
                foreach ($workDay as $index => $day) {
                    if (strtolower($day) === strtolower($namaHariIni)) {
                        $petugasIndex = (($currentWeek - 1) * 5 + $index) % $totalPetugas;
                        $petugasHariIni = $petugasPst->values()->get($petugasIndex);
                        break;
                    }
                }
            }

            // share variabel ke semua view 
            $view->with('petugasHariIni', $petugasHariIni);
            $view->with('namaHariIni', $namaHariIni);
        });
    }
}

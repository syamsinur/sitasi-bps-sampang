<?php

namespace App\Filament\Resources\GuestQueueResource;

use App\Filament\Resources\GuestQueueResource as GuestQueueResource;
use App\Models\PstOfficer;
use App\Models\WaitingList;
use Filament\Resources\Pages\Page;

class ListGuestQueues extends Page
{
    // resource
    protected static string $resource = GuestQueueResource::class;

    // view
    protected static string $view = 'filament.pages.guest-queue';

    // title
    protected static ?string $title = 'Antrean Tamu';

    // Properti untuk melacak antrean terbaru
    public ?int $latestQueueId = null;
    public ?int $latestProcessedId = null;
    public $activeModalQueue = null;
    public bool $showModal = false;

    public function mount()
    {
        // Ambil ID tamu terakhir saat halaman pertama kali dibuka
        $latest = WaitingList::latest('id')->first();
        $this->latestQueueId = $latest?->id;
    }

    // Fungsi yang akan dipanggil secara periodik oleh wire:poll di Blade
    public function checkForNewQueue()
    {
        $latest = WaitingList::latest('id')->first();

        // Jika ada ID baru yang masuk (berbeda dari sebelumnya)
        if ($latest && $latest->id !== $this->latestQueueId) {
            $this->latestQueueId = $latest->id;
            $this->activeModalQueue = $latest;
            $this->showModal = true; // Munculkan modal otomatis!
        }

        // 2. Cek tamu terbaru yang statusnya BERUBAH MENJADI 'Diproses'
        $tamuDiproses = WaitingList::query()
            ->where('status', 'Diproses')
            ->latest('updated_at')
            ->first();

        // Jika ada tamu diproses DAN ID-nya berbeda dari yang terakhir disuarakan
        if ($tamuDiproses && $tamuDiproses->id !== $this->latestProcessedId) {
            $this->latestProcessedId = $tamuDiproses->id; // Simpan ID agar tidak berulang

            // Picu suara panggilan ke browser
            $this->dispatch('putar-suara-antrean', [
                'nomor'   => $tamuDiproses->nomor_antrean,
                'petugas' => $tamuDiproses->petugas ?? 'Pelayanan'
            ]);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->activeModalQueue = null;
    }
    
    protected function getViewData(): array
    {
        return [
            'pst' => $this->getAntreanProses('PST'),
            'nonPst' => $this->getAntreanProses('NON PST'),
        ];
    }

    private function getAntreanProses(string $keperluan): array
    {
        // tamu Diproses
        $tamuAktif = WaitingList::query()
            ->where('keperluan', $keperluan)
            ->where('status', 'Diproses')
            ->latest('updated_at')
            ->first();

        // total tamu bulan berjalan
        $awalBulan = now()->startOfMonth();
        $awalBulanDepan = now()
            ->addMonthNoOverflow()
            ->startOfMonth();

        $totalBulanIni = WaitingList::query()
            ->where('keperluan', $keperluan)
            ->whereBetween('created_at', [$awalBulan, $awalBulanDepan])
            ->count();

        return [
            'nomor'    => $tamuAktif ? $tamuAktif->nomor_antrean : '-',
            'nama'     => $tamuAktif ? $tamuAktif->name : 'Tidak ada antrean',
            'instansi' => $tamuAktif ? $tamuAktif->instansi : '-',
            'petugas'  => $tamuAktif ? $tamuAktif->petugas : '-',
            'total'    => $totalBulanIni,
        ];
    }
}
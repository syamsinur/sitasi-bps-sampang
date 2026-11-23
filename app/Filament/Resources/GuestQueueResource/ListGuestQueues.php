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

    // Property
    public ?int $latestQueueId = null;
    public ?int $lastModalQueueId = null;
    public ?int $latestProcessedId = null;
    public $activeModalQueue = null;
    public bool $showModal = false;


    public function mount()
    {
        // query for collect data limit 20 rows
        $rows = WaitingList::query()
            ->select('id', 'status', 'updated_at')
            ->latest('id')
            ->limit(20)
            ->get();

        // get latest ID tamu
        $latestId = $rows->first()?->id;
        $this->latestQueueId = $latestId;
        $this->lastModalQueueId = $latestId;

        // get latest ID tamu with status 'Diproses'
        $this->latestProcessedId = $rows
            ->where('status', 'diproses')
            ->sortByDesc('updated_at')
            ->first()?->id;
    }

    // Fungsi yang akan dipanggil secara periodik oleh wire:poll di Blade
    public function checkForNewQueue()
    {
        // query for collect data limit 20 rows
        $rows = WaitingList::query()
            ->latest('id')
            ->limit(20)
            ->get();

        $latest = $rows->first();

        // cek antrean with latest ID
        if ($latest
            && $this->latestQueueId !== null
            && $latest->id > $this->latestQueueId
            && $latest->id !== $this->lastModalQueueId
        ) {
            $this->latestQueueId = $latest->id;
            $this->lastModalQueueId = $latest->id;

            // show modal if status 'menunggu
            if ($latest->status === 'Menunggu') {
                $this->activeModalQueue = $latest;
                $this->showModal = true; 
            }
        } elseif ($latest && $this->latestQueueId === null) {
            $this->latestQueueId = $latest->id;
            $this->lastModalQueueId = $latest->id;        
        }

        // cek latest tamu with status 'Diproses'
        $tamuDiproses = $rows
            ->where('status', 'Diproses')
            ->sortByDesc('updated_at')
            ->first();

        if ($tamuDiproses && $tamuDiproses->id !== $this->latestProcessedId) {
            $this->latestProcessedId = $tamuDiproses->id;

            // if modal is open, close modal
            $this->showModal = false;
            $this->activeModalQueue = null;

            $this->dispatch('putar-suara-antrean', [
                'nomor'   => $tamuDiproses->nomor_antrean,
                'petugas' => $tamuDiproses->petugas ?? 'Pelayanan',
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
        $listKeperluan = ['PST', 'NON PST'];
        $dataPerKeperluan = $this->getAntreanProses($listKeperluan);

        return [
            'pst' => $dataPerKeperluan['PST'],
            'nonPst' => $dataPerKeperluan['NON PST'],
        ];
    }

    private function getAntreanProses(array $keperluan): array
    {
        // total tamu bulan berjalan
        $awalBulan = now()->startOfMonth();
        $awalBulanDepan = now()->addMonthNoOverflow()->startOfMonth();

        // query for collect data field keperluan
        $grouped = WaitingList::query()
            ->select('id', 'keperluan', 'status', 'nomor_antrean', 'name', 'instansi', 'petugas', 'updated_at')
            ->whereIn('keperluan', $keperluan)
            ->whereBetween('created_at', [$awalBulan, $awalBulanDepan])
            ->get()
            ->groupBy('keperluan');

        $result = [];

        foreach ($keperluan as $k) {
            $items = $grouped->get($k, collect());

            // tamu Diproses
            $tamuAktif = $items
                ->where('status', 'Diproses')
                ->sortByDesc('updated_at')
                ->first();

            $result[$k] = [
                'nomor' => $tamuAktif?->nomor_antrean ?? '-',
                'nama' => $tamuAktif?->name ?? 'Tidak ada antrean',
                'instansi' => $tamuAktif?->instansi ?? '-',
                'petugas' => $tamuAktif?->petugas ?? '-',
                'total' => $items->count(),
            ];
        }

        return $result;
    }
}
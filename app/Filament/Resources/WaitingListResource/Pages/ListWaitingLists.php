<?php

namespace App\Filament\Resources\WaitingListResource\Pages;

use App\Filament\Resources\WaitingListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWaitingLists extends ListRecords
{
    // resource
    protected static string $resource = WaitingListResource::class;

    // title
    protected static ?string $title = 'Ruang Tunggu';
    
    // create button
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Tamu'),
        ];
    }

    
}

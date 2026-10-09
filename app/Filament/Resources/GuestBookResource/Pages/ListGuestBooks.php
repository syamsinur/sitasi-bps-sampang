<?php

namespace App\Filament\Resources\GuestBookResource\Pages;

use App\Filament\Resources\GuestBookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuestBooks extends ListRecords
{
    protected static string $resource = GuestBookResource::class;

    // title
    protected static ?string $title = 'Daftar Tamu';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

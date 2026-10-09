<?php

namespace App\Filament\Resources\PstOfficerResource\Pages;

use App\Filament\Resources\PstOfficerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPstOfficers extends ListRecords
{
    protected static string $resource = PstOfficerResource::class;

    // title
    protected static ?string $title = 'Petugas PST';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PstOfficerResource\Pages;

use App\Filament\Resources\PstOfficerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePstOfficer extends CreateRecord
{
    // resource
    protected static string $resource = PstOfficerResource::class;

    // title
    protected static ?string $title = 'Tambah Petugas';

    // redirect
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

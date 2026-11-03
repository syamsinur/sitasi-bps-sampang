<?php

namespace App\Filament\Resources\WorkTeamResource\Pages;

use App\Filament\Resources\WorkTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkTeam extends CreateRecord
{
    // resource
    protected static string $resource = WorkTeamResource::class;

    // title
    protected static ?string $title = 'Tambah Tim Kerja'; 

    // redirect
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

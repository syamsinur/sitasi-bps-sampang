<?php

namespace App\Filament\Resources\WorkTeamResource\Pages;

use App\Filament\Resources\WorkTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkTeams extends ListRecords
{
    // resource
    protected static string $resource = WorkTeamResource::class;

    // title
    protected static ?string $title = 'Tim Kerja';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Tim Kerja'),
        ];
    }
}

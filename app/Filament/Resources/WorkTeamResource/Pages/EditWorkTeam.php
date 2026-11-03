<?php

namespace App\Filament\Resources\WorkTeamResource\Pages;

use App\Filament\Resources\WorkTeamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkTeam extends EditRecord
{
    protected static string $resource = WorkTeamResource::class;

    // redirect
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}

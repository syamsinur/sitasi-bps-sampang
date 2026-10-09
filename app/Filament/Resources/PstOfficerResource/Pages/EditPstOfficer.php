<?php

namespace App\Filament\Resources\PstOfficerResource\Pages;

use App\Filament\Resources\PstOfficerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPstOfficer extends EditRecord
{
    protected static string $resource = PstOfficerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}

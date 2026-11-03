<?php

namespace App\Filament\Resources\WaitingListResource\Pages;

use App\Filament\Resources\WaitingListResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateWaitingList extends CreateRecord
{
    // resource
    protected static string $resource = WaitingListResource::class;

    // title
    protected static ?string $title = 'Tambah Tamu';

    // redirect
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}

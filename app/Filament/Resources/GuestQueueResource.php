<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestQueueResource\ListGuestQueues;
use App\Models\GuestBook;
use App\Models\WaitingList;
use Filament\Resources\Resource;

class GuestQueueResource extends Resource
{
    // model
    protected static ?string $model = WaitingList::class;

    // model label
    protected static ?string $modelLabel = 'Antrean';

    // icon
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    // title nav
    protected static ?string $navigationLabel = 'Antrean Tamu';

    // slug
    protected static ?string $slug = 'antrean-tamu';

    // sort
    protected static ?int $navigationSort = 2;

    public static function getPages(): array
    {
        return [
            'index' => ListGuestQueues::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestQueueResource\ListGuestQueues;
use App\Models\GuestBook;
use Filament\Resources\Resource;

class GuestQueueResource extends Resource
{
    protected static ?string $model = GuestBook::class;

    // icon
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    // title nav
    protected static ?string $navigationLabel = 'Antrean Tamu';

    // slug
    protected static ?string $slug = 'antrean-tamu';

    // sort
    protected static ?int $navigationSort = 4;

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
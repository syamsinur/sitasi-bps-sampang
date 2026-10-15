<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestQueueResource\ListGuestQueues;
use App\Models\GuestBook;
use Filament\Resources\Resource;

class GuestQueueResource extends Resource
{
    protected static ?string $model = GuestBook::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Antrean Tamu';

    protected static ?string $slug = 'antrean-tamu';

    protected static ?int $navigationSort = 3;

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
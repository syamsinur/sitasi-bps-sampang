<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkTeamResource\Pages;
use App\Filament\Resources\WorkTeamResource\RelationManagers;
use App\Models\WorkTeam;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class WorkTeamResource extends Resource
{
    // model
    protected static ?string $model = WorkTeam::class;

    // model label
    protected static ?string $modelLabel = 'Tim Kerja';
    protected static ?string $pluralModelLabel = 'Tim Kerja';

    // icon
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    // title nav
    protected static ?string $navigationLabel = 'Tim Kerja';

    // slug
    protected static ?string $slug = 'tim-kerja';

    // sort
    protected static ?int $navigationSort = 3;

    // group
    protected static ?string $navigationGroup = 'PST';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info')
                    ->label('Detail'),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Tim Kerja')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Tim Kerja')
                            ->hiddenLabel()
                            ->size(TextEntrySize::Large)
                            ->weight(FontWeight::Bold),
                        RepeatableEntry::make('pstofficers')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Daftar Petugas PST')
                                    ->hiddenLabel()
                                    ->size(TextEntrySize::Medium)
                                    ->weight(FontWeight::SemiBold)
                                    ->color('primary'),
                            ])
                            ->placeholder('Belum ada data')
                            ->hiddenLabel()
                    ])
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkTeams::route('/'),
            'create' => Pages\CreateWorkTeam::route('/create'),
            'edit' => Pages\EditWorkTeam::route('/{record}/edit'),
            'view' => Pages\ViewWorkTeam::route('/{record}'),
        ];
    }
}

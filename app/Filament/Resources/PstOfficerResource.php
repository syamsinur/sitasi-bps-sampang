<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PstOfficerResource\Pages;
use App\Filament\Resources\PstOfficerResource\RelationManagers;
use App\Models\PstOfficer;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PstOfficerResource extends Resource
{
    protected static ?string $model = PstOfficer::class;

    // icon
    protected static ?string $navigationIcon = 'heroicon-o-user';

    // title nav
    protected static ?string $navigationLabel = 'Petugas PST';

    public static function form(Form $form): Form
    {
        // input form
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('keahlian')
                    ->label('Keahlian')
                    ->required(),
                TextInput::make('hari')
                    ->label('Hari Tugas')
                    ->required(),
                FileUpload::make('foto')
                    ->label('Upload Foto')
                    ->disk('public')
                    ->directory('foto_petugas')
                    ->image()
                    ->imageEditor()
                    ->maxSize(2048)
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1'
                    ])
                    ->required(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        // table list
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->label('Nama')
                        ->size(TextColumnSize::Large)
                        ->weight(FontWeight::Bold)
                        ->alignment('center'),

                    Stack::make([
                        ImageColumn::make('foto')
                            ->label('Foto')
                            ->disk('public')
                            ->height(200)
                            ->width(200)
                            ->circular()
                            ->alignment('center'),
                    ])->extraAttributes([
                        'class' => 'p-4'
                    ]),

                    Stack::make([
                        TextColumn::make('keahlian')
                            ->label('Keahlian')
                            ->size(TextColumnSize::ExtraSmall)
                            ->color('success')
                            ->badge()
                            ->alignment('center'),
                        TextColumn::make('hari')
                            ->label('Hari Tugas')
                            ->alignment('center'),
                    ])
                ]),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])->actionsAlignment('center')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPstOfficers::route('/'),
            'create' => Pages\CreatePstOfficer::route('/create'),
            'edit' => Pages\EditPstOfficer::route('/{record}/edit'),
        ];
    }
}

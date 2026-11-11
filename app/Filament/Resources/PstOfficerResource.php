<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PstOfficerResource\Pages;
use App\Filament\Resources\PstOfficerResource\RelationManagers;
use App\Models\PstOfficer;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PstOfficerResource extends Resource
{
    // model
    protected static ?string $model = PstOfficer::class;

    // model label
    protected static ?string $modelLabel = 'Petugas PST';
    protected static ?string $pluralModelLabel = 'Petugas PST';

    // icon
    protected static ?string $navigationIcon = 'heroicon-o-user';

    // title nav
    protected static ?string $navigationLabel = 'Petugas PST';

    // slug
    protected static ?string $slug = 'petugas-pst';

    // sort
    protected static ?int $navigationSort = 4;

    // group
    protected static ?string $navigationGroup = 'PST';

    public static function form(Form $form): Form
    {
        // input form
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('nip')
                    ->label('NIP')
                    ->required(),
                Select::make('work_team_id')
                    ->label('Work Team')
                    ->relationship('work_team', 'name')
                    ->required(),
                TextInput::make('nomor_hp')
                    ->label('Nomor HP')
                    ->numeric()
                    ->required(),
                Select::make('jenis')
                    ->label('Jenis')
                    ->options([
                        'pst' => 'pst',
                        'non pst' => 'non pst'
                    ])
                    ->required(),
                FileUpload::make('foto')
                    ->label('Upload Foto')
                    ->disk('public')
                    ->directory('foto_petugas')
                    ->image()
                    ->imageEditor()
                    ->imageCropAspectRatio('1:1')
                    ->imageEditorAspectRatios([
                        '1:1',
                    ])
                    ->maxSize(2048)
                    ->nullable(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        // table list
        return $table
            ->contentGrid([
                'md' => 3,
                'xl' => 4,
            ])
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->label('Nama')
                        ->size(TextColumnSize::Large)
                        ->weight(FontWeight::Bold)
                        ->alignment('center'),

                    Stack::make([
                        ViewColumn::make('foto')
                            ->view('filament.foto-petugas'),
                    ])->extraAttributes([
                        'class' => 'p-4'
                    ]),
                    Stack::make([
                        TextColumn::make('jenis')
                            ->label('Jenis')
                            ->size(TextColumnSize::Small)
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

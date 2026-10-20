<?php

namespace App\Filament\Resources;

use App\Filament\Exports\GuestBookExporter;
use App\Filament\Resources\GuestBookResource\Pages;
use App\Filament\Resources\GuestBookResource\RelationManagers;
use App\Models\GuestBook;
use App\Models\PstOfficer;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuestBookResource extends Resource
{
    protected static ?string $model = GuestBook::class;

    // icon
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    // title nav
    protected static ?string $navigationLabel = 'Buku Tamu';

    public static function form(Form $form): Form
    {
        // input form
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                TextInput::make('instansi')
                    ->label('Instansi')
                    ->required(),
                 Select::make('keperluan')
                    ->label('Keperluan')
                    ->options([
                        'PST' => 'PST',
                        'NON PST' => 'Non PST',
                    ])
                    ->live()
                    ->required(),
                Select::make('detail_keperluan')
                    ->label('Detail Keperluan')
                    ->options(function (Get $get) {
                        $keperluan = $get('keperluan');

                        // opsi PST
                        if ($keperluan === 'PST') {
                            return [
                                'Rekomendasi statistik' => 'Rekomendasi Statistik',
                                'Konsultasi Data' => 'Konsultasi Data',
                                'Permintaan Data' => 'Permintaan Data'
                            ];
                        }

                        else if ($keperluan === 'NON PST') {
                            return [
                                'Keperluan Instansi' => 'Keperluan Instansi',
                                'Keperluan Umum' => 'Keperluan Umum'
                            ];
                        }

                        return [];
                    })
                    ->hidden(fn (Get $get): bool => ! $get('keperluan'))
                    ->required(),
                TextInput::make('no_hp')
                    ->label('No HP')
                    ->numeric()
                    ->required(),
                Select::make('petugas')
                    ->label('Petugas')
                    ->options(PstOfficer::all()->pluck('name', 'name'))
                    ->required(),
                RichEditor::make('catatan_konsultasi')
                    ->label('Catatan Konsultasi')
                    ->required(),
                FileUpload::make('dokumentasi')
                    ->label('Upload Foto')
                    ->disk('public')
                    ->directory('dokumentasi')
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
            ->columns([
                TextColumn::make('name')
                    ->label('Nama'),
                TextColumn::make('instansi')
                    ->label('Instansi'),
                TextColumn::make('keperluan')
                    ->label('Keperluan'),
                TextColumn::make('detail_keperluan')
                    ->label('Detail Keperluan'),
                TextColumn::make('no_hp')
                    ->label('No HP'),
                TextColumn::make('petugas')
                    ->label('Petugas'),
                TextColumn::make('catatan_konsultasi')
                    ->label('Catatan Konsultasi')
                    // ->html()
                    ->limit(30),
                ImageColumn::make('dokumentasi')
                    ->label('Dokumentasi')
                    ->disk('public')
                    ->height(50)
                    ->width(50),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d-m-Y'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(GuestBookExporter::class)
                    ->label('Export Excel/CSV')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('success')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
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
            'index' => Pages\ListGuestBooks::route('/'),
            'create' => Pages\CreateGuestBook::route('/create'),
            'edit' => Pages\EditGuestBook::route('/{record}/edit'),
        ];
    }
}

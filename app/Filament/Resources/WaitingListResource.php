<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WaitingListResource\Pages;
use App\Filament\Resources\WaitingListResource\RelationManagers;
use App\Models\GuestBook;
use App\Models\PstOfficer;
use App\Models\WaitingList;
use App\Services\WhatsAppService;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WaitingListResource extends Resource
{
    // model
    protected static ?string $model = WaitingList::class;

    // model label
    protected static ?string $modelLabel = 'Ruang Tunggu';
    protected static ?string $pluralModelLabel = 'Ruang Tunggu';

    // icon
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // title nav
    protected static ?string $navigationLabel = 'Ruang Tunggu';

    // slug
    protected static ?string $slug = 'ruang-tunggu';

    // sort
    protected static ?int $navigationSort = 0;


    public static function form(Form $form): Form
    {
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
                        if ($get('keperluan') === 'PST') {
                            return [
                                'Rekomendasi statistik' => 'Rekomendasi Statistik',
                                'Konsultasi Data' => 'Konsultasi Data',
                                'Permintaan Data' => 'Permintaan Data',
                                'Lainnya' => 'Lainnya',
                            ];
                        }

                        if ($get('keperluan') === 'NON PST') {
                            return [
                                'Keperluan Instansi' => 'Keperluan Instansi',
                                'Keperluan Umum' => 'Keperluan Umum',
                                'Lainnya' => 'Lainnya',
                            ];
                        }

                        return [];
                    })
                    ->live()
                    ->required()
                    ->hidden(fn(Get $get): bool => ! $get('keperluan')),
                TextInput::make('keperluan_lainnya')
                    ->label('Rincian Keperluan Lainnya')
                    ->visible(
                        fn(Get $get): bool =>
                        $get('detail_keperluan') === 'Lainnya'
                    )
                    ->required(
                        fn(Get $get): bool =>
                        $get('detail_keperluan') === 'Lainnya'
                    ),
                TextInput::make('no_hp')
                    ->label('No HP')
                    ->numeric(),
                Select::make('petugas')
                    ->label('Petugas')
                    ->options(PstOfficer::all()->pluck('name', 'name'))
                    ->required(),
                Hidden::make('status')
                    ->default('Menunggu'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('instansi')
                    ->label('Instansi'),
                TextColumn::make('keperluan')
                    ->label('Keperluan'),
                TextColumn::make('detail_keperluan')
                    ->label('Detail Keperluan')
                    ->getStateUsing(function (WaitingList $record) {
                        if ($record->detail_keperluan === 'Lainnya') {
                            return $record->keperluan_lainnya ?? 'Lainnya';
                        }
                        return $record->detail_keperluan;
                    }),
                TextColumn::make('no_hp')
                    ->label('No HP'),
                TextColumn::make('petugas')
                    ->label('Petugas'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Menunggu' => 'gray',
                        'Diproses' => 'warning',
                        'Selesai' => 'success'
                    })
                    ->getStateUsing(function (WaitingList $record) {
                        return $record->status;
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Menunggu -> Diproses
                Action::make('proses')
                    ->label('Proses')
                    ->icon('heroicon-o-check-circle')
                    ->color('warning')
                    ->visible(fn($record) => $record->status === 'Menunggu')
                    ->action(function ($record) {
                        $record->update(['status' => 'Diproses']);
                        Notification::make()->title('Status diubah menjadi Diproses')->success()->send();
                    })
                    ->requiresConfirmation(),

                // Diproses -> Selesai
                Action::make('selesai')
                    ->label('Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'Diproses')
                    ->form([
                        Textarea::make('catatan_konsultasi')
                            ->label('Catatan Konsultasi')
                            ->required()
                            ->rows(3)
                            ->placeholder('Tuliskan ringkasan konsultasi atau hasil pelayanan...'),

                        FileUpload::make('dokumentasi')
                            ->label('Upload Foto')
                            ->image()
                            ->disk('public')
                            ->directory('dokumentasi')
                            ->nullable(),
                    ])
                    ->action(function ($record, array $data) {
                        // Pindahkan ke tabel guest_books
                        $guestBook                     = new GuestBook();
                        $guestBook->token              = $record->token;
                        $guestBook->nomor_antrean      = $record->nomor_antrean;
                        $guestBook->name               = $record->name;
                        $guestBook->instansi           = $record->instansi;
                        $guestBook->keperluan          = $record->keperluan;
                        $guestBook->detail_keperluan   = $record->detail_keperluan;
                        $guestBook->keperluan_lainnya  = $record->keperluan_lainnya;
                        $guestBook->no_hp              = $record->no_hp;
                        $guestBook->petugas            = $record->petugas;
                        $guestBook->catatan_konsultasi = $data['catatan_konsultasi'];
                        $guestBook->dokumentasi        = $data['dokumentasi'] ?? null;
                        $guestBook->status             = 'Selesai';
                        $guestBook->save();

                        // Hapus dari ruang tunggu
                        $record->delete();

                        Notification::make()
                            ->title('Data masuk Buku Tamu')
                            ->success()
                            ->send();
                    }),

                // ── Kirim Pemberitahuan WhatsApp ke Petugas ──
                Action::make('kirim_wa')
                    ->label('Kirim WA')
                    ->icon('icon-whatsapp')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'Diproses')
                    ->modalHeading('Kirim Pemberitahuan WhatsApp ke Petugas')
                    ->modalDescription('Periksa preview pesan di bawah sebelum mengirim.')
                    ->modalWidth('lg')
                    ->fillForm(function ($record): array {
                        $officer = PstOfficer::where('name', $record->petugas)->first();
                        $nomorHp = $officer?->nomor_hp ?? '-';

                        $detail = $record->detail_keperluan === 'Lainnya'
                            ? ($record->keperluan_lainnya ?? 'Lainnya')
                            : $record->detail_keperluan;

                        $pesan = "Assalamualaikum, {$record->petugas}. 🙏\n\n"
                            . "Ada tamu yang sedang menunggu pelayanan Anda di PST BPS Sampang:\n\n"
                            . "👤 Nama           : {$record->name}\n"
                            . "🏢 Instansi        : {$record->instansi}\n"
                            . "📋 Keperluan       : {$record->keperluan} - {$detail}\n"
                            . "🎫 Nomor Antrean   : {$record->nomor_antrean}\n\n"
                            . "Mohon segera berikan pelayanan terbaik. Terima kasih! 😊\n\n"
                            . "— Sistem PST BPS Kabupaten Sampang";

                        return [
                            'nomor_hp_petugas' => $nomorHp,
                            'preview_pesan'    => $pesan,
                        ];
                    })
                    ->form([
                        Placeholder::make('nomor_hp_petugas')
                            ->label('📱 Dikirim ke nomor'),

                        Placeholder::make('preview_pesan')
                            ->label('📝 Preview Pesan'),
                    ])
                    ->action(function ($record) {
                        $officer = PstOfficer::where('name', $record->petugas)->first();

                        if (! $officer || ! $officer->nomor_hp) {
                            Notification::make()
                                ->title('Gagal Kirim ❌')
                                ->body("Nomor HP petugas \"{$record->petugas}\" tidak ditemukan. Pastikan data petugas PST sudah lengkap.")
                                ->danger()
                                ->send();
                            return;
                        }

                        $detail = $record->detail_keperluan === 'Lainnya'
                            ? ($record->keperluan_lainnya ?? 'Lainnya')
                            : $record->detail_keperluan;

                        $pesan = "Assalamualaikum, {$record->petugas}. 🙏\n\n"
                            . "Ada tamu yang sedang menunggu pelayanan Anda di PST BPS Sampang:\n\n"
                            . "👤 Nama           : {$record->name}\n"
                            . "🏢 Instansi        : {$record->instansi}\n"
                            . "📋 Keperluan       : {$record->keperluan} - {$detail}\n"
                            . "🎫 Nomor Antrean   : {$record->nomor_antrean}\n\n"
                            . "Mohon segera berikan pelayanan terbaik. Terima kasih! 😊\n\n"
                            . "— Sistem PST BPS Kabupaten Sampang";

                        $result = WhatsAppService::send($officer->nomor_hp, $pesan);

                        if ($result['success']) {
                            Notification::make()
                                ->title('Pemberitahuan Terkirim ✅')
                                ->body("WA berhasil dikirim ke {$officer->name} ({$officer->nomor_hp})")
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Gagal Mengirim WA ❌')
                                ->body("Gagal: {$result['message']}")
                                ->danger()
                                ->persistent()
                                ->send();
                        }
                    })
                    ->modalSubmitActionLabel('Kirim Sekarang')
                    ->modalCancelActionLabel('Batal'),

                // ── Lihat QR Antrean ──
                Action::make('lihat_antrean')
                    ->label('Antrean')
                    ->icon('heroicon-o-qr-code')
                    ->color('gray')
                    ->modalHeading('Antrean')
                    ->modalContent(fn($record) => view('filament.pages.actions.qr-antrean', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
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
            'index' => Pages\ListWaitingLists::route('/'),
            'create' => Pages\CreateWaitingList::route('/create'),
            'edit' => Pages\EditWaitingList::route('/{record}/edit'),
        ];
    }
}

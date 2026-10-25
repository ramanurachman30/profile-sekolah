<?php

namespace App\Filament\Resources\SchoolVisits\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SchoolVisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->weight('bold')
                    ->searchable()
                    ->copyable()
                    ->sortable(),

                TextColumn::make('parent_name')
                    ->label('Nama Wali Murid')
                    ->searchable()
                    ->weight('medium'),

                TextColumn::make('parent_phone')
                    ->label('No. WhatsApp')
                    ->searchable(),

                TextColumn::make('visit_date')
                    ->label('Tgl Kunjungan')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('visit_session')
                    ->label('Sesi')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('attendees_count')
                    ->label('Peserta')
                    ->suffix(' Org')
                    ->alignCenter(),

                TextColumn::make('visit_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->status_label)
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'dikonfirmasi' => 'info',
                        'selesai' => 'success',
                        'dibatalkan' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('handler.full_name')
                    ->label('Petugas TU')
                    ->placeholder('Belum Ditugaskan')
                    ->limit(20),
            ])
            ->defaultSort('visit_date', 'asc')
            ->filters([
                SelectFilter::make('visit_status')
                    ->label('Status')
                    ->options([
                        'menunggu' => 'Menunggu Konfirmasi',
                        'dikonfirmasi' => 'Dikonfirmasi',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ]),

                SelectFilter::make('visit_session')
                    ->label('Sesi Jam')
                    ->options([
                        'pagi' => 'Sesi Pagi',
                        'siang' => 'Sesi Siang',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),

                // Aksi Konfirmasi Kunjungan
                Action::make('confirm')
                    ->label('Konfirmasi')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn ($record) => $record->visit_status === 'menunggu')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Jadwal Kunjungan')
                    ->modalDescription(fn ($record) => "Konfirmasi bahwa pihak sekolah siap menyambut kunjungan {$record->parent_name} pada tanggal {$record->visit_date->format('d/m/Y')} ({$record->visit_session})?")
                    ->action(function ($record) {
                        $record->update([
                            'visit_status' => 'dikonfirmasi',
                            'handled_by_user_id' => Auth::id(),
                        ]);

                        Notification::make()
                            ->title('Jadwal Kunjungan Berhasil Dikonfirmasi')
                            ->success()
                            ->send();
                    }),

                // Aksi Tandai Selesai
                Action::make('complete')
                    ->label('Selesai')
                    ->icon(Heroicon::OutlinedCheck)
                    ->color('info')
                    ->visible(fn ($record) => $record->visit_status === 'dikonfirmasi')
                    ->action(function ($record) {
                        $record->update([
                            'visit_status' => 'selesai',
                        ]);

                        Notification::make()
                            ->title('Kunjungan Ditandai Selesai')
                            ->success()
                            ->send();
                    }),

                // Aksi Batalkan Kunjungan
                Action::make('cancel')
                    ->label('Batal')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn ($record) => in_array($record->visit_status, ['menunggu', 'dikonfirmasi']))
                    ->form([
                        Textarea::make('internal_notes')
                            ->label('Alasan Pembatalan / Catatan')
                            ->required()
                            ->placeholder('Contoh: Bertepatan dengan kegiatan asesmen sumatif / permohonan reschedule wali murid.'),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'visit_status' => 'dibatalkan',
                            'internal_notes' => $data['internal_notes'],
                            'handled_by_user_id' => Auth::id(),
                        ]);

                        Notification::make()
                            ->title('Kunjungan Dibatalkan')
                            ->warning()
                            ->send();
                    }),

                // Direct WhatsApp ke Calon Pengunjung
                Action::make('whatsapp')
                    ->label('WA Pengunjung')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('success')
                    ->url(function ($record) {
                        $phone = preg_replace('/[^0-9]/', '', $record->parent_phone);
                        if (str_starts_with($phone, '0')) {
                            $phone = '62' . substr($phone, 1);
                        }
                        $text = urlencode("Halo Bpk/Ibu {$record->parent_name}, kami dari SDN Cikereteg 01 mengonfirmasi reservasi kunjungan sekolah (Kode Booking: {$record->booking_code}) pada tanggal {$record->visit_date->format('d/m/Y')}: ");
                        return "https://wa.me/{$phone}?text={$text}";
                    }, shouldOpenInNewTab: true),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()?->role === 'superadmin'),
                ]),
            ]);
    }
}

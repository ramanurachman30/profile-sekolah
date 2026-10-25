<?php

namespace App\Filament\Resources\ContactInquiries\Tables;

use App\Models\Teacher;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ContactInquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('No. Tiket')
                    ->weight('bold')
                    ->searchable()
                    ->copyable()
                    ->sortable(),

                TextColumn::make('sender_name')
                    ->label('Nama Pengirim')
                    ->searchable()
                    ->weight('medium'),

                TextColumn::make('sender_phone')
                    ->label('No. WhatsApp')
                    ->searchable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->category_label)
                    ->color(fn (string $state): string => match ($state) {
                        'ppdb' => 'primary',
                        'administrasi' => 'info',
                        'mutasi' => 'warning',
                        'konsultasi' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('ticket_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->status_label)
                    ->color(fn (string $state): string => match ($state) {
                        'baru' => 'warning',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        'arsip' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('assignedTeacher.full_name')
                    ->label('Disposisi Guru')
                    ->placeholder('Belum Disposisi')
                    ->limit(20),

                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('ticket_status')
                    ->label('Status Tiket')
                    ->options([
                        'baru' => 'Tiket Baru',
                        'diproses' => 'Sedang Diproses',
                        'selesai' => 'Selesai',
                        'arsip' => 'Diarsipkan',
                    ]),

                SelectFilter::make('category')
                    ->label('Kategori Pesan')
                    ->options([
                        'ppdb' => 'Informasi PPDB',
                        'administrasi' => 'Administrasi & Surat',
                        'mutasi' => 'Mutasi Siswa',
                        'konsultasi' => 'Konsultasi Belajar',
                        'lainnya' => 'Saran / Lainnya',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),

                // Aksi Respon Cepat
                Action::make('respond')
                    ->label('Beri Respon')
                    ->icon(Heroicon::OutlinedChatBubbleLeftEllipsis)
                    ->color('primary')
                    ->form([
                        Textarea::make('response_notes')
                            ->label('Catatan Jawaban Resmi')
                            ->required()
                            ->rows(4)
                            ->placeholder('Tuliskan jawaban atau hasil tindak lanjut...'),
                        Select::make('ticket_status')
                            ->label('Ubah Status Tiket')
                            ->options([
                                'diproses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                            ])
                            ->default('selesai')
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'response_notes' => $data['response_notes'],
                            'ticket_status' => $data['ticket_status'],
                            'responded_at' => Carbon::now(),
                        ]);

                        Notification::make()
                            ->title('Respon Tiket Berhasil Disimpan')
                            ->success()
                            ->send();
                    }),

                // Aksi Disposisi ke Dewan Guru
                Action::make('disposition')
                    ->label('Disposisi Guru')
                    ->icon(Heroicon::OutlinedArrowRightCircle)
                    ->color('warning')
                    ->form([
                        Select::make('assigned_to_teacher_id')
                            ->label('Pilih Dewan Guru Tujuan')
                            ->options(Teacher::pluck('full_name', 'id'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'assigned_to_teacher_id' => $data['assigned_to_teacher_id'],
                            'ticket_status' => 'diproses',
                        ]);

                        Notification::make()
                            ->title('Tiket Berhasil Didisposisikan ke Guru')
                            ->success()
                            ->send();
                    }),

                // Direct WhatsApp ke Pengirim
                Action::make('whatsapp')
                    ->label('WA Pengirim')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('success')
                    ->url(function ($record) {
                        $phone = preg_replace('/[^0-9]/', '', $record->sender_phone);
                        if (str_starts_with($phone, '0')) {
                            $phone = '62' . substr($phone, 1);
                        }
                        $text = urlencode("Halo {$record->sender_name}, kami dari SDN Cikereteg 01 merespon tiket aduan/pesan Anda ({$record->ticket_number}): ");
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

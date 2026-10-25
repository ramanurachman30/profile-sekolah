<?php

namespace App\Filament\Resources\ContactInquiries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactInquiryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tiket Aduan')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('ticket_number')
                            ->label('Nomor Tiket')
                            ->weight('bold')
                            ->copyable(),
                        TextEntry::make('category')
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
                        TextEntry::make('ticket_status')
                            ->label('Status Tiket')
                            ->badge()
                            ->formatStateUsing(fn ($record) => $record->status_label)
                            ->color(fn (string $state): string => match ($state) {
                                'baru' => 'warning',
                                'diproses' => 'info',
                                'selesai' => 'success',
                                'arsip' => 'gray',
                                default => 'gray',
                            }),
                        TextEntry::make('created_at')
                            ->label('Waktu Masuk')
                            ->dateTime('d/m/Y H:i'),
                    ]),

                Section::make('Identitas Pengirim & Kontak')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('sender_name')
                            ->label('Nama Pengirim')
                            ->weight('bold'),
                        TextEntry::make('sender_phone')
                            ->label('Nomor WhatsApp / HP')
                            ->copyable(),
                        TextEntry::make('sender_email')
                            ->label('Email')
                            ->placeholder('-'),
                        TextEntry::make('preferred_channel')
                            ->label('Saluran Balasan Pilihan')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                    ]),

                Section::make('Uraian Pesan & Pertanyaan')
                    ->schema([
                        TextEntry::make('subject')
                            ->label('Subjek / Topik')
                            ->weight('bold'),
                        TextEntry::make('message')
                            ->label('Isi Pesan')
                            ->prose()
                            ->columnSpanFull(),
                    ]),

                Section::make('Tindak Lanjut & Disposisi Sekolah')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('assignedTeacher.full_name')
                            ->label('Guru yang Ditugaskan / Disposisi')
                            ->placeholder('Belum ada disposisi guru'),
                        TextEntry::make('responded_at')
                            ->label('Waktu Respon Terakhir')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('Belum ada respon'),
                        TextEntry::make('response_notes')
                            ->label('Catatan Hasil Tindak Lanjut / Respon TU')
                            ->placeholder('Belum ada catatan tindak lanjut.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

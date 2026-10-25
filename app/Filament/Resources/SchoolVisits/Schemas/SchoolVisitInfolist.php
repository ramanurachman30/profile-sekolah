<?php

namespace App\Filament\Resources\SchoolVisits\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SchoolVisitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Booking Kunjungan')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('booking_code')
                            ->label('Kode Booking')
                            ->weight('bold')
                            ->copyable(),
                        TextEntry::make('visit_status')
                            ->label('Status Kunjungan')
                            ->badge()
                            ->formatStateUsing(fn ($record) => $record->status_label)
                            ->color(fn (string $state): string => match ($state) {
                                'menunggu' => 'warning',
                                'dikonfirmasi' => 'info',
                                'selesai' => 'success',
                                'dibatalkan' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('handler.full_name')
                            ->label('Petugas TU')
                            ->placeholder('Belum Ditugaskan'),
                        TextEntry::make('created_at')
                            ->label('Waktu Booking Masuk')
                            ->dateTime('d/m/Y H:i'),
                    ]),

                Section::make('Identitas Calon Pengunjung')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('parent_name')
                            ->label('Nama Orang Tua / Calon Wali')
                            ->weight('bold'),
                        TextEntry::make('parent_phone')
                            ->label('No. WhatsApp Aktif')
                            ->copyable(),
                    ]),

                Section::make('Jadwal & Agenda Kunjungan')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('visit_date')
                            ->label('Tanggal Kunjungan')
                            ->date('l, d F Y')
                            ->weight('bold'),
                        TextEntry::make('visit_session')
                            ->label('Sesi Waktu')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => $state === 'pagi' ? 'Pagi (08.00 - 10.00 WIB)' : 'Siang (10.30 - 12.00 WIB)'),
                        TextEntry::make('attendees_count')
                            ->label('Jumlah Peserta Hadir')
                            ->suffix(' Orang'),
                        TextEntry::make('grade_interest')
                            ->label('Jenjang Peminatan')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'kelas_1' => 'Calon Peserta Didik Kelas 1',
                                'umum' => 'Kunjungan Umum',
                                default => 'Pindahan ' . ucfirst(str_replace('_', ' ', $state)),
                            }),
                    ]),

                Section::make('Catatan Khusus')
                    ->schema([
                        TextEntry::make('internal_notes')
                            ->label('Catatan Keperluan / Catatan Khusus')
                            ->placeholder('Tidak ada catatan khusus.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

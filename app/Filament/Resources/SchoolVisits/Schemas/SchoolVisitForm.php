<?php

namespace App\Filament\Resources\SchoolVisits\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SchoolVisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Reservasi Kunjungan')
                    ->columns(3)
                    ->schema([
                        TextInput::make('booking_code')
                            ->label('Kode Booking')
                            ->disabled()
                            ->dehydrated(),
                        Select::make('visit_status')
                            ->label('Status Kunjungan')
                            ->options([
                                'menunggu' => 'Menunggu Konfirmasi',
                                'dikonfirmasi' => 'Jadwal Dikonfirmasi',
                                'selesai' => 'Kunjungan Selesai',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->required(),
                        Select::make('handled_by_user_id')
                            ->label('Petugas TU Penanggung Jawab')
                            ->options(User::whereIn('role', ['superadmin', 'admin_tu'])->pluck('full_name', 'id'))
                            ->placeholder('Pilih petugas'),
                    ]),

                Section::make('Identitas Calon Pengunjung')
                    ->columns(2)
                    ->schema([
                        TextInput::make('parent_name')
                            ->label('Nama Orang Tua / Wali')
                            ->required(),
                        TextInput::make('parent_phone')
                            ->label('No. WhatsApp Aktif')
                            ->tel()
                            ->required(),
                    ]),

                Section::make('Jadwal & Detail Rencana Kunjungan')
                    ->columns(3)
                    ->schema([
                        DatePicker::make('visit_date')
                            ->label('Tanggal Kunjungan')
                            ->required(),
                        Select::make('visit_session')
                            ->label('Sesi Waktu')
                            ->options([
                                'pagi' => 'Sesi Pagi (08.00 - 10.00 WIB)',
                                'siang' => 'Sesi Siang (10.30 - 12.00 WIB)',
                            ])
                            ->required(),
                        TextInput::make('attendees_count')
                            ->label('Jumlah Rombongan')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10)
                            ->required(),
                        Select::make('grade_interest')
                            ->label('Jenjang Peminatan')
                            ->options([
                                'kelas_1' => 'Calon Peserta Didik Kelas 1',
                                'kelas_2' => 'Pindahan Kelas 2',
                                'kelas_3' => 'Pindahan Kelas 3',
                                'kelas_4' => 'Pindahan Kelas 4',
                                'kelas_5' => 'Pindahan Kelas 5',
                                'kelas_6' => 'Pindahan Kelas 6',
                                'umum' => 'Kunjungan Umum / Lembaga',
                            ])
                            ->required(),
                    ]),

                Section::make('Catatan Khusus Kunjungan')
                    ->schema([
                        Textarea::make('internal_notes')
                            ->label('Catatan Keperluan / Catatan Petugas TU')
                            ->rows(3)
                            ->placeholder('Keperluan khusus pengunjung atau catatan koordinasi internal...'),
                    ]),
            ]);
    }
}

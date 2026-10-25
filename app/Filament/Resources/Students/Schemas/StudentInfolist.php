<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Siswa')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('full_name')
                            ->label('Nama Lengkap')
                            ->weight('bold'),
                        TextEntry::make('nickname')
                            ->label('Nama Panggilan')
                            ->placeholder('-'),
                        TextEntry::make('gender')
                            ->label('Jenis Kelamin')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'aktif' => 'success',
                                'lulus' => 'info',
                                'mutasi' => 'warning',
                                'keluar' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('nisn')
                            ->label('NISN')
                            ->copyable()
                            ->placeholder('-'),
                        TextEntry::make('nis')
                            ->label('NIS Sekolah')
                            ->placeholder('-'),
                        TextEntry::make('nik')
                            ->label('NIK')
                            ->placeholder('-'),
                        TextEntry::make('birth_date')
                            ->label('Tempat, Tanggal Lahir')
                            ->formatStateUsing(fn ($record) => ($record->birth_place ? $record->birth_place . ', ' : '') . ($record->birth_date ? $record->birth_date->format('d/m/Y') : '-')),
                    ]),

                Section::make('Rombongan Belajar')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('currentClass.class_name')
                            ->label('Kelas Saat Ini')
                            ->weight('bold')
                            ->badge()
                            ->color('primary')
                            ->placeholder('Belum Ditempatkan'),
                        TextEntry::make('currentClass.homeroomTeacher.full_name')
                            ->label('Wali Kelas')
                            ->placeholder('Belum Ditentukan'),
                        TextEntry::make('currentClass.room_name')
                            ->label('Ruang Belajar')
                            ->placeholder('-'),
                    ]),

                Section::make('Data Orang Tua / Wali & Domisili')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('parent_guardian_name')
                            ->label('Nama Orang Tua / Wali')
                            ->weight('bold'),
                        TextEntry::make('parent_phone')
                            ->label('No. WhatsApp / HP')
                            ->copyable(),
                        TextEntry::make('rt_rw')
                            ->label('RT / RW')
                            ->placeholder('-'),
                        TextEntry::make('address')
                            ->label('Alamat Lengkap')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

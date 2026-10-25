<?php

namespace App\Filament\Resources\ClassRooms\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClassRoomInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Rombel')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('class_name')
                            ->label('Nama Rombel')
                            ->weight('bold'),
                        TextEntry::make('grade.grade_level')
                            ->label('Tingkat Kelas')
                            ->formatStateUsing(fn ($state) => "Kelas {$state}")
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('academicYear.year_code')
                            ->label('Tahun Ajaran'),
                        TextEntry::make('capacity')
                            ->label('Kapasitas Ruang')
                            ->suffix(' Siswa'),
                    ]),

                Section::make('Wali Kelas & Fasilitas Ruang')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('homeroomTeacher.full_name')
                            ->label('Wali Kelas')
                            ->placeholder('Belum Ditentukan')
                            ->weight('bold'),
                        TextEntry::make('room_name')
                            ->label('Lokasi Ruangan')
                            ->placeholder('-'),
                        TextEntry::make('active_students_count')
                            ->label('Jumlah Siswa Aktif Terdaftar')
                            ->suffix(' Siswa')
                            ->badge()
                            ->color('success'),
                    ]),

                Section::make('Daftar Siswa Terdaftar di Rombel Ini')
                    ->schema([
                        RepeatableEntry::make('students')
                            ->label('')
                            ->schema([
                                TextEntry::make('nisn')->label('NISN')->copyable(),
                                TextEntry::make('full_name')->label('Nama Lengkap')->weight('bold'),
                                TextEntry::make('gender')->label('L/P')->badge(),
                                TextEntry::make('status')->label('Status')->badge(),
                            ])
                            ->columns(4),
                    ]),
            ]);
    }
}

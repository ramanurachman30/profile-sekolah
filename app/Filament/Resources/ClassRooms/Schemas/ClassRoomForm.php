<?php

namespace App\Filament\Resources\ClassRooms\Schemas;

use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Teacher;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClassRoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Rombel & Tingkat')
                    ->columns(3)
                    ->schema([
                        Select::make('academic_year_id')
                            ->label('Tahun Ajaran')
                            ->options(AcademicYear::pluck('year_code', 'id'))
                            ->required(),
                        Select::make('grade_id')
                            ->label('Tingkat Kelas')
                            ->options(Grade::pluck('grade_level', 'id')->map(fn ($level) => "Kelas {$level}"))
                            ->required(),
                        TextInput::make('class_name')
                            ->label('Nama Rombel')
                            ->required()
                            ->placeholder('Contoh: Kelas 1-A / Kelas 6-B'),
                    ]),

                Section::make('Wali Kelas & Lokasi Ruang')
                    ->columns(3)
                    ->schema([
                        Select::make('homeroom_teacher_id')
                            ->label('Wali Kelas')
                            ->options(Teacher::pluck('full_name', 'id'))
                            ->searchable()
                            ->placeholder('Pilih guru wali kelas'),
                        TextInput::make('room_name')
                            ->label('Lokasi Ruangan')
                            ->placeholder('Contoh: Gedung A Lantai 1 (R. 101)'),
                        TextInput::make('capacity')
                            ->label('Kapasitas Maksimal Siswa')
                            ->numeric()
                            ->default(28)
                            ->required(),
                    ]),
            ]);
    }
}

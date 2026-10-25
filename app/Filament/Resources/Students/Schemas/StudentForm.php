<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\ClassRoom;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Pribadi Siswa')
                    ->columns(3)
                    ->schema([
                        TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('nickname')
                            ->label('Nama Panggilan')
                            ->maxLength(30),
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                        TextInput::make('nisn')
                            ->label('NISN (10 Digit)')
                            ->length(10)
                            ->placeholder('00xxxxxxxx')
                            ->unique(ignoreRecord: true),
                        TextInput::make('nis')
                            ->label('NIS Sekolah')
                            ->maxLength(20)
                            ->placeholder('Nomor Induk Lokal'),
                        TextInput::make('nik')
                            ->label('NIK Siswa (16 Digit)')
                            ->length(16)
                            ->placeholder('3201xxxxxxxxxxxx'),
                        TextInput::make('birth_place')
                            ->label('Tempat Lahir')
                            ->placeholder('Contoh: Bogor'),
                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->required(),
                    ]),

                Section::make('Penempatan Kelas & Status Akademik')
                    ->columns(2)
                    ->schema([
                        Select::make('current_class_id')
                            ->label('Rombel Kelas Saat Ini')
                            ->options(ClassRoom::pluck('class_name', 'id'))
                            ->searchable()
                            ->placeholder('Pilih kelas'),
                        Select::make('status')
                            ->label('Status Siswa')
                            ->options([
                                'aktif' => 'Siswa Aktif',
                                'lulus' => 'Lulus',
                                'mutasi' => 'Pindah / Mutasi',
                                'keluar' => 'Keluar / Drop Out',
                            ])
                            ->default('aktif')
                            ->required(),
                    ]),

                Section::make('Data Orang Tua & Domisili')
                    ->columns(2)
                    ->schema([
                        TextInput::make('parent_guardian_name')
                            ->label('Nama Orang Tua / Wali')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('parent_phone')
                            ->label('No. WhatsApp / HP Orang Tua')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        Textarea::make('address')
                            ->label('Alamat Rumah Lengkap')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('rt_rw')
                            ->label('RT / RW')
                            ->placeholder('Contoh: RT 02 / RW 05'),
                    ]),
            ]);
    }
}

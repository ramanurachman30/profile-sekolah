<?php

namespace App\Filament\Resources\Achievements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AchievementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kejuaraan & Prestasi')
                    ->columns(2)
                    ->schema([
                        Select::make('category_id')
                            ->label('Kategori Prestasi')
                            ->relationship('category', 'category_name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('academic_year_id')
                            ->label('Tahun Ajaran')
                            ->relationship('academicYear', 'year_name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('achievement_title')
                            ->label('Judul Prestasi / Raihan')
                            ->required()
                            ->maxLength(150)
                            ->columnSpanFull()
                            ->placeholder('Contoh: Juara 1 Tari Kreasi Daerah Sunda FLS2N'),

                        TextInput::make('competition_name')
                            ->label('Nama Ajang Perlombaan')
                            ->required()
                            ->maxLength(180)
                            ->columnSpanFull()
                            ->placeholder('Contoh: FLS2N Tingkat Kabupaten Bogor 2026'),

                        Select::make('level')
                            ->label('Tingkat Kompetisi')
                            ->options([
                                'kecamatan' => 'Kecamatan',
                                'kabupaten' => 'Kabupaten / Kota',
                                'provinsi' => 'Provinsi',
                                'nasional' => 'Nasional',
                                'internasional' => 'Internasional',
                            ])
                            ->default('kecamatan')
                            ->required(),

                        TextInput::make('ranking_position')
                            ->label('Peringkat Juara / Medali')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('Contoh: Juara 1 / Medali Emas / Harapan 2'),

                        DatePicker::make('competition_date')
                            ->label('Tanggal Pelaksanaan')
                            ->default(now())
                            ->required(),

                        Select::make('mentor_teacher_id')
                            ->label('Guru Pembimbing / Pelatih')
                            ->relationship('mentorTeacher', 'full_name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih guru pembina jika ada'),
                    ]),

                Section::make('Peraih Penghargaan & Dokumentasi')
                    ->columns(2)
                    ->schema([
                        TextInput::make('recipient_summary')
                            ->label('Ringkasan Siswa / Tim Peraih')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Contoh: Tim Tari Siswi Kelas 4 & 5 / Rizky Aditya (Kelas 5)'),

                        TextInput::make('parent_rep_name')
                            ->label('Perwakilan Orang Tua / Pendamping')
                            ->maxLength(150)
                            ->placeholder('Contoh: Paguyuban Orang Tua Siswa Kelas 5'),

                        Select::make('recipients')
                            ->label('Tautkan Siswa Terdaftar (Master Siswa)')
                            ->relationship('recipients', 'full_name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->helperText('Tautkan record siswa terdaftar jika ada'),

                        Textarea::make('description')
                            ->label('Uraian Deskripsi Prestasi')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Cerita singkat perjuangan siswa meraih kejuaraan...'),

                        Select::make('photo_asset_id')
                            ->label('Foto Dokumentasi Prestasi (Media Asset)')
                            ->relationship('photo', 'file_name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->placeholder('Pilih foto penyerahan piala/medali dari pustaka media'),

                        Toggle::make('is_featured')
                            ->label('Tampilkan di Beranda (Prestasi Unggulan)')
                            ->helperText('Prioritas tampil di showcase beranda depan portal')
                            ->default(false),
                    ]),
            ]);
    }
}

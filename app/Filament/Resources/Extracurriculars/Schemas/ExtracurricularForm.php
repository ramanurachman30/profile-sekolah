<?php

namespace App\Filament\Resources\Extracurriculars\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ExtracurricularForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Ekstrakurikuler')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Ekstrakurikuler')
                            ->required()
                            ->maxLength(60)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, callable $set): void {
                                if ($operation === 'create' && $state) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->placeholder('Contoh: Pramuka Siaga & Penggalang'),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(80)
                            ->unique(ignoreRecord: true),

                        Select::make('category')
                            ->label('Kategori Ekskul')
                            ->options([
                                'wajib' => 'Wajib Nasional',
                                'olahraga' => 'Olahraga Prestasi',
                                'seni_budaya' => 'Seni & Budaya',
                                'bela_diri' => 'Bela Diri Tradisi',
                                'keagamaan' => 'Seni Religi / Keagamaan',
                                'kesehatan' => 'Kesehatan Siswa',
                                'keterampilan' => 'Keterampilan & Logika',
                            ])
                            ->default('olahraga')
                            ->required(),

                        TextInput::make('badge_text')
                            ->label('Label Badge')
                            ->placeholder('Contoh: Wajib Nasional / Olahraga Prestasi')
                            ->maxLength(50),

                        TextInput::make('schedule_info')
                            ->label('Jadwal Kegiatan Rutin')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: Sabtu, 08.00 - 10.00 WIB'),

                        Select::make('instructor_teacher_id')
                            ->label('Guru Pembimbing Internal')
                            ->relationship('instructorTeacher', 'full_name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih guru pembina'),

                        TextInput::make('external_coach_name')
                            ->label('Pelatih Eksternal (Opsional)')
                            ->placeholder('Nama pelatih dari luar jika ada')
                            ->maxLength(80),

                        Textarea::make('description')
                            ->label('Deskripsi Kegiatan & Manfaat')
                            ->rows(3)
                            ->columnSpanFull()
                            ->required()
                            ->placeholder('Uraian tujuan kegiatan, materi latihan, dan pembinaan karakter...'),
                    ]),

                Section::make('Foto & Visibilitas')
                    ->columns(2)
                    ->schema([
                        Select::make('cover_asset_id')
                            ->label('Foto Kegiatan (Media Asset)')
                            ->relationship('cover', 'file_name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->placeholder('Pilih foto kegiatan ekskul dari pustaka media'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Status Aktif Berjalan')
                            ->default(true),
                    ]),
            ]);
    }
}

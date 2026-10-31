<?php

namespace App\Filament\Resources\Facilities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Sarana & Prasarana')
                    ->columns(2)
                    ->schema([
                        TextInput::make('facility_code')
                            ->label('Kode Sarpras / Ruang')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: KELAS-01 / LAB-01 / PERPUS-01'),

                        Select::make('category_id')
                            ->label('Kategori Sarpras')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->label('Nama Sarana / Fasilitas')
                            ->required()
                            ->maxLength(100)
                            ->columnSpanFull()
                            ->placeholder('Contoh: Perpustakaan & Pojok Baca Lesehan'),

                        TextInput::make('capacity')
                            ->label('Kapasitas Penampungan')
                            ->numeric()
                            ->suffix(' Orang / Siswa')
                            ->default(30)
                            ->required(),

                        Select::make('condition_status')
                            ->label('Status Kondisi Fisik')
                            ->options([
                                'sangat_baik' => 'Sangat Baik (Prima)',
                                'baik' => 'Baik (Layak)',
                                'pemeliharaan' => 'Dalam Pemeliharaan / Perbaikan',
                            ])
                            ->default('sangat_baik')
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi & Kelengkapan Fasilitas')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Spesifikasi ruangan, fasilitas meja-kursi, sirkulasi udara, dll...'),
                    ]),

                Section::make('Foto & Tampilan')
                    ->columns(2)
                    ->schema([
                        Select::make('cover_asset_id')
                            ->label('Aset Foto Ruang (Media Asset)')
                            ->relationship('cover', 'file_name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih aset foto dari pustaka media'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(1)
                            ->required(),
                    ]),
            ]);
    }
}

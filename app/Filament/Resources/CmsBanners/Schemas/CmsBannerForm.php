<?php

namespace App\Filament\Resources\CmsBanners\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CmsBannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Penempatan & Konten Banner')
                    ->columns(2)
                    ->schema([
                        Select::make('placement')
                            ->label('Lokasi Penempatan')
                            ->options([
                                'home_hero' => 'Slider Utama Beranda (Home Hero)',
                                'ppdb_hero' => 'Banner Header PPDB',
                                'profile_hero' => 'Banner Header Profil Sekolah',
                                'academic_hero' => 'Banner Header Akademik',
                                'student_hero' => 'Banner Header Kesiswaan',
                                'facilities_hero' => 'Banner Header Fasilitas',
                                'contact_hero' => 'Banner Header Kontak',
                                'cta_bottom' => 'Banner Ajakan Aksi Bawah (CTA)',
                                'popup_modal' => 'Pop-up Modal Pengumuman/Promosi',
                            ])
                            ->default('home_hero')
                            ->required()
                            ->searchable(),

                        TextInput::make('badge_text')
                            ->label('Label Badge Kecil')
                            ->placeholder('Contoh: PENDAFTARAN SISWA BARU / SEKOLAH RUJUKAN'),

                        TextInput::make('title')
                            ->label('Judul Headline Banner')
                            ->required()
                            ->maxLength(160)
                            ->columnSpanFull()
                            ->placeholder('Judul banner yang memikat pembaca'),

                        Textarea::make('subtitle')
                            ->label('Subjudul / Deskripsi')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Penjelasan ringkas pesan banner'),

                        Select::make('media_asset_id')
                            ->label('Aset Gambar Latar (Media Asset)')
                            ->relationship('mediaAsset', 'file_name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->placeholder('Pilih gambar latar banner'),
                    ]),

                Section::make('Tombol Ajakan Bertindak (Call to Action)')
                    ->columns(2)
                    ->schema([
                        TextInput::make('cta_primary_text')
                            ->label('Teks Tombol Utama')
                            ->placeholder('Contoh: Daftar Sekarang')
                            ->default('Daftar Sekarang'),

                        TextInput::make('cta_primary_url')
                            ->label('Tautan Tombol Utama')
                            ->placeholder('Contoh: /ppdb')
                            ->default('/ppdb'),

                        TextInput::make('cta_secondary_text')
                            ->label('Teks Tombol Kedua (Opsional)')
                            ->placeholder('Contoh: Pelajari Selengkapnya')
                            ->default('Pelajari Selengkapnya'),

                        TextInput::make('cta_secondary_url')
                            ->label('Tautan Tombol Kedua')
                            ->placeholder('Contoh: /profil')
                            ->default('/profil'),
                    ]),

                Section::make('Jadwal & Status Penayangan')
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('start_date')
                            ->label('Mulai Ditayangkan')
                            ->helperText('Kosongkan jika ingin langsung tayang'),

                        DateTimePicker::make('end_date')
                            ->label('Selesai Ditayangkan')
                            ->helperText('Kosongkan jika tayang tanpa batas waktu'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampilan Slider')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}

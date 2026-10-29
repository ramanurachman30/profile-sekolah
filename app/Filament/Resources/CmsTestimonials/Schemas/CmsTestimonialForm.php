<?php

namespace App\Filament\Resources\CmsTestimonials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CmsTestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil Pemberi Testimoni')
                    ->columns(2)
                    ->schema([
                        TextInput::make('person_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('cth. Hj. Siti Rohmah, S.Pd.'),

                        Select::make('person_category')
                            ->label('Kategori')
                            ->options([
                                'orang_tua' => 'Orang Tua / Wali Murid',
                                'alumni' => 'Alumni Sekolah',
                                'komite' => 'Komite Sekolah',
                                'tokoh_masyarakat' => 'Tokoh Masyarakat',
                                'siswa' => 'Siswa / Murid',
                            ])
                            ->default('orang_tua')
                            ->required(),

                        TextInput::make('role_title')
                            ->label('Peran / Jabatan / Keterangan')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('cth. Orang Tua Siswa Kelas 6 / Alumni 2018'),

                        Select::make('rating')
                            ->label('Penilaian (Rating)')
                            ->options([
                                5 => '⭐⭐⭐⭐⭐ (5 Bintang - Sangat Puas)',
                                4 => '⭐⭐⭐⭐ (4 Bintang - Puas)',
                                3 => '⭐⭐⭐ (3 Bintang - Cukup)',
                                2 => '⭐⭐ (2 Bintang - Kurang)',
                                1 => '⭐ (1 Bintang - Sangat Kurang)',
                            ])
                            ->default(5)
                            ->required(),

                        Select::make('avatar_asset_id')
                            ->label('Foto Avatar / Profil (Media Asset)')
                            ->relationship('avatar', 'file_name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->placeholder('Pilih aset foto profil pengulas jika ada'),

                        Textarea::make('testimonial_text')
                            ->label('Isi Ulasan / Testimoni')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Tuliskan testimoni pengalaman positif terhadap SDN Cikereteg 01...'),
                    ]),

                Section::make('Penempatan & Visibilitas')
                    ->columns(2)
                    ->schema([
                        Select::make('placement')
                            ->label('Target Halaman Tampil')
                            ->options([
                                'all' => 'Semua Halaman Terkait',
                                'home' => 'Halaman Beranda Saja',
                                'ppdb' => 'Halaman PPDB Saja',
                                'profile' => 'Halaman Profil Sekolah Saja',
                            ])
                            ->default('all')
                            ->required(),

                        TextInput::make('sort_order')
                            ->label('Urutan Prioritas')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Toggle::make('is_featured')
                            ->label('Ulasan Unggulan (Featured)')
                            ->helperText('Tampilkan di posisi paling depan / kartu utama')
                            ->default(false),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ]),
            ]);
    }
}

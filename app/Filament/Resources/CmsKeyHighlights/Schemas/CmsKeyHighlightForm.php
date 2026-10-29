<?php

namespace App\Filament\Resources\CmsKeyHighlights\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CmsKeyHighlightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Metrik & Keunggulan')
                    ->columns(2)
                    ->schema([
                        Select::make('placement_target')
                            ->label('Target Penempatan')
                            ->options([
                                'home_pilar' => '4 Pilar Utama Beranda',
                                'profile_stats' => 'Statistik Halaman Profil',
                                'academic_metrics' => 'Metrik Capaian Akademik',
                                'ppdb_advantages' => 'Pilar Keunggulan PPDB',
                            ])
                            ->default('home_pilar')
                            ->required(),

                        TextInput::make('metric_value')
                            ->label('Angka / Nilai Metrik')
                            ->required()
                            ->maxLength(30)
                            ->placeholder('Contoh: Akreditasi A, 100%, 24+, 15 Rombel'),

                        TextInput::make('title')
                            ->label('Judul / Label Keunggulan')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: Standar Mutu BAN-S/M / Kurikulum Merdeka'),

                        TextInput::make('icon_name')
                            ->label('Ikon Simbol')
                            ->default('school')
                            ->required()
                            ->placeholder('Nama simbol Material/Heroicon (misal: verified, trophy, handshake, school)'),

                        Select::make('badge_color')
                            ->label('Warna Aksen Kartu')
                            ->options([
                                'primary' => 'Biru Utama (Primary)',
                                'emerald' => 'Hijau (Emerald)',
                                'amber' => 'Kuning Emas (Amber)',
                                'sky' => 'Biru Langit (Sky)',
                                'violet' => 'Ungu (Violet)',
                            ])
                            ->default('primary')
                            ->required(),

                        TextInput::make('link_url')
                            ->label('Tautan Klik Kartu (Opsional)')
                            ->placeholder('Contoh: /profil /akademik'),

                        Textarea::make('description')
                            ->label('Deskripsi Penjelas')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Uraian singkat manfaat atau makna metrik bagi sekolah'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampilan')
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

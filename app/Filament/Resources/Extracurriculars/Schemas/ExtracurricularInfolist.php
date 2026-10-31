<?php

namespace App\Filament\Resources\Extracurriculars\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExtracurricularInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rincian Ekstrakurikuler')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Ekskul')
                            ->weight('bold')
                            ->columnSpan(2),

                        TextEntry::make('category')
                            ->label('Kategori')
                            ->badge()
                            ->color('info')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'wajib' => 'Wajib',
                                'olahraga' => 'Olahraga',
                                'seni_budaya' => 'Seni & Budaya',
                                'bela_diri' => 'Bela Diri',
                                'keagamaan' => 'Religi',
                                'kesehatan' => 'Kesehatan',
                                'keterampilan' => 'Keterampilan',
                                default => ucfirst($state),
                            }),

                        TextEntry::make('badge_text')
                            ->label('Label')
                            ->badge()
                            ->color('primary')
                            ->placeholder('-'),

                        TextEntry::make('schedule_info')
                            ->label('Jadwal'),

                        TextEntry::make('instructorTeacher.full_name')
                            ->label('Guru Pembina')
                            ->placeholder('-'),

                        TextEntry::make('external_coach_name')
                            ->label('Pelatih Eksternal')
                            ->placeholder('-'),

                        IconEntry::make('is_active')
                            ->label('Status Aktif')
                            ->boolean(),

                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto Ekskul')
                    ->schema([
                        ImageEntry::make('cover.url')
                            ->label('Foto Kegiatan')
                            ->height(240),
                    ]),
            ]);
    }
}

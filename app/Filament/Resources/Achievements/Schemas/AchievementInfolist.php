<?php

namespace App\Filament\Resources\Achievements\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AchievementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rincian Prestasi & Kejuaraan')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('achievement_title')
                            ->label('Judul Prestasi')
                            ->weight('bold')
                            ->columnSpanFull(),

                        TextEntry::make('competition_name')
                            ->label('Ajang Kompetisi')
                            ->columnSpanFull(),

                        TextEntry::make('category.category_name')
                            ->label('Kategori')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('level')
                            ->label('Tingkat')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                        TextEntry::make('ranking_position')
                            ->label('Peringkat')
                            ->badge()
                            ->color('warning'),

                        TextEntry::make('competition_date')
                            ->label('Tanggal Lomba')
                            ->date('d F Y'),

                        TextEntry::make('recipient_summary')
                            ->label('Pemenang / Siswa')
                            ->weight('medium'),

                        TextEntry::make('mentorTeacher.full_name')
                            ->label('Guru Pembimbing')
                            ->placeholder('-'),

                        IconEntry::make('is_featured')
                            ->label('Featured Beranda')
                            ->boolean(),
                    ]),

                Section::make('Foto & Deskripsi')
                    ->schema([
                        ImageEntry::make('photo.url')
                            ->label('Foto Dokumentasi')
                            ->height(240),

                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

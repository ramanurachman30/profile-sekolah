<?php

namespace App\Filament\Resources\CharacterHabits\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CharacterHabitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rincian Pembiasaan Karakter')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('title')
                            ->label('Judul Pembiasaan')
                            ->weight('bold')
                            ->columnSpan(2),

                        TextEntry::make('badge_label')
                            ->label('Kategori')
                            ->badge()
                            ->color('success'),

                        TextEntry::make('routine_schedule')
                            ->label('Jadwal Rutin')
                            ->columnSpan(2),

                        IconEntry::make('is_active')
                            ->label('Status Aktif')
                            ->boolean(),

                        TextEntry::make('description')
                            ->label('Uraian Pembiasaan')
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto Dokumentasi')
                    ->schema([
                        ImageEntry::make('cover.url')
                            ->label('Foto Pembiasaan')
                            ->height(240),
                    ]),
            ]);
    }
}

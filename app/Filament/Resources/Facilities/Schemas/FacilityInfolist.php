<?php

namespace App\Filament\Resources\Facilities\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FacilityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Fasilitas & Sarpras')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('facility_code')
                            ->label('Kode Ruang')
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('name')
                            ->label('Nama Fasilitas')
                            ->weight('bold')
                            ->columnSpan(2),

                        TextEntry::make('category.name')
                            ->label('Kategori')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('capacity')
                            ->label('Kapasitas')
                            ->suffix(' Orang'),

                        TextEntry::make('condition_status')
                            ->label('Kondisi')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'sangat_baik' => 'success',
                                'baik' => 'info',
                                'pemeliharaan' => 'warning',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'sangat_baik' => 'Sangat Baik',
                                'baik' => 'Baik',
                                'pemeliharaan' => 'Dalam Pemeliharaan',
                                default => ucfirst($state),
                            }),

                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto Sarpras')
                    ->schema([
                        ImageEntry::make('cover.url')
                            ->label('Foto Fasilitas')
                            ->height(240),
                    ]),
            ]);
    }
}

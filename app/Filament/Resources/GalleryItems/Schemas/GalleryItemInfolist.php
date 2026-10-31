<?php

namespace App\Filament\Resources\GalleryItems\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Galeri')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('title')
                            ->label('Judul Dokumentasi')
                            ->weight('bold')
                            ->columnSpanFull(),

                        TextEntry::make('category.category_name')
                            ->label('Album / Kategori')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('media_type')
                            ->label('Tipe Media')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'video' ? 'danger' : 'success')
                            ->formatStateUsing(fn (string $state): string => $state === 'video' ? 'Video' : 'Foto'),

                        TextEntry::make('event_date')
                            ->label('Tanggal Kegiatan')
                            ->date('d F Y'),

                        TextEntry::make('tags')
                            ->label('Tags')
                            ->badge()
                            ->color('gray')
                            ->placeholder('-'),

                        IconEntry::make('is_published')
                            ->label('Status Terbit')
                            ->boolean(),

                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->placeholder('-'),
                    ]),

                Section::make('Pratinjau Media')
                    ->schema([
                        ImageEntry::make('mediaAsset.url')
                            ->label('Foto')
                            ->height(240)
                            ->visible(fn ($record) => $record?->media_type === 'photo'),

                        TextEntry::make('video_embed_url')
                            ->label('URL Video YouTube')
                            ->url(fn ($state) => $state)
                            ->visible(fn ($record) => $record?->media_type === 'video'),
                    ]),
            ]);
    }
}

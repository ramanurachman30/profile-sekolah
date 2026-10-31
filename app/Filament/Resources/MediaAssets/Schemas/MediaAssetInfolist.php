<?php

namespace App\Filament\Resources\MediaAssets\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MediaAssetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Berkas')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('file_name')
                            ->label('Nama Berkas')
                            ->weight('bold')
                            ->columnSpan(2),

                        TextEntry::make('file_type')
                            ->label('Tipe')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('mime_type')
                            ->label('MIME Type')
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('file_size_kb')
                            ->label('Ukuran')
                            ->suffix(' KB'),

                        TextEntry::make('created_at')
                            ->label('Waktu Unggah')
                            ->dateTime('d M Y H:i'),

                        TextEntry::make('alt_text')
                            ->label('Teks Alternatif')
                            ->columnSpanFull()
                            ->placeholder('-'),

                        TextEntry::make('url')
                            ->label('Tautan Akses URL')
                            ->columnSpanFull()
                            ->copyable()
                            ->url(fn ($state) => $state),
                    ]),

                Section::make('Pratinjau Gambar')
                    ->visible(fn ($record) => $record?->file_type === 'image')
                    ->schema([
                        ImageEntry::make('url')
                            ->label('')
                            ->height(300),
                    ]),
            ]);
    }
}

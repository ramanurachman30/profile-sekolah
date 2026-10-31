<?php

namespace App\Filament\Resources\GalleryItems\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Galeri & Album')
                    ->columns(2)
                    ->schema([
                        Select::make('category_id')
                            ->label('Album / Kategori Galeri')
                            ->relationship('category', 'category_name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('media_type')
                            ->label('Tipe Media')
                            ->options([
                                'photo' => '📷 Foto Kegiatan',
                                'video' => '🎬 Video YouTube Embed',
                            ])
                            ->default('photo')
                            ->required()
                            ->live(),

                        TextInput::make('title')
                            ->label('Judul Dokumentasi')
                            ->required()
                            ->maxLength(150)
                            ->columnSpanFull()
                            ->placeholder('Contoh: Peringatan Hari Kemerdekaan RI ke-81'),

                        DatePicker::make('event_date')
                            ->label('Tanggal Kegiatan')
                            ->default(now())
                            ->required(),

                        TextInput::make('tags')
                            ->label('Label Tag')
                            ->placeholder('Contoh: P5, Budaya, Literasi, Upacara')
                            ->maxLength(100),

                        Textarea::make('description')
                            ->label('Deskripsi Dokumentasi')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Keterangan singkat momen yang diabadikan...'),
                    ]),

                Section::make('Aset Media & Visibilitas')
                    ->columns(2)
                    ->schema([
                        Select::make('media_asset_id')
                            ->label('Aset Foto Dokumentasi (Media Asset)')
                            ->relationship('mediaAsset', 'file_name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->visible(fn ($get) => $get('media_type') !== 'video')
                            ->placeholder('Pilih gambar dari pustaka media'),

                        TextInput::make('video_embed_url')
                            ->label('Tautan Video YouTube Embed')
                            ->url()
                            ->columnSpanFull()
                            ->visible(fn ($get) => $get('media_type') === 'video')
                            ->placeholder('Contoh: https://www.youtube.com/embed/xxxx atau https://youtu.be/xxxx'),

                        Toggle::make('is_published')
                            ->label('Terbitkan di Galeri Publik')
                            ->default(true),
                    ]),
            ]);
    }
}

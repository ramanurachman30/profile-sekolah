<?php

namespace App\Filament\Resources\NewsArticles\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsArticleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Berita')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('title')
                            ->label('Judul Berita')
                            ->weight('bold')
                            ->columnSpanFull(),

                        TextEntry::make('category.name')
                            ->label('Kategori')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'published' => 'success',
                                'draft' => 'warning',
                                'archived' => 'gray',
                                default => 'primary',
                            }),

                        TextEntry::make('views_count')
                            ->label('Total Pembaca')
                            ->suffix(' Views'),

                        TextEntry::make('author_name')
                            ->label('Penulis')
                            ->placeholder('Humas'),

                        TextEntry::make('published_at')
                            ->label('Waktu Terbit')
                            ->dateTime('d M Y H:i'),

                        TextEntry::make('summary')
                            ->label('Ringkasan')
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto Sampul & Isi Lengkap')
                    ->schema([
                        ImageEntry::make('cover.url')
                            ->label('Cover')
                            ->height(240),

                        TextEntry::make('content')
                            ->label('Isi Artikel')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Section::make('Metadata SEO & Mesin Pencari')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('meta_title')
                            ->label('Meta Title')
                            ->placeholder('Otomatis dari Judul Berita'),

                        TextEntry::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('-'),

                        TextEntry::make('meta_description')
                            ->label('Meta Description')
                            ->placeholder('Otomatis dari Ringkasan Berita')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

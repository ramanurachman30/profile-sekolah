<?php

namespace App\Filament\Resources\NewsArticles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Berita & Kategori')
                    ->columns(2)
                    ->schema([
                        Select::make('category_id')
                            ->label('Kategori Berita')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('status')
                            ->label('Status Publikasi')
                            ->options([
                                'draft' => 'Draft / Konsep',
                                'published' => 'Terbit / Publik',
                                'archived' => 'Diarsipkan',
                            ])
                            ->default('published')
                            ->required(),

                        TextInput::make('title')
                            ->label('Judul Berita')
                            ->required()
                            ->maxLength(200)
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, callable $set): void {
                                if ($operation === 'create' && $state) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug URL (SEO Friendly)')
                            ->required()
                            ->maxLength(220)
                            ->columnSpanFull()
                            ->unique(ignoreRecord: true),

                        Textarea::make('summary')
                            ->label('Ringkasan Berita (Lead Paragraph)')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Cuplikan pengantar yang menarik pembaca...'),
                    ]),

                Section::make('Isi Lengkap & Cover Visual')
                    ->schema([
                        RichEditor::make('content')
                            ->label('Konten Berita Lengkap')
                            ->required()
                            ->columnSpanFull(),

                        Select::make('cover_asset_id')
                            ->label('Aset Foto Sampul (Media Asset)')
                            ->relationship('cover', 'file_name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih aset foto dari pustaka media'),
                    ]),

                Section::make('Atribusi Penulis & Jadwal Tayang')
                    ->columns(3)
                    ->schema([
                        Select::make('author_user_id')
                            ->label('Akun Penulis')
                            ->relationship('author', 'full_name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => Auth::id())
                            ->required(),

                        TextInput::make('author_name')
                            ->label('Nama Penulis Ditampilkan')
                            ->default(fn () => Auth::user()?->full_name ?? 'Humas SDN Cikereteg 01')
                            ->maxLength(100),

                        DateTimePicker::make('published_at')
                            ->label('Waktu Publikasi')
                            ->default(now())
                            ->required(),
                    ]),
            ]);
    }
}

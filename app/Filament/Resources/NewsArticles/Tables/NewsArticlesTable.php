<?php

namespace App\Filament\Resources\NewsArticles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NewsArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover.url')
                    ->label('Cover')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=200&auto=format&fit=crop'),

                TextColumn::make('title')
                    ->label('Judul Berita')
                    ->weight('bold')
                    ->searchable()
                    ->wrap()
                    ->limit(60),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'gray',
                        default => 'primary',
                    }),

                TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('author_name')
                    ->label('Penulis')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('published_at')
                    ->label('Waktu Terbit')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Publikasi')
                    ->options([
                        'published' => 'Terbit',
                        'draft' => 'Draft',
                        'archived' => 'Arsip',
                    ]),

                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

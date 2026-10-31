<?php

namespace App\Filament\Resources\GalleryItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GalleryItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('mediaAsset.url')
                    ->label('Thumbnail')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=200&auto=format&fit=crop'),

                TextColumn::make('title')
                    ->label('Judul Dokumentasi')
                    ->weight('bold')
                    ->searchable()
                    ->wrap()
                    ->limit(50),

                TextColumn::make('category.category_name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                TextColumn::make('media_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'video' ? 'danger' : 'success')
                    ->formatStateUsing(fn (string $state): string => $state === 'video' ? '🎬 Video' : '📷 Foto'),

                TextColumn::make('event_date')
                    ->label('Tanggal Kegiatan')
                    ->date('d M Y')
                    ->sortable(),

                IconColumn::make('is_published')
                    ->label('Terbit')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->defaultSort('event_date', 'desc')
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'category_name'),

                SelectFilter::make('media_type')
                    ->label('Tipe Media')
                    ->options([
                        'photo' => 'Foto Kegiatan',
                        'video' => 'Video YouTube',
                    ]),

                SelectFilter::make('is_published')
                    ->label('Status Terbit')
                    ->options([
                        1 => 'Diterbitkan',
                        0 => 'Draft',
                    ]),
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

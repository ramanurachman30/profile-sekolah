<?php

namespace App\Filament\Resources\Achievements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AchievementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo.url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=200&auto=format&fit=crop'),

                TextColumn::make('achievement_title')
                    ->label('Judul Prestasi')
                    ->weight('bold')
                    ->searchable()
                    ->wrap()
                    ->limit(50),

                TextColumn::make('ranking_position')
                    ->label('Juara / Medali')
                    ->badge()
                    ->color('warning')
                    ->searchable(),

                TextColumn::make('category.category_name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                TextColumn::make('level')
                    ->label('Tingkat')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('recipient_summary')
                    ->label('Peraih')
                    ->limit(30)
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('competition_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('competition_date', 'desc')
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'category_name'),

                SelectFilter::make('level')
                    ->label('Tingkat Kompetisi')
                    ->options([
                        'kecamatan' => 'Kecamatan',
                        'kabupaten' => 'Kabupaten / Kota',
                        'provinsi' => 'Provinsi',
                        'nasional' => 'Nasional',
                    ]),

                SelectFilter::make('is_featured')
                    ->label('Status Featured')
                    ->options([
                        1 => 'Featured di Beranda',
                        0 => 'Biasa',
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

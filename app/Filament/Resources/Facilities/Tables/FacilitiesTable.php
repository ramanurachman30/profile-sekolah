<?php

namespace App\Filament\Resources\Facilities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FacilitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover.url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=200&auto=format&fit=crop'),

                TextColumn::make('facility_code')
                    ->label('Kode')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama Fasilitas')
                    ->weight('bold')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                TextColumn::make('capacity')
                    ->label('Kapasitas')
                    ->suffix(' Org')
                    ->alignCenter(),

                TextColumn::make('condition_status')
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
                        'pemeliharaan' => 'Pemeliharaan',
                        default => ucfirst($state),
                    }),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),

                SelectFilter::make('condition_status')
                    ->label('Kondisi Fisik')
                    ->options([
                        'sangat_baik' => 'Sangat Baik',
                        'baik' => 'Baik',
                        'pemeliharaan' => 'Pemeliharaan',
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

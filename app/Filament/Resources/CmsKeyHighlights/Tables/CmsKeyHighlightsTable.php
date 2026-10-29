<?php

namespace App\Filament\Resources\CmsKeyHighlights\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CmsKeyHighlightsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('metric_value')
                    ->label('Nilai Metrik')
                    ->badge()
                    ->color('success')
                    ->searchable(),

                TextColumn::make('title')
                    ->label('Judul Keunggulan')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('icon_name')
                    ->label('Ikon')
                    ->fontFamily('mono'),

                TextColumn::make('placement_target')
                    ->label('Penempatan')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                TextColumn::make('badge_color')
                    ->label('Warna')
                    ->badge(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('placement_target')
                    ->label('Target Penempatan')
                    ->options([
                        'home_pilar' => '4 Pilar Utama Beranda',
                        'profile_stats' => 'Statistik Profil',
                        'academic_metrics' => 'Metrik Akademik',
                        'ppdb_advantages' => 'Keunggulan PPDB',
                    ]),

                SelectFilter::make('is_active')
                    ->label('Status Aktif')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Non-Aktif',
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

<?php

namespace App\Filament\Resources\CmsAnnouncements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CmsAnnouncementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Pengumuman')
                    ->weight('bold')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('announcement_type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'info' => 'Info',
                        'warning' => 'Peringatan',
                        'success' => 'Kabar Baik',
                        'urgent' => 'Mendesak',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'info' => 'info',
                        'warning' => 'warning',
                        'success' => 'success',
                        'urgent' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('placement_target')
                    ->label('Penempatan')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'global_topbar' => 'Top Bar Global',
                        'home_banner' => 'Banner Beranda',
                        'ppdb_banner' => 'Banner PPDB',
                        default => $state,
                    })
                    ->color('secondary'),

                TextColumn::make('cta_text')
                    ->label('Tautan Aksi')
                    ->placeholder('-'),

                TextColumn::make('start_date')
                    ->label('Mulai Ditayangkan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Batas Berakhir')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('announcement_type')
                    ->label('Tipe Pengumuman')
                    ->options([
                        'info' => 'Info',
                        'warning' => 'Peringatan',
                        'success' => 'Kabar Baik',
                        'urgent' => 'Mendesak',
                    ]),

                SelectFilter::make('placement_target')
                    ->label('Lokasi Penempatan')
                    ->options([
                        'global_topbar' => 'Top Bar Global',
                        'home_banner' => 'Banner Beranda',
                        'ppdb_banner' => 'Banner PPDB',
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

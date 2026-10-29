<?php

namespace App\Filament\Resources\CmsBanners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CmsBannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('mediaAsset.url')
                    ->label('Cover')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=200&auto=format&fit=crop'),

                TextColumn::make('title')
                    ->label('Judul Banner')
                    ->weight('bold')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('placement')
                    ->label('Penempatan')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                TextColumn::make('cta_primary_text')
                    ->label('Tombol Aksi')
                    ->placeholder('-'),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('start_date')
                    ->label('Mulai Tayang')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('end_date')
                    ->label('Selesai Tayang')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('placement')
                    ->label('Lokasi Penempatan')
                    ->options([
                        'home_hero' => 'Slider Utama Beranda',
                        'ppdb_hero' => 'Banner Header PPDB',
                        'profile_hero' => 'Banner Header Profil',
                        'academic_hero' => 'Banner Header Akademik',
                        'student_hero' => 'Banner Header Kesiswaan',
                        'facilities_hero' => 'Banner Header Fasilitas',
                        'contact_hero' => 'Banner Header Kontak',
                        'cta_bottom' => 'Banner Ajakan Aksi Bawah',
                        'popup_modal' => 'Pop-up Modal Promosi',
                    ]),

                SelectFilter::make('is_active')
                    ->label('Status Aktif')
                    ->options([
                        1 => 'Aktif Tayang',
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

<?php

namespace App\Filament\Resources\CmsTestimonials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CmsTestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar.url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://ui-avatars.com/api/?name=Testimonial&background=0D8ABC&color=fff'),

                TextColumn::make('person_name')
                    ->label('Nama Pengulas')
                    ->weight('bold')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('person_category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'orang_tua' => 'Orang Tua',
                        'alumni' => 'Alumni',
                        'komite' => 'Komite',
                        'tokoh_masyarakat' => 'Tokoh Masyarakat',
                        'siswa' => 'Siswa',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'orang_tua' => 'info',
                        'alumni' => 'warning',
                        'komite' => 'success',
                        'tokoh_masyarakat' => 'primary',
                        default => 'gray',
                    }),

                TextColumn::make('role_title')
                    ->label('Peran / Jabatan')
                    ->searchable()
                    ->limit(35),

                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state): string => str_repeat('⭐', (int) $state))
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('placement')
                    ->label('Halaman')
                    ->badge()
                    ->color('secondary'),

                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('person_category')
                    ->label('Kategori Pengulas')
                    ->options([
                        'orang_tua' => 'Orang Tua',
                        'alumni' => 'Alumni',
                        'komite' => 'Komite',
                        'tokoh_masyarakat' => 'Tokoh Masyarakat',
                        'siswa' => 'Siswa',
                    ]),

                SelectFilter::make('placement')
                    ->label('Target Halaman')
                    ->options([
                        'all' => 'Semua Halaman',
                        'home' => 'Beranda',
                        'ppdb' => 'PPDB',
                        'profile' => 'Profil',
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

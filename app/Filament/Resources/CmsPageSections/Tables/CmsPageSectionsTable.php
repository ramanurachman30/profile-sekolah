<?php

namespace App\Filament\Resources\CmsPageSections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CmsPageSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page_code')
                    ->label('Halaman')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                TextColumn::make('section_key')
                    ->label('Identifier')
                    ->copyable()
                    ->fontFamily('mono')
                    ->searchable(),

                TextColumn::make('badge_title')
                    ->label('Badge')
                    ->placeholder('-'),

                TextColumn::make('title')
                    ->label('Judul Section')
                    ->weight('bold')
                    ->searchable(),

                IconColumn::make('is_visible')
                    ->label('Tampil')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('page_code')
                    ->label('Halaman Target')
                    ->options([
                        'home' => 'Beranda Utama',
                        'profile' => 'Profil Sekolah',
                        'academic' => 'Akademik',
                        'student_affairs' => 'Kesiswaan',
                        'facilities' => 'Fasilitas',
                        'achievements' => 'Prestasi',
                        'ppdb' => 'PPDB Online',
                        'contact' => 'Kontak',
                    ]),

                SelectFilter::make('is_visible')
                    ->label('Status Tampil')
                    ->options([
                        1 => 'Tampil di Publik',
                        0 => 'Disembunyikan',
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

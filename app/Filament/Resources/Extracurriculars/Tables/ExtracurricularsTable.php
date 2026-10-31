<?php

namespace App\Filament\Resources\Extracurriculars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExtracurricularsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover.url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=200&auto=format&fit=crop'),

                TextColumn::make('name')
                    ->label('Nama Ekskul')
                    ->weight('bold')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'wajib' => 'Wajib',
                        'olahraga' => 'Olahraga',
                        'seni_budaya' => 'Seni Budaya',
                        'bela_diri' => 'Bela Diri',
                        'keagamaan' => 'Religi',
                        'kesehatan' => 'Kesehatan',
                        'keterampilan' => 'Keterampilan',
                        default => ucfirst($state),
                    }),

                TextColumn::make('schedule_info')
                    ->label('Jadwal Rutin')
                    ->wrap(),

                TextColumn::make('instructorTeacher.full_name')
                    ->label('Guru Pembina')
                    ->placeholder('-')
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'wajib' => 'Wajib Nasional',
                        'olahraga' => 'Olahraga Prestasi',
                        'seni_budaya' => 'Seni & Budaya',
                        'bela_diri' => 'Bela Diri Tradisi',
                        'keagamaan' => 'Seni Religi / Keagamaan',
                        'kesehatan' => 'Kesehatan Siswa',
                        'keterampilan' => 'Keterampilan & Logika',
                    ]),

                SelectFilter::make('is_active')
                    ->label('Status')
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

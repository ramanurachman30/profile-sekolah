<?php

namespace App\Filament\Resources\PpdbPeriods\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PpdbPeriodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('wave_name')
                    ->label('Nama Gelombang')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('academicYear.year_code')
                    ->label('Tahun Ajaran'),

                TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('target_quota')
                    ->label('Target Kuota')
                    ->numeric()
                    ->sortable()
                    ->badge(),

                TextColumn::make('accepted_count')
                    ->label('Diterima')
                    ->badge()
                    ->color('success'),

                TextColumn::make('remaining_quota')
                    ->label('Sisa Kuota')
                    ->badge()
                    ->color('warning'),

                IconColumn::make('is_open')
                    ->label('Aktif / Buka')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

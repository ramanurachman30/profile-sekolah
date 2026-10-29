<?php

namespace App\Filament\Resources\SchoolProfiles\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchoolProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('school_name')
                    ->label('Nama Sekolah')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable(),
                TextColumn::make('accreditation')
                    ->label('Akreditasi')
                    ->badge()
                    ->color('success'),
                TextColumn::make('headmaster_name')
                    ->label('Kepala Sekolah')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telepon'),
                TextColumn::make('whatsapp')
                    ->label('WhatsApp'),
                TextColumn::make('operating_hours')
                    ->label('Jam Pelayanan'),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}

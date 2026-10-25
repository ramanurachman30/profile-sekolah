<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo.url')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=300&auto=format&fit=crop'),

                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('nip')
                    ->label('NIP / NUPTK')
                    ->searchable()
                    ->copyable()
                    ->placeholder('-'),

                TextColumn::make('role_title')
                    ->label('Jabatan')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                TextColumn::make('education')
                    ->label('Pendidikan')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('phone')
                    ->label('WhatsApp')
                    ->searchable()
                    ->placeholder('-'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),

                SelectFilter::make('is_active')
                    ->label('Status Aktif')
                    ->options([
                        1 => 'Aktif Mengajar',
                        0 => 'Non-Aktif',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()?->role === 'superadmin'),
                ]),
            ]);
    }
}

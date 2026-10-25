<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->copyable()
                    ->weight('medium')
                    ->placeholder('-'),

                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('gender')
                    ->label('L/P')
                    ->badge()
                    ->alignCenter(),

                TextColumn::make('currentClass.class_name')
                    ->label('Kelas')
                    ->badge()
                    ->color('primary')
                    ->placeholder('Belum Masuk Kelas')
                    ->sortable(),

                TextColumn::make('parent_guardian_name')
                    ->label('Nama Orang Tua')
                    ->searchable(),

                TextColumn::make('parent_phone')
                    ->label('WhatsApp Ortu')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'lulus' => 'info',
                        'mutasi' => 'warning',
                        'keluar' => 'danger',
                        default => 'gray',
                    })
                    ->alignCenter(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('current_class_id')
                    ->label('Rombel Kelas')
                    ->relationship('currentClass', 'class_name'),

                SelectFilter::make('status')
                    ->label('Status Siswa')
                    ->options([
                        'aktif' => 'Siswa Aktif',
                        'lulus' => 'Lulus',
                        'mutasi' => 'Pindah / Mutasi',
                        'keluar' => 'Keluar',
                    ]),

                SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),

                // Chat WhatsApp Orang Tua
                Action::make('whatsapp')
                    ->label('WA Ortu')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('success')
                    ->url(function ($record) {
                        $phone = preg_replace('/[^0-9]/', '', $record->parent_phone);
                        if (str_starts_with($phone, '0')) {
                            $phone = '62' . substr($phone, 1);
                        }
                        $text = urlencode("Halo Bpk/Ibu wali dari ananda {$record->full_name}, kami dari pihak sekolah SDN Cikereteg 01: ");
                        return "https://wa.me/{$phone}?text={$text}";
                    }, shouldOpenInNewTab: true),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()?->role === 'superadmin'),
                ]),
            ]);
    }
}

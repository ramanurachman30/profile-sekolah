<?php

namespace App\Filament\Resources\CharacterHabits\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CharacterHabitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Pembiasaan Karakter')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Pembiasaan Karakter')
                            ->required()
                            ->maxLength(100)
                            ->columnSpanFull()
                            ->placeholder('Contoh: Senyum, Salam, Sapa, Sopan, Santun (5S) / Sholat Dhuha Berjamaah'),

                        TextInput::make('badge_label')
                            ->label('Label Tag / Nilai Utama')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('Contoh: Budi Pekerti Luhur / Karakter Religius'),

                        TextInput::make('routine_schedule')
                            ->label('Waktu & Jadwal Pelaksanaan Rutin')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: Setiap Pagi Pukul 06.45 - 07.00 WIB di Gerbang Sekolah'),

                        Textarea::make('description')
                            ->label('Deskripsi Tata Cara & Manfaat Pembiasaan')
                            ->rows(3)
                            ->columnSpanFull()
                            ->required()
                            ->placeholder('Penjelasan langkah pembiasaan, peran guru menyambut siswa, dan nilai budi pekerti...'),
                    ]),

                Section::make('Foto & Tampilan')
                    ->columns(2)
                    ->schema([
                        Select::make('cover_asset_id')
                            ->label('Foto Dokumentasi (Media Asset)')
                            ->relationship('cover', 'file_name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->placeholder('Pilih aset foto dari pustaka media'),

                        TextInput::make('sort_order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ]),
            ]);
    }
}

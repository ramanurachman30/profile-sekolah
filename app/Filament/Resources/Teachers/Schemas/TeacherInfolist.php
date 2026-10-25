<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeacherInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil Guru & Tenaga Kependidikan')
                    ->columns(4)
                    ->schema([
                        ImageEntry::make('photo.url')
                            ->label('Foto Guru')
                            ->circular()
                            ->defaultImageUrl('https://images.unsplash.com/photo-1544717302-de2939b7ef71?q=80&w=300&auto=format&fit=crop'),
                        TextEntry::make('full_name')
                            ->label('Nama Lengkap')
                            ->weight('bold'),
                        TextEntry::make('nip')
                            ->label('NIP / NUPTK')
                            ->placeholder('-')
                            ->copyable(),
                        TextEntry::make('gender')
                            ->label('Jenis Kelamin')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                        TextEntry::make('role_title')
                            ->label('Jabatan')
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('education')
                            ->label('Pendidikan')
                            ->placeholder('-'),
                        TextEntry::make('phone')
                            ->label('No. WhatsApp')
                            ->placeholder('-')
                            ->copyable(),
                        IconEntry::make('is_active')
                            ->label('Status Aktif')
                            ->boolean(),
                    ]),

                Section::make('Motto & Jam Konsultasi')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('consultation_hours')
                            ->label('Jadwal Konsultasi Orang Tua')
                            ->placeholder('Sesuai perjanjian'),
                        TextEntry::make('motto')
                            ->label('Motto Pendidikan')
                            ->placeholder('-'),
                    ]),

                Section::make('Rombel yang Diampu (Wali Kelas)')
                    ->schema([
                        RepeatableEntry::make('homeroomClasses')
                            ->label('')
                            ->schema([
                                TextEntry::make('class_name')->label('Nama Kelas')->weight('bold'),
                                TextEntry::make('room_name')->label('Ruang')->placeholder('-'),
                                TextEntry::make('capacity')->label('Kapasitas')->suffix(' Siswa'),
                            ])
                            ->columns(3),
                    ]),
            ]);
    }
}

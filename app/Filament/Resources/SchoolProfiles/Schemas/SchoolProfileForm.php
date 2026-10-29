<?php

namespace App\Filament\Resources\SchoolProfiles\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SchoolProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('ProfilSekolahTabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Identitas Sekolah')
                            ->icon('heroicon-o-academic-cap')
                            ->columns(2)
                            ->schema([
                                TextInput::make('school_name')
                                    ->label('Nama Resmi Sekolah')
                                    ->required()
                                    ->maxLength(80),
                                TextInput::make('npsn')
                                    ->label('NPSN')
                                    ->required()
                                    ->maxLength(8),
                                TextInput::make('school_level')
                                    ->label('Jenjang Sekolah')
                                    ->required()
                                    ->maxLength(25),
                                TextInput::make('accreditation')
                                    ->label('Status Akreditasi (BAN-S/M)')
                                    ->required()
                                    ->maxLength(1),
                            ]),

                        Tab::make('Sambutan Kepala Sekolah')
                            ->icon('heroicon-o-user-circle')
                            ->columns(2)
                            ->schema([
                                TextInput::make('headmaster_name')
                                    ->label('Nama Kepala Sekolah & Gelar')
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('headmaster_nip')
                                    ->label('NIP Kepala Sekolah')
                                    ->maxLength(18)
                                    ->placeholder('19xxxxxxxxxxxxxx (Opsional)'),
                                TextInput::make('headmaster_welcome_quote')
                                    ->label('Kutipan Inspiratif (Cuplikan Beranda)')
                                    ->maxLength(255)
                                    ->columnSpanFull()
                                    ->placeholder('Kutipan singkat yang tampil di kartu sambutan beranda'),
                                Textarea::make('headmaster_welcome_text')
                                    ->label('Naskah Lengkap Sambutan Kepala Sekolah')
                                    ->rows(8)
                                    ->columnSpanFull()
                                    ->placeholder('Naskah sambutan lengkap untuk halaman profil sekolah'),
                            ]),

                        Tab::make('Visi, Misi & Sejarah')
                            ->icon('heroicon-o-document-text')
                            ->columns(1)
                            ->schema([
                                Textarea::make('vision')
                                    ->label('Visi Sekolah')
                                    ->required()
                                    ->rows(3),
                                Textarea::make('mission')
                                    ->label('Misi Sekolah')
                                    ->required()
                                    ->rows(5),
                                Textarea::make('history_summary')
                                    ->label('Ringkasan Sejarah Sekolah')
                                    ->required()
                                    ->rows(4),
                            ]),

                        Tab::make('Kontak & Lokasi')
                            ->icon('heroicon-o-map-pin')
                            ->columns(2)
                            ->schema([
                                TextInput::make('address')
                                    ->label('Alamat Fisik Sekolah')
                                    ->required()
                                    ->maxLength(200)
                                    ->columnSpanFull(),
                                TextInput::make('sub_district')
                                    ->label('Kecamatan')
                                    ->required(),
                                TextInput::make('district')
                                    ->label('Kabupaten / Kota')
                                    ->required(),
                                TextInput::make('postal_code')
                                    ->label('Kode Pos')
                                    ->required()
                                    ->maxLength(5),
                                TextInput::make('phone')
                                    ->label('Nomor Telepon Sekolah')
                                    ->tel()
                                    ->required(),
                                TextInput::make('whatsapp')
                                    ->label('WhatsApp Resmi Sekolah')
                                    ->tel()
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email Dinas Sekolah')
                                    ->email()
                                    ->required(),
                                Textarea::make('maps_embed_url')
                                    ->label('Tautan Google Maps Embed (iframe URL)')
                                    ->rows(2)
                                    ->columnSpanFull()
                                    ->placeholder('https://www.google.com/maps/embed?...'),
                            ]),

                        Tab::make('Media Sosial & Operasional')
                            ->icon('heroicon-o-globe-alt')
                            ->columns(2)
                            ->schema([
                                TextInput::make('social_facebook')
                                    ->label('URL Facebook Sekolah')
                                    ->url()
                                    ->placeholder('https://facebook.com/...'),
                                TextInput::make('social_instagram')
                                    ->label('URL Instagram Sekolah')
                                    ->url()
                                    ->placeholder('https://instagram.com/...'),
                                TextInput::make('social_youtube')
                                    ->label('URL Kanal YouTube Sekolah')
                                    ->url()
                                    ->placeholder('https://youtube.com/...'),
                                TextInput::make('operating_hours')
                                    ->label('Jam Operasional Pelayanan')
                                    ->required()
                                    ->placeholder('Contoh: Senin - Jumat: 07.00 - 14.30 WIB'),
                            ]),
                    ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PpdbRegistrationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pendaftaran')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('registration_number')
                            ->label('Nomor Registrasi')
                            ->weight('bold')
                            ->copyable(),
                        TextEntry::make('period.wave_name')
                            ->label('Gelombang PPDB'),
                        TextEntry::make('track')
                            ->label('Jalur Masuk')
                            ->badge()
                            ->formatStateUsing(fn ($record) => $record->track_label)
                            ->color(fn (string $state): string => match ($state) {
                                'zonasi' => 'primary',
                                'afirmasi' => 'warning',
                                
                                'perpindahan_ortu' => 'info',
                                default => 'gray',
                            }),
                        TextEntry::make('verification_status')
                            ->label('Status Verifikasi')
                            ->badge()
                            ->formatStateUsing(fn ($record) => $record->verification_status_label)
                            ->color(fn (string $state): string => match ($state) {
                                'menunggu' => 'warning',
                                'diverifikasi' => 'info',
                                'diterima' => 'success',
                                'ditolak' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('verified_at')
                            ->label('Waktu Verifikasi')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('Belum diverifikasi'),
                        TextEntry::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Data Calon Siswa')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('child_full_name')
                            ->label('Nama Lengkap Anak')
                            ->weight('bold'),
                        TextEntry::make('child_nik')
                            ->label('NIK Anak')
                            ->copyable(),
                        TextEntry::make('child_gender')
                            ->label('Jenis Kelamin')
                            ->formatStateUsing(fn ($state) => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                        TextEntry::make('child_birth_place')
                            ->label('Tempat Lahir'),
                        TextEntry::make('child_birth_date')
                            ->label('Tanggal Lahir')
                            ->date('d F Y'),
                        TextEntry::make('child_age_years')
                            ->label('Usia Per 1 Juli')
                            ->formatStateUsing(fn ($record) => "{$record->child_age_years} tahun {$record->child_age_months} bulan"),
                    ]),

                Section::make('Data Orang Tua / Wali')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('parent_name')
                            ->label('Nama Orang Tua / Wali')
                            ->weight('bold'),
                        TextEntry::make('parent_phone')
                            ->label('Nomor WhatsApp')
                            ->copyable(),
                        TextEntry::make('parent_nik')
                            ->label('NIK Orang Tua')
                            ->placeholder('-'),
                        TextEntry::make('parent_occupation')
                            ->label('Pekerjaan Orang Tua')
                            ->placeholder('-'),
                        TextEntry::make('distance_meters')
                            ->label('Jarak ke Sekolah')
                            ->formatStateUsing(fn ($state) => $state ? "{$state} meter" : '-'),
                        TextEntry::make('home_address')
                            ->label('Alamat Rumah')
                            ->columnSpanFull(),
                    ]),

                Section::make('Dokumen & Berkas Persyaratan')
                    ->columns(3)
                    ->schema([
                        ImageEntry::make('documentKk.url')
                            ->label('Kartu Keluarga (KK)')
                            ->defaultImageUrl(asset('frontend/images/doc-placeholder.png'))
                            ->placeholder('Berkas KK belum diunggah'),

                        ImageEntry::make('documentAkta.url')
                            ->label('Akta Kelahiran')
                            ->defaultImageUrl(asset('frontend/images/doc-placeholder.png'))
                            ->placeholder('Berkas Akta belum diunggah'),

                        ImageEntry::make('documentKia.url')
                            ->label('KIA / Dokumen Afirmasi')
                            ->defaultImageUrl(asset('frontend/images/doc-placeholder.png'))
                            ->placeholder('Berkas KIA belum diunggah'),
                    ]),
            ]);
    }
}

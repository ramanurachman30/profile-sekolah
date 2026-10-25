<?php

namespace App\Filament\Resources\PpdbRegistrations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PpdbRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('period_id')
                    ->label('Gelombang PPDB')
                    ->relationship('period', 'wave_name')
                    ->required(),
                TextInput::make('registration_number')
                    ->label('Nomor Registrasi')
                    ->required()
                    ->readOnly(),
                Select::make('track')
                    ->label('Jalur Masuk')
                    ->options([
                        'zonasi' => 'Zonasi',
                        'afirmasi' => 'Afirmasi',
                        'perpindahan_ortu' => 'Perpindahan Tugas Ortu',
                        'reguler' => 'Reguler',
                    ])
                    ->required(),
                TextInput::make('child_full_name')
                    ->label('Nama Lengkap Calon Siswa')
                    ->required(),
                TextInput::make('child_nik')
                    ->label('NIK Anak (16 Digit)')
                    ->required()
                    ->maxLength(16),
                Select::make('child_gender')
                    ->label('Jenis Kelamin')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                    ->required(),
                TextInput::make('child_birth_place')
                    ->label('Tempat Lahir')
                    ->required(),
                DatePicker::make('child_birth_date')
                    ->label('Tanggal Lahir')
                    ->required(),
                TextInput::make('child_age_years')
                    ->label('Usia (Tahun)')
                    ->numeric()
                    ->required(),
                TextInput::make('child_age_months')
                    ->label('Usia (Bulan)')
                    ->numeric()
                    ->required(),
                TextInput::make('parent_name')
                    ->label('Nama Orang Tua / Wali')
                    ->required(),
                TextInput::make('parent_nik')
                    ->label('NIK Orang Tua / Wali')
                    ->maxLength(16),
                TextInput::make('parent_phone')
                    ->label('WhatsApp Wali')
                    ->tel()
                    ->required(),
                TextInput::make('parent_email')
                    ->label('Email Wali')
                    ->email(),
                TextInput::make('parent_occupation')
                    ->label('Pekerjaan Wali'),
                Textarea::make('home_address')
                    ->label('Alamat Domisili')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('distance_meters')
                    ->label('Jarak ke Sekolah (Meter)')
                    ->numeric(),
                Select::make('verification_status')
                    ->label('Status Verifikasi')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'diverifikasi' => 'Diverifikasi',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('menunggu')
                    ->required(),
                Textarea::make('rejection_reason')
                    ->label('Alasan Penolakan')
                    ->columnSpanFull(),
                Select::make('enrolled_student_id')
                    ->label('Data Siswa Terdaftar')
                    ->relationship('enrolledStudent', 'full_name')
                    ->searchable()
                    ->placeholder('Belum ter-enroll'),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Guru & GTK')
                    ->columns(3)
                    ->schema([
                        TextInput::make('full_name')
                            ->label('Nama Lengkap & Gelar')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: Bpk. Hendra Gunawan, S.Pd.'),
                        TextInput::make('nip')
                            ->label('NIP / NUPTK')
                            ->maxLength(30)
                            ->placeholder('19xxxxxxxxxxxxxx (Opsional)'),
                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),
                    ]),

                Section::make('Jabatan & Penugasan Sekolah')
                    ->columns(3)
                    ->schema([
                        TextInput::make('role_title')
                            ->label('Jabatan / Tugas Mengajar')
                            ->required()
                            ->maxLength(80)
                            ->placeholder('Contoh: Guru Kelas 1-A / Guru PJOK / Kepala Sekolah'),
                        TextInput::make('education')
                            ->label('Pendidikan Terakhir')
                            ->maxLength(80)
                            ->placeholder('Contoh: S1 PGSD Universitas Pakuan'),
                        TextInput::make('sort_order')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0),
                    ]),

                Section::make('Kontak & Komunikasi')
                    ->columns(3)
                    ->schema([
                        TextInput::make('phone')
                            ->label('No. WhatsApp / HP')
                            ->tel()
                            ->maxLength(25),
                        TextInput::make('email')
                            ->label('Email Dinas / Pribadi')
                            ->email()
                            ->maxLength(100),
                        TextInput::make('consultation_hours')
                            ->label('Jam Konsultasi Orang Tua')
                            ->placeholder('Contoh: Senin & Kamis 12.30 - 14.00 WIB'),
                    ]),

                Section::make('Motto & Status Keaktifan')
                    ->columns(2)
                    ->schema([
                        Textarea::make('motto')
                            ->label('Motto / Pesan Guru')
                            ->rows(2)
                            ->placeholder('Contoh: Mendidik dengan hati, membentuk generasi berbudi pekerti.'),
                        Toggle::make('is_active')
                            ->label('Status Aktif Mengajar')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}

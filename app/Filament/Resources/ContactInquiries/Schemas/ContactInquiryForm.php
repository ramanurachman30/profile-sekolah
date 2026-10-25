<?php

namespace App\Filament\Resources\ContactInquiries\Schemas;

use App\Models\Teacher;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactInquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tiket Aduan')
                    ->columns(3)
                    ->schema([
                        TextInput::make('ticket_number')
                            ->label('Nomor Tiket')
                            ->disabled()
                            ->dehydrated(),
                        Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'ppdb' => 'Informasi PPDB',
                                'administrasi' => 'Administrasi & Surat',
                                'mutasi' => 'Mutasi Siswa',
                                'konsultasi' => 'Konsultasi Belajar',
                                'lainnya' => 'Saran / Lainnya',
                            ])
                            ->required(),
                        Select::make('ticket_status')
                            ->label('Status Tiket')
                            ->options([
                                'baru' => 'Tiket Baru',
                                'diproses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                                'arsip' => 'Diarsipkan',
                            ])
                            ->required(),
                    ]),

                Section::make('Identitas Pengirim & Kontak')
                    ->columns(3)
                    ->schema([
                        TextInput::make('sender_name')
                            ->label('Nama Pengirim')
                            ->required(),
                        TextInput::make('sender_phone')
                            ->label('No. WhatsApp / HP')
                            ->tel()
                            ->required(),
                        TextInput::make('sender_email')
                            ->label('Email')
                            ->email(),
                        Select::make('preferred_channel')
                            ->label('Saluran Pilihan')
                            ->options([
                                'whatsapp' => 'WhatsApp',
                                'email' => 'Email',
                                'telepon' => 'Telepon Langsung',
                            ])
                            ->default('whatsapp'),
                    ]),

                Section::make('Uraian Pesan')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Subjek / Topik')
                            ->required(),
                        Textarea::make('message')
                            ->label('Isi Pesan')
                            ->rows(4)
                            ->required(),
                    ]),

                Section::make('Disposisi & Respon Staf TU')
                    ->columns(2)
                    ->schema([
                        Select::make('assigned_to_teacher_id')
                            ->label('Disposisi ke Dewan Guru (Opsional)')
                            ->options(Teacher::pluck('full_name', 'id'))
                            ->searchable()
                            ->placeholder('Pilih guru bersangkutan jika perlu disposisi'),
                        DateTimePicker::make('responded_at')
                            ->label('Waktu Respon Terakhir'),
                        Textarea::make('response_notes')
                            ->label('Catatan Tindak Lanjut / Jawaban Resmi Sekolah')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Tuliskan respon atau hasil koordinasi dengan orang tua...'),
                    ]),
            ]);
    }
}

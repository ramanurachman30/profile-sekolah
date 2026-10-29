<?php

namespace App\Filament\Resources\CmsPageSections\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CmsPageSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identifikasi Section Halaman')
                    ->columns(2)
                    ->schema([
                        Select::make('page_code')
                            ->label('Halaman Target')
                            ->options([
                                'home' => 'Beranda Utama (/)',
                                'profile' => 'Profil Sekolah (/profil)',
                                'academic' => 'Akademik (/akademik)',
                                'student_affairs' => 'Kesiswaan & Ekskul (/kesiswaan)',
                                'facilities' => 'Fasilitas (/fasilitas)',
                                'achievements' => 'Prestasi (/prestasi)',
                                'ppdb' => 'PPDB Online (/ppdb)',
                                'contact' => 'Kontak (/kontak)',
                            ])
                            ->required()
                            ->searchable(),

                        TextInput::make('section_key')
                            ->label('Kunci Identifier Section')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('Contoh: hero_slider, headmaster_welcome, testimonials'),
                    ]),

                Section::make('Teks & Konten Presentasi Section')
                    ->columns(2)
                    ->schema([
                        TextInput::make('badge_title')
                            ->label('Label Badge Kecil')
                            ->maxLength(60)
                            ->placeholder('Contoh: SAMBUTAN PIMPINAN / KABAR TERKINI'),

                        TextInput::make('title')
                            ->label('Judul Utama Section')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Judul yang ditampilkan di halaman publik'),

                        Textarea::make('subtitle')
                            ->label('Subjudul / Deskripsi Pendukung')
                            ->maxLength(255)
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Keterangan singkat pengantar isi section'),
                    ]),

                Section::make('Visibilitas & Urutan Tampilan')
                    ->columns(2)
                    ->schema([
                        TextInput::make('sort_order')
                            ->label('Urutan Vertikal Section')
                            ->numeric()
                            ->default(1)
                            ->required(),

                        Toggle::make('is_visible')
                            ->label('Tampilkan Section di Halaman Publik')
                            ->default(true)
                            ->inline(false),

                        KeyValue::make('metadata_json')
                            ->label('Konfigurasi Tambahan (Opsional)')
                            ->keyLabel('Kunci Parameter')
                            ->valueLabel('Nilai Parameter')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

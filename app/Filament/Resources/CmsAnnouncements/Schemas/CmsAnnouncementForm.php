<?php

namespace App\Filament\Resources\CmsAnnouncements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CmsAnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten & Tipe Pengumuman')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Pengumuman / Ticker')
                            ->required()
                            ->maxLength(200)
                            ->columnSpanFull()
                            ->placeholder('cth. Pendaftaran Siswa Baru (PPDB) Tahun Ajaran Baru Telah Dibuka!'),

                        Select::make('announcement_type')
                            ->label('Tipe / Warna Alert')
                            ->options([
                                'info' => 'Informasi Penting (Biru)',
                                'warning' => 'Peringatan / Hati-hati (Oranye)',
                                'success' => 'Kabar Gembira / Prestasi (Hijau)',
                                'urgent' => 'Mendesak / Darurat (Merah)',
                            ])
                            ->default('info')
                            ->required(),

                        Select::make('placement_target')
                            ->label('Target Penempatan')
                            ->options([
                                'global_topbar' => 'Top Bar Global (Semua Halaman Website)',
                                'home_banner' => 'Banner Notifikasi Halaman Beranda',
                                'ppdb_banner' => 'Banner Notifikasi Khusus PPDB',
                            ])
                            ->default('global_topbar')
                            ->required(),

                        Textarea::make('content')
                            ->label('Rincian Pesan Pengumuman')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Tuliskan rincian lengkap pengumuman untuk pengunjung web...'),
                    ]),

                Section::make('Tautan Ajakan Aksi (CTA)')
                    ->columns(2)
                    ->schema([
                        TextInput::make('cta_text')
                            ->label('Label Tombol Tautan (Opsional)')
                            ->placeholder('cth. Baca Petunjuk Teknis'),

                        TextInput::make('cta_url')
                            ->label('Tautan URL')
                            ->placeholder('cth. /ppdb atau https://...'),
                    ]),

                Section::make('Periode Penayangan & Status')
                    ->columns(3)
                    ->schema([
                        DateTimePicker::make('start_date')
                            ->label('Mulai Ditayangkan')
                            ->default(now())
                            ->required(),

                        DateTimePicker::make('end_date')
                            ->label('Selesai Ditayangkan')
                            ->default(now()->addMonths(1))
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\MediaAssets\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MediaAssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unggah Berkas Media')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('Pilih Berkas')
                            ->disk('public')
                            ->directory('uploads/media')
                            ->visibility('public')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Mendukung format gambar (PNG, JPG, WebP), dokumen PDF/DOC, dan video.'),

                        TextInput::make('file_name')
                            ->label('Nama Berkas')
                            ->maxLength(200)
                            ->placeholder('Otomatis dari nama file jika dikosongkan'),

                        Select::make('file_type')
                            ->label('Tipe Media')
                            ->options([
                                'image' => 'Gambar Visual',
                                'video' => 'Video',
                                'document' => 'Dokumen / Berkas',
                            ])
                            ->default('image')
                            ->required(),

                        TextInput::make('alt_text')
                            ->label('Teks Alternatif / Keterangan')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Keterangan deskriptif untuk SEO dan aksesibilitas pembaca layar'),
                    ]),
            ]);
    }
}

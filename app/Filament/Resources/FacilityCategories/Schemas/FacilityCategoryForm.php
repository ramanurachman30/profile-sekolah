<?php

namespace App\Filament\Resources\FacilityCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FacilityCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategori Sarana & Prasarana')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori Sarpras')
                            ->required()
                            ->maxLength(60)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: Ruang Belajar & Pembelajaran / Sarana Ibadah & Olahraga'),
                    ]),
            ]);
    }
}

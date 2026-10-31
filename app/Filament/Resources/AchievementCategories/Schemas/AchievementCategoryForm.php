<?php

namespace App\Filament\Resources\AchievementCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AchievementCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategori Prestasi Siswa')
                    ->columns(2)
                    ->schema([
                        TextInput::make('category_name')
                            ->label('Nama Kategori Lomba / Prestasi')
                            ->required()
                            ->maxLength(60)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, callable $set): void {
                                if ($operation === 'create' && $state) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(70)
                            ->unique(ignoreRecord: true),
                    ]),
            ]);
    }
}

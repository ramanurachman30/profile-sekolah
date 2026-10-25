<?php

namespace App\Filament\Resources\PpdbPeriods\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PpdbPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'year_code')
                    ->required(),
                TextInput::make('wave_name')
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                TextInput::make('target_quota')
                    ->required()
                    ->numeric()
                    ->default(84),
                Toggle::make('is_open')
                    ->required(),
            ]);
    }
}

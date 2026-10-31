<?php

namespace App\Filament\Resources\CharacterHabits\Pages;

use App\Filament\Resources\CharacterHabits\CharacterHabitResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCharacterHabits extends ListRecords
{
    protected static string $resource = CharacterHabitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

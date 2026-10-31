<?php

namespace App\Filament\Resources\CharacterHabits\Pages;

use App\Filament\Resources\CharacterHabits\CharacterHabitResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCharacterHabit extends ViewRecord
{
    protected static string $resource = CharacterHabitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

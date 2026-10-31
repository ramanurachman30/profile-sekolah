<?php

namespace App\Filament\Resources\CharacterHabits\Pages;

use App\Filament\Resources\CharacterHabits\CharacterHabitResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCharacterHabit extends EditRecord
{
    protected static string $resource = CharacterHabitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

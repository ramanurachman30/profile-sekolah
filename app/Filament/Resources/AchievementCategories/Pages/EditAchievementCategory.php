<?php

namespace App\Filament\Resources\AchievementCategories\Pages;

use App\Filament\Resources\AchievementCategories\AchievementCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAchievementCategory extends EditRecord
{
    protected static string $resource = AchievementCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

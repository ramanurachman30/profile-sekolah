<?php

namespace App\Filament\Resources\SchoolVisits\Pages;

use App\Filament\Resources\SchoolVisits\SchoolVisitResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSchoolVisit extends EditRecord
{
    protected static string $resource = SchoolVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

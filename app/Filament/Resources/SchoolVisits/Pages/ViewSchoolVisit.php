<?php

namespace App\Filament\Resources\SchoolVisits\Pages;

use App\Filament\Resources\SchoolVisits\SchoolVisitResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSchoolVisit extends ViewRecord
{
    protected static string $resource = SchoolVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

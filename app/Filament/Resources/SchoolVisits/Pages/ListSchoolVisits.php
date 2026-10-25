<?php

namespace App\Filament\Resources\SchoolVisits\Pages;

use App\Filament\Resources\SchoolVisits\SchoolVisitResource;
use Filament\Resources\Pages\ListRecords;

class ListSchoolVisits extends ListRecords
{
    protected static string $resource = SchoolVisitResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

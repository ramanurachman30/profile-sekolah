<?php

namespace App\Filament\Resources\PpdbPeriods\Pages;

use App\Filament\Resources\PpdbPeriods\PpdbPeriodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPpdbPeriods extends ListRecords
{
    protected static string $resource = PpdbPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

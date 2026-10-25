<?php

namespace App\Filament\Resources\PpdbPeriods\Pages;

use App\Filament\Resources\PpdbPeriods\PpdbPeriodResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPpdbPeriod extends EditRecord
{
    protected static string $resource = PpdbPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

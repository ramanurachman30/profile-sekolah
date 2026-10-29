<?php

namespace App\Filament\Resources\CmsKeyHighlights\Pages;

use App\Filament\Resources\CmsKeyHighlights\CmsKeyHighlightResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCmsKeyHighlight extends ViewRecord
{
    protected static string $resource = CmsKeyHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

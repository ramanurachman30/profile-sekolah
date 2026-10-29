<?php

namespace App\Filament\Resources\CmsKeyHighlights\Pages;

use App\Filament\Resources\CmsKeyHighlights\CmsKeyHighlightResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCmsKeyHighlights extends ListRecords
{
    protected static string $resource = CmsKeyHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

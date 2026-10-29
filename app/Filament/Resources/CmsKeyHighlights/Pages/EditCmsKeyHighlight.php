<?php

namespace App\Filament\Resources\CmsKeyHighlights\Pages;

use App\Filament\Resources\CmsKeyHighlights\CmsKeyHighlightResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCmsKeyHighlight extends EditRecord
{
    protected static string $resource = CmsKeyHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

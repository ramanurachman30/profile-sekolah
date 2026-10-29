<?php

namespace App\Filament\Resources\CmsBanners\Pages;

use App\Filament\Resources\CmsBanners\CmsBannerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCmsBanner extends ViewRecord
{
    protected static string $resource = CmsBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

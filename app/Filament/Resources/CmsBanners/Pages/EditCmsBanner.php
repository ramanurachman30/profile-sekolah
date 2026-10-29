<?php

namespace App\Filament\Resources\CmsBanners\Pages;

use App\Filament\Resources\CmsBanners\CmsBannerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCmsBanner extends EditRecord
{
    protected static string $resource = CmsBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

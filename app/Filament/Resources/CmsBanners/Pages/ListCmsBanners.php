<?php

namespace App\Filament\Resources\CmsBanners\Pages;

use App\Filament\Resources\CmsBanners\CmsBannerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCmsBanners extends ListRecords
{
    protected static string $resource = CmsBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

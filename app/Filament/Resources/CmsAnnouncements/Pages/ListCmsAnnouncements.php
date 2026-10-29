<?php

namespace App\Filament\Resources\CmsAnnouncements\Pages;

use App\Filament\Resources\CmsAnnouncements\CmsAnnouncementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCmsAnnouncements extends ListRecords
{
    protected static string $resource = CmsAnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

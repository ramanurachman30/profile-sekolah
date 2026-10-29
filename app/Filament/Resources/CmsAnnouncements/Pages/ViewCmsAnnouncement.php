<?php

namespace App\Filament\Resources\CmsAnnouncements\Pages;

use App\Filament\Resources\CmsAnnouncements\CmsAnnouncementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCmsAnnouncement extends ViewRecord
{
    protected static string $resource = CmsAnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

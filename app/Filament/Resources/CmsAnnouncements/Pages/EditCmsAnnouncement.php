<?php

namespace App\Filament\Resources\CmsAnnouncements\Pages;

use App\Filament\Resources\CmsAnnouncements\CmsAnnouncementResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCmsAnnouncement extends EditRecord
{
    protected static string $resource = CmsAnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

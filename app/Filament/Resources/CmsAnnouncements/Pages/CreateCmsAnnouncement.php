<?php

namespace App\Filament\Resources\CmsAnnouncements\Pages;

use App\Filament\Resources\CmsAnnouncements\CmsAnnouncementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCmsAnnouncement extends CreateRecord
{
    protected static string $resource = CmsAnnouncementResource::class;
}

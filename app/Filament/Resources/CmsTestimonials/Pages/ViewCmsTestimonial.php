<?php

namespace App\Filament\Resources\CmsTestimonials\Pages;

use App\Filament\Resources\CmsTestimonials\CmsTestimonialResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCmsTestimonial extends ViewRecord
{
    protected static string $resource = CmsTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

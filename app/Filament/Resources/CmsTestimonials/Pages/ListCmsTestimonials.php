<?php

namespace App\Filament\Resources\CmsTestimonials\Pages;

use App\Filament\Resources\CmsTestimonials\CmsTestimonialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCmsTestimonials extends ListRecords
{
    protected static string $resource = CmsTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

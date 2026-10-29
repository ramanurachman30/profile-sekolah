<?php

namespace App\Filament\Resources\CmsTestimonials\Pages;

use App\Filament\Resources\CmsTestimonials\CmsTestimonialResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCmsTestimonial extends EditRecord
{
    protected static string $resource = CmsTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

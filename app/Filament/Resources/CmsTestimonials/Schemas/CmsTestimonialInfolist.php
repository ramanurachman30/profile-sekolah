<?php

namespace App\Filament\Resources\CmsTestimonials\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CmsTestimonialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('person_name'),
                TextEntry::make('person_category')
                    ->badge(),
                TextEntry::make('role_title'),
                TextEntry::make('testimonial_text')
                    ->columnSpanFull(),
                TextEntry::make('rating')
                    ->numeric(),
                TextEntry::make('avatar_asset_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('placement'),
                IconEntry::make('is_featured')
                    ->boolean(),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}

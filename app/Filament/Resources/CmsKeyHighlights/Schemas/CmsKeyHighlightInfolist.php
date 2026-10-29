<?php

namespace App\Filament\Resources\CmsKeyHighlights\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CmsKeyHighlightInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('placement_target'),
                TextEntry::make('icon_name'),
                TextEntry::make('metric_value'),
                TextEntry::make('title'),
                TextEntry::make('description'),
                TextEntry::make('badge_color'),
                TextEntry::make('link_url')
                    ->placeholder('-'),
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

<?php

namespace App\Filament\Resources\CmsPageSections\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CmsPageSectionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('page_code'),
                TextEntry::make('section_key'),
                TextEntry::make('badge_title')
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('subtitle')
                    ->placeholder('-'),
                IconEntry::make('is_visible')
                    ->boolean(),
                TextEntry::make('sort_order')
                    ->numeric(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

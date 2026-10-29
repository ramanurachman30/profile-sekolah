<?php

namespace App\Filament\Resources\CmsBanners\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CmsBannerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('placement'),
                TextEntry::make('badge_text')
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('subtitle'),
                TextEntry::make('cta_primary_text')
                    ->placeholder('-'),
                TextEntry::make('cta_primary_url')
                    ->placeholder('-'),
                TextEntry::make('cta_secondary_text')
                    ->placeholder('-'),
                TextEntry::make('cta_secondary_url')
                    ->placeholder('-'),
                TextEntry::make('mediaAsset.id')
                    ->label('Media asset')
                    ->placeholder('-'),
                TextEntry::make('start_date')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('end_date')
                    ->dateTime()
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

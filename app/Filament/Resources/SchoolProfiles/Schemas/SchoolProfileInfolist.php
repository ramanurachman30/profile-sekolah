<?php

namespace App\Filament\Resources\SchoolProfiles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SchoolProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID')
                    ->numeric(),
                TextEntry::make('npsn'),
                TextEntry::make('school_name'),
                TextEntry::make('school_level'),
                TextEntry::make('accreditation'),
                TextEntry::make('headmaster_name'),
                TextEntry::make('headmaster_nip')
                    ->placeholder('-'),
                TextEntry::make('headmaster_welcome_quote')
                    ->placeholder('-'),
                TextEntry::make('headmaster_welcome_text')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('headmaster_photo_asset_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('phone'),
                TextEntry::make('whatsapp'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('address'),
                TextEntry::make('sub_district'),
                TextEntry::make('district'),
                TextEntry::make('postal_code'),
                TextEntry::make('social_facebook')
                    ->placeholder('-'),
                TextEntry::make('social_instagram')
                    ->placeholder('-'),
                TextEntry::make('social_youtube')
                    ->placeholder('-'),
                TextEntry::make('maps_embed_url')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('operating_hours'),
                TextEntry::make('vision')
                    ->columnSpanFull(),
                TextEntry::make('mission')
                    ->columnSpanFull(),
                TextEntry::make('history_summary')
                    ->columnSpanFull(),
                TextEntry::make('logo_asset_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

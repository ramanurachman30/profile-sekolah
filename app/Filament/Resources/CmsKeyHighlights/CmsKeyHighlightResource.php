<?php

namespace App\Filament\Resources\CmsKeyHighlights;

use App\Filament\Resources\CmsKeyHighlights\Pages\CreateCmsKeyHighlight;
use App\Filament\Resources\CmsKeyHighlights\Pages\EditCmsKeyHighlight;
use App\Filament\Resources\CmsKeyHighlights\Pages\ListCmsKeyHighlights;
use App\Filament\Resources\CmsKeyHighlights\Pages\ViewCmsKeyHighlight;
use App\Filament\Resources\CmsKeyHighlights\Schemas\CmsKeyHighlightForm;
use App\Filament\Resources\CmsKeyHighlights\Schemas\CmsKeyHighlightInfolist;
use App\Filament\Resources\CmsKeyHighlights\Tables\CmsKeyHighlightsTable;
use App\Models\CmsKeyHighlight;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CmsKeyHighlightResource extends Resource
{
    protected static ?string $model = CmsKeyHighlight::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static \UnitEnum|string|null $navigationGroup = '🎨 Tampilan & Halaman Web (CMS)';

    protected static ?string $navigationLabel = 'Fakta & Keunggulan';

    protected static ?string $modelLabel = 'Keunggulan & Metrik';

    protected static ?string $pluralModelLabel = 'Fakta & Keunggulan Sekolah';

    protected static ?int $navigationSort = 4;

    public static function canViewAny(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu', 'guru_humas']);
    }

    public static function canCreate(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu', 'guru_humas']);
    }

    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu', 'guru_humas']);
    }

    public static function canDelete($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && $user->role === 'superadmin';
    }

    public static function form(Schema $schema): Schema
    {
        return CmsKeyHighlightForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CmsKeyHighlightInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CmsKeyHighlightsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCmsKeyHighlights::route('/'),
            'create' => CreateCmsKeyHighlight::route('/create'),
            'view' => ViewCmsKeyHighlight::route('/{record}'),
            'edit' => EditCmsKeyHighlight::route('/{record}/edit'),
        ];
    }
}

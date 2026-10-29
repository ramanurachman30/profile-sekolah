<?php

namespace App\Filament\Resources\CmsBanners;

use App\Filament\Resources\CmsBanners\Pages\CreateCmsBanner;
use App\Filament\Resources\CmsBanners\Pages\EditCmsBanner;
use App\Filament\Resources\CmsBanners\Pages\ListCmsBanners;
use App\Filament\Resources\CmsBanners\Pages\ViewCmsBanner;
use App\Filament\Resources\CmsBanners\Schemas\CmsBannerForm;
use App\Filament\Resources\CmsBanners\Schemas\CmsBannerInfolist;
use App\Filament\Resources\CmsBanners\Tables\CmsBannersTable;
use App\Models\CmsBanner;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CmsBannerResource extends Resource
{
    protected static ?string $model = CmsBanner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static \UnitEnum|string|null $navigationGroup = '🎨 Tampilan & Halaman Web (CMS)';

    protected static ?string $navigationLabel = 'Banner & Slider';

    protected static ?string $modelLabel = 'Banner & Slider';

    protected static ?string $pluralModelLabel = 'Banner, Slider & CTA';

    protected static ?int $navigationSort = 3;

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
        return CmsBannerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CmsBannerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CmsBannersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCmsBanners::route('/'),
            'create' => CreateCmsBanner::route('/create'),
            'view' => ViewCmsBanner::route('/{record}'),
            'edit' => EditCmsBanner::route('/{record}/edit'),
        ];
    }
}

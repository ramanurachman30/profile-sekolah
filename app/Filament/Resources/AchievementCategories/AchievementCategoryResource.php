<?php

namespace App\Filament\Resources\AchievementCategories;

use App\Filament\Resources\AchievementCategories\Pages\CreateAchievementCategory;
use App\Filament\Resources\AchievementCategories\Pages\EditAchievementCategory;
use App\Filament\Resources\AchievementCategories\Pages\ListAchievementCategories;
use App\Filament\Resources\AchievementCategories\Schemas\AchievementCategoryForm;
use App\Filament\Resources\AchievementCategories\Tables\AchievementCategoriesTable;
use App\Models\AchievementCategory;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AchievementCategoryResource extends Resource
{
    protected static ?string $model = AchievementCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmark;

    protected static \UnitEnum|string|null $navigationGroup = '📰 Publikasi & Galeri Publik';

    protected static ?string $navigationLabel = 'Kategori Prestasi';

    protected static ?string $modelLabel = 'Kategori Prestasi';

    protected static ?string $pluralModelLabel = 'Kategori Prestasi';

    protected static ?int $navigationSort = 4;

    public static function canViewAny(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu', 'guru_humas'], true);
    }

    public static function canCreate(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'guru_humas'], true);
    }

    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'guru_humas'], true);
    }

    public static function canDelete($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && $user->role === 'superadmin';
    }

    public static function form(Schema $schema): Schema
    {
        return AchievementCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AchievementCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAchievementCategories::route('/'),
            'create' => CreateAchievementCategory::route('/create'),
            'edit' => EditAchievementCategory::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\NewsCategories;

use App\Filament\Resources\NewsCategories\Pages\CreateNewsCategory;
use App\Filament\Resources\NewsCategories\Pages\EditNewsCategory;
use App\Filament\Resources\NewsCategories\Pages\ListNewsCategories;
use App\Filament\Resources\NewsCategories\Schemas\NewsCategoryForm;
use App\Filament\Resources\NewsCategories\Tables\NewsCategoriesTable;
use App\Models\NewsCategory;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class NewsCategoryResource extends Resource
{
    protected static ?string $model = NewsCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static \UnitEnum|string|null $navigationGroup = '📰 Publikasi & Galeri Publik';

    protected static ?string $navigationLabel = 'Kategori Berita';

    protected static ?string $modelLabel = 'Kategori Berita';

    protected static ?string $pluralModelLabel = 'Kategori Berita';

    protected static ?int $navigationSort = 2;

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
        return NewsCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNewsCategories::route('/'),
            'create' => CreateNewsCategory::route('/create'),
            'edit' => EditNewsCategory::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\FacilityCategories;

use App\Filament\Resources\FacilityCategories\Pages\CreateFacilityCategory;
use App\Filament\Resources\FacilityCategories\Pages\EditFacilityCategory;
use App\Filament\Resources\FacilityCategories\Pages\ListFacilityCategories;
use App\Filament\Resources\FacilityCategories\Schemas\FacilityCategoryForm;
use App\Filament\Resources\FacilityCategories\Tables\FacilityCategoriesTable;
use App\Models\FacilityCategory;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class FacilityCategoryResource extends Resource
{
    protected static ?string $model = FacilityCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquare3Stack3d;

    protected static \UnitEnum|string|null $navigationGroup = '📰 Publikasi & Galeri Publik';

    protected static ?string $navigationLabel = 'Kategori Sarpras';

    protected static ?string $modelLabel = 'Kategori Sarpras';

    protected static ?string $pluralModelLabel = 'Kategori Sarpras';

    protected static ?int $navigationSort = 8;

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

        return $user && in_array($user->role, ['superadmin', 'admin_tu'], true);
    }

    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu'], true);
    }

    public static function canDelete($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && $user->role === 'superadmin';
    }

    public static function form(Schema $schema): Schema
    {
        return FacilityCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FacilityCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFacilityCategories::route('/'),
            'create' => CreateFacilityCategory::route('/create'),
            'edit' => EditFacilityCategory::route('/{record}/edit'),
        ];
    }
}

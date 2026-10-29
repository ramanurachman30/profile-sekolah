<?php

namespace App\Filament\Resources\CmsPageSections;

use App\Filament\Resources\CmsPageSections\Pages\CreateCmsPageSection;
use App\Filament\Resources\CmsPageSections\Pages\EditCmsPageSection;
use App\Filament\Resources\CmsPageSections\Pages\ListCmsPageSections;
use App\Filament\Resources\CmsPageSections\Pages\ViewCmsPageSection;
use App\Filament\Resources\CmsPageSections\Schemas\CmsPageSectionForm;
use App\Filament\Resources\CmsPageSections\Schemas\CmsPageSectionInfolist;
use App\Filament\Resources\CmsPageSections\Tables\CmsPageSectionsTable;
use App\Models\CmsPageSection;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CmsPageSectionResource extends Resource
{
    protected static ?string $model = CmsPageSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquare3Stack3d;

    protected static \UnitEnum|string|null $navigationGroup = '🎨 Tampilan & Halaman Web (CMS)';

    protected static ?string $navigationLabel = 'Orkestrasi Section';

    protected static ?string $modelLabel = 'Section Halaman';

    protected static ?string $pluralModelLabel = 'Orkestrasi Section Halaman';

    protected static ?int $navigationSort = 2;

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

        return $user && in_array($user->role, ['superadmin', 'admin_tu']);
    }

    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu']);
    }

    public static function canDelete($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && $user->role === 'superadmin';
    }

    public static function form(Schema $schema): Schema
    {
        return CmsPageSectionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CmsPageSectionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CmsPageSectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCmsPageSections::route('/'),
            'create' => CreateCmsPageSection::route('/create'),
            'view' => ViewCmsPageSection::route('/{record}'),
            'edit' => EditCmsPageSection::route('/{record}/edit'),
        ];
    }
}

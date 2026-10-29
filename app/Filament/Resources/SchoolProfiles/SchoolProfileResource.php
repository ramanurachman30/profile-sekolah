<?php

namespace App\Filament\Resources\SchoolProfiles;

use App\Filament\Resources\SchoolProfiles\Pages\EditSchoolProfile;
use App\Filament\Resources\SchoolProfiles\Pages\ListSchoolProfiles;
use App\Filament\Resources\SchoolProfiles\Pages\ViewSchoolProfile;
use App\Filament\Resources\SchoolProfiles\Schemas\SchoolProfileForm;
use App\Filament\Resources\SchoolProfiles\Schemas\SchoolProfileInfolist;
use App\Filament\Resources\SchoolProfiles\Tables\SchoolProfilesTable;
use App\Models\SchoolProfile;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SchoolProfileResource extends Resource
{
    protected static ?string $model = SchoolProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static \UnitEnum|string|null $navigationGroup = '🎨 Tampilan & Halaman Web (CMS)';

    protected static ?string $navigationLabel = 'Identitas & Profil Sekolah';

    protected static ?string $modelLabel = 'Profil Sekolah';

    protected static ?string $pluralModelLabel = 'Identitas & Profil Sekolah';

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu', 'guru_humas']);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu']);
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return SchoolProfileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SchoolProfileInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchoolProfilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSchoolProfiles::route('/'),
            'view' => ViewSchoolProfile::route('/{record}'),
            'edit' => EditSchoolProfile::route('/{record}/edit'),
        ];
    }
}

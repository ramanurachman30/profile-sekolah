<?php

namespace App\Filament\Resources\SchoolVisits;

use App\Filament\Resources\SchoolVisits\Pages\EditSchoolVisit;
use App\Filament\Resources\SchoolVisits\Pages\ListSchoolVisits;
use App\Filament\Resources\SchoolVisits\Pages\ViewSchoolVisit;
use App\Filament\Resources\SchoolVisits\Schemas\SchoolVisitForm;
use App\Filament\Resources\SchoolVisits\Schemas\SchoolVisitInfolist;
use App\Filament\Resources\SchoolVisits\Tables\SchoolVisitsTable;
use App\Models\SchoolVisit;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SchoolVisitResource extends Resource
{
    protected static ?string $model = SchoolVisit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static \UnitEnum|string|null $navigationGroup = 'Pusat Bantuan & Layanan';

    protected static ?string $navigationLabel = 'Reservasi Kunjungan (Visit)';

    protected static ?string $modelLabel = 'Jadwal Kunjungan';

    protected static ?string $pluralModelLabel = 'Reservasi Kunjungan Sekolah';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && in_array($user->role, ['superadmin', 'admin_tu']);
    }

    public static function canCreate(): bool
    {
        return false; // Booking masuk mandiri dari formulir publik /kontak
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
        return SchoolVisitForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SchoolVisitInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchoolVisitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSchoolVisits::route('/'),
            'view' => ViewSchoolVisit::route('/{record}'),
            'edit' => EditSchoolVisit::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\PpdbPeriods;

use App\Filament\Resources\PpdbPeriods\Pages\CreatePpdbPeriod;
use App\Filament\Resources\PpdbPeriods\Pages\EditPpdbPeriod;
use App\Filament\Resources\PpdbPeriods\Pages\ListPpdbPeriods;
use App\Filament\Resources\PpdbPeriods\Schemas\PpdbPeriodForm;
use App\Filament\Resources\PpdbPeriods\Tables\PpdbPeriodsTable;
use App\Models\PpdbPeriod;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PpdbPeriodResource extends Resource
{
    protected static ?string $model = PpdbPeriod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static \UnitEnum|string|null $navigationGroup = 'Pusat PPDB Online';

    protected static ?string $navigationLabel = 'Gelombang & Kuota PPDB';

    protected static ?string $modelLabel = 'Gelombang PPDB';

    protected static ?string $pluralModelLabel = 'Gelombang & Kuota PPDB';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && in_array($user->role, ['superadmin', 'panitia_ppdb', 'admin_tu']);
    }

    public static function canCreate(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && in_array($user->role, ['superadmin', 'panitia_ppdb']);
    }

    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && in_array($user->role, ['superadmin', 'panitia_ppdb']);
    }

    public static function form(Schema $schema): Schema
    {
        return PpdbPeriodForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PpdbPeriodsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPpdbPeriods::route('/'),
            'create' => CreatePpdbPeriod::route('/create'),
            'edit' => EditPpdbPeriod::route('/{record}/edit'),
        ];
    }
}

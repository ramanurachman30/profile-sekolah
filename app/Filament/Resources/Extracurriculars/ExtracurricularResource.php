<?php

namespace App\Filament\Resources\Extracurriculars;

use App\Filament\Resources\Extracurriculars\Pages\CreateExtracurricular;
use App\Filament\Resources\Extracurriculars\Pages\EditExtracurricular;
use App\Filament\Resources\Extracurriculars\Pages\ListExtracurriculars;
use App\Filament\Resources\Extracurriculars\Pages\ViewExtracurricular;
use App\Filament\Resources\Extracurriculars\Schemas\ExtracurricularForm;
use App\Filament\Resources\Extracurriculars\Schemas\ExtracurricularInfolist;
use App\Filament\Resources\Extracurriculars\Tables\ExtracurricularsTable;
use App\Models\Extracurricular;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ExtracurricularResource extends Resource
{
    protected static ?string $model = Extracurricular::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static \UnitEnum|string|null $navigationGroup = '📰 Publikasi & Galeri Publik';

    protected static ?string $navigationLabel = 'Ekstrakurikuler';

    protected static ?string $modelLabel = 'Ekstrakurikuler';

    protected static ?string $pluralModelLabel = 'Katalog Ekstrakurikuler';

    protected static ?int $navigationSort = 9;

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
        return ExtracurricularForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExtracurricularInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExtracurricularsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExtracurriculars::route('/'),
            'create' => CreateExtracurricular::route('/create'),
            'view' => ViewExtracurricular::route('/{record}'),
            'edit' => EditExtracurricular::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\CharacterHabits;

use App\Filament\Resources\CharacterHabits\Pages\CreateCharacterHabit;
use App\Filament\Resources\CharacterHabits\Pages\EditCharacterHabit;
use App\Filament\Resources\CharacterHabits\Pages\ListCharacterHabits;
use App\Filament\Resources\CharacterHabits\Pages\ViewCharacterHabit;
use App\Filament\Resources\CharacterHabits\Schemas\CharacterHabitForm;
use App\Filament\Resources\CharacterHabits\Schemas\CharacterHabitInfolist;
use App\Filament\Resources\CharacterHabits\Tables\CharacterHabitsTable;
use App\Models\CharacterHabit;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CharacterHabitResource extends Resource
{
    protected static ?string $model = CharacterHabit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static \UnitEnum|string|null $navigationGroup = '📰 Publikasi & Galeri Publik';

    protected static ?string $navigationLabel = 'Pembiasaan Karakter 5S';

    protected static ?string $modelLabel = 'Pembiasaan Karakter';

    protected static ?string $pluralModelLabel = 'Pembiasaan Karakter Siswa';

    protected static ?int $navigationSort = 10;

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
        return CharacterHabitForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CharacterHabitInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CharacterHabitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCharacterHabits::route('/'),
            'create' => CreateCharacterHabit::route('/create'),
            'view' => ViewCharacterHabit::route('/{record}'),
            'edit' => EditCharacterHabit::route('/{record}/edit'),
        ];
    }
}

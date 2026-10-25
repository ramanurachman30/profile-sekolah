<?php

namespace App\Filament\Resources\ClassRooms;

use App\Filament\Resources\ClassRooms\Pages\CreateClassRoom;
use App\Filament\Resources\ClassRooms\Pages\EditClassRoom;
use App\Filament\Resources\ClassRooms\Pages\ListClassRooms;
use App\Filament\Resources\ClassRooms\Pages\ViewClassRoom;
use App\Filament\Resources\ClassRooms\Schemas\ClassRoomForm;
use App\Filament\Resources\ClassRooms\Schemas\ClassRoomInfolist;
use App\Filament\Resources\ClassRooms\Tables\ClassRoomsTable;
use App\Models\ClassRoom;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ClassRoomResource extends Resource
{
    protected static ?string $model = ClassRoom::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    protected static \UnitEnum|string|null $navigationGroup = 'Master Data Akademik';

    protected static ?string $navigationLabel = 'Rombel & Kelas';

    protected static ?string $modelLabel = 'Rombel Kelas';

    protected static ?string $pluralModelLabel = 'Rombel & Kelas';

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
        return ClassRoomForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClassRoomInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClassRoomsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClassRooms::route('/'),
            'create' => CreateClassRoom::route('/create'),
            'view' => ViewClassRoom::route('/{record}'),
            'edit' => EditClassRoom::route('/{record}/edit'),
        ];
    }
}

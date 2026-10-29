<?php

namespace App\Filament\Resources\CmsAnnouncements;

use App\Filament\Resources\CmsAnnouncements\Pages\CreateCmsAnnouncement;
use App\Filament\Resources\CmsAnnouncements\Pages\EditCmsAnnouncement;
use App\Filament\Resources\CmsAnnouncements\Pages\ListCmsAnnouncements;
use App\Filament\Resources\CmsAnnouncements\Pages\ViewCmsAnnouncement;
use App\Filament\Resources\CmsAnnouncements\Schemas\CmsAnnouncementForm;
use App\Filament\Resources\CmsAnnouncements\Schemas\CmsAnnouncementInfolist;
use App\Filament\Resources\CmsAnnouncements\Tables\CmsAnnouncementsTable;
use App\Models\CmsAnnouncement;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CmsAnnouncementResource extends Resource
{
    protected static ?string $model = CmsAnnouncement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static \UnitEnum|string|null $navigationGroup = '🎨 Tampilan & Halaman Web (CMS)';

    protected static ?string $navigationLabel = 'Pengumuman & Ticker';

    protected static ?string $modelLabel = 'Pengumuman & Ticker';

    protected static ?string $pluralModelLabel = 'Pengumuman & Ticker';

    protected static ?int $navigationSort = 6;

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

        return $user && in_array($user->role, ['superadmin', 'admin_tu', 'guru_humas']);
    }

    public static function canEdit($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu', 'guru_humas']);
    }

    public static function canDelete($record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user && $user->role === 'superadmin';
    }

    public static function form(Schema $schema): Schema
    {
        return CmsAnnouncementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CmsAnnouncementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CmsAnnouncementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCmsAnnouncements::route('/'),
            'create' => CreateCmsAnnouncement::route('/create'),
            'view' => ViewCmsAnnouncement::route('/{record}'),
            'edit' => EditCmsAnnouncement::route('/{record}/edit'),
        ];
    }
}

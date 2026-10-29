<?php

namespace App\Filament\Resources\CmsTestimonials;

use App\Filament\Resources\CmsTestimonials\Pages\CreateCmsTestimonial;
use App\Filament\Resources\CmsTestimonials\Pages\EditCmsTestimonial;
use App\Filament\Resources\CmsTestimonials\Pages\ListCmsTestimonials;
use App\Filament\Resources\CmsTestimonials\Pages\ViewCmsTestimonial;
use App\Filament\Resources\CmsTestimonials\Schemas\CmsTestimonialForm;
use App\Filament\Resources\CmsTestimonials\Schemas\CmsTestimonialInfolist;
use App\Filament\Resources\CmsTestimonials\Tables\CmsTestimonialsTable;
use App\Models\CmsTestimonial;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CmsTestimonialResource extends Resource
{
    protected static ?string $model = CmsTestimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleBottomCenterText;

    protected static \UnitEnum|string|null $navigationGroup = '🎨 Tampilan & Halaman Web (CMS)';

    protected static ?string $navigationLabel = 'Testimoni & Ulasan';

    protected static ?string $modelLabel = 'Testimoni & Ulasan';

    protected static ?string $pluralModelLabel = 'Ulasan & Testimoni';

    protected static ?int $navigationSort = 5;

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
        return CmsTestimonialForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CmsTestimonialInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CmsTestimonialsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCmsTestimonials::route('/'),
            'create' => CreateCmsTestimonial::route('/create'),
            'view' => ViewCmsTestimonial::route('/{record}'),
            'edit' => EditCmsTestimonial::route('/{record}/edit'),
        ];
    }
}

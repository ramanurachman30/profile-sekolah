<?php

namespace App\Filament\Resources\NewsArticles;

use App\Filament\Resources\NewsArticles\Pages\CreateNewsArticle;
use App\Filament\Resources\NewsArticles\Pages\EditNewsArticle;
use App\Filament\Resources\NewsArticles\Pages\ListNewsArticles;
use App\Filament\Resources\NewsArticles\Pages\ViewNewsArticle;
use App\Filament\Resources\NewsArticles\Schemas\NewsArticleForm;
use App\Filament\Resources\NewsArticles\Schemas\NewsArticleInfolist;
use App\Filament\Resources\NewsArticles\Tables\NewsArticlesTable;
use App\Models\NewsArticle;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class NewsArticleResource extends Resource
{
    protected static ?string $model = NewsArticle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static \UnitEnum|string|null $navigationGroup = '📰 Publikasi & Galeri Publik';

    protected static ?string $navigationLabel = 'Warta Berita & Artikel';

    protected static ?string $modelLabel = 'Artikel Berita';

    protected static ?string $pluralModelLabel = 'Warta Berita & Artikel';

    protected static ?int $navigationSort = 1;

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
        return NewsArticleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NewsArticleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsArticlesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNewsArticles::route('/'),
            'create' => CreateNewsArticle::route('/create'),
            'view' => ViewNewsArticle::route('/{record}'),
            'edit' => EditNewsArticle::route('/{record}/edit'),
        ];
    }
}

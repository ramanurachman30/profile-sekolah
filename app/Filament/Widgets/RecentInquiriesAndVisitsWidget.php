<?php

namespace App\Filament\Widgets;

use App\Models\ContactInquiry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentInquiriesAndVisitsWidget extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'admin_tu', 'guru_humas']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ContactInquiry::query()->latest('id')->limit(6))
            ->heading('Pesan & Aduan Orang Tua Terbaru')
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('No. Tiket')
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('sender_name')
                    ->label('Pengirim')
                    ->weight('bold'),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->category_label)
                    ->color(fn (string $state): string => match ($state) {
                        'ppdb' => 'primary',
                        'administrasi' => 'info',
                        'mutasi' => 'warning',
                        'konsultasi' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('subject')
                    ->label('Topik / Subjek')
                    ->limit(35),

                TextColumn::make('ticket_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->status_label)
                    ->color(fn (string $state): string => match ($state) {
                        'baru' => 'warning',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        'arsip' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->paginated(false);
    }
}

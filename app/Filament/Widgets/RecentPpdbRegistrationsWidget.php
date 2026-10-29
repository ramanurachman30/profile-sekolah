<?php

namespace App\Filament\Widgets;

use App\Models\PpdbRegistration;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentPpdbRegistrationsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        $user = Auth::user();

        return $user && in_array($user->role, ['superadmin', 'panitia_ppdb']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(PpdbRegistration::query()->latest('id')->limit(6))
            ->heading('Pendaftaran Calon Siswa Baru Terbaru')
            ->columns([
                TextColumn::make('registration_number')
                    ->label('No. Registrasi')
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('child_full_name')
                    ->label('Nama Calon Siswa')
                    ->weight('bold'),

                TextColumn::make('track')
                    ->label('Jalur Masuk')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->track_label)
                    ->color(fn (string $state): string => match ($state) {
                        'zonasi' => 'primary',
                        'afirmasi' => 'warning',
                        'perpindahan_ortu' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('verification_status')
                    ->label('Status Verifikasi')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->verification_status_label)
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'diverifikasi' => 'info',
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Waktu Pendaftaran')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->paginated(false);
    }
}

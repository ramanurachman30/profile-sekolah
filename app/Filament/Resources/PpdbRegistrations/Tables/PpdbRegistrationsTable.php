<?php

namespace App\Filament\Resources\PpdbRegistrations\Tables;

use App\Models\ClassRoom;
use App\Models\PpdbPeriod;
use App\Services\PpdbEnrollmentService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PpdbRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration_number')
                    ->label('No. Registrasi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Nomor registrasi disalin'),

                TextColumn::make('child_full_name')
                    ->label('Nama Calon Siswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('track')
                    ->label('Jalur')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->track_label)
                    ->color(fn (string $state): string => match ($state) {
                        'zonasi' => 'primary',
                        'afirmasi' => 'warning',
                        'perpindahan_ortu' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('child_gender')
                    ->label('L/P')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'L' ? 'info' : 'pink'),

                TextColumn::make('child_age_years')
                    ->label('Usia')
                    ->formatStateUsing(fn ($record) => "{$record->child_age_years} thn {$record->child_age_months} bln"),

                TextColumn::make('parent_name')
                    ->label('Nama Wali')
                    ->searchable(),

                TextColumn::make('parent_phone')
                    ->label('WhatsApp Wali')
                    ->searchable(),

                TextColumn::make('verification_status')
                    ->label('Status')
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
                    ->label('Waktu Daftar')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('period_id')
                    ->label('Gelombang PPDB')
                    ->options(PpdbPeriod::pluck('wave_name', 'id')),

                SelectFilter::make('track')
                    ->label('Jalur Pendaftaran')
                    ->options([
                        'zonasi' => 'Zonasi',
                        'afirmasi' => 'Afirmasi',
                        'perpindahan_ortu' => 'Perpindahan Tugas Ortu',
                        'reguler' => 'Reguler',
                    ]),

                SelectFilter::make('verification_status')
                    ->label('Status Verifikasi')
                    ->options([
                        'menunggu' => 'Menunggu Verifikasi',
                        'diverifikasi' => 'Sedang Diverifikasi',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                
                // Action: Terima Calon Siswa (Auto-enroll ke mst_students)
                Action::make('accept')
                    ->label('Terima Siswa')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn ($record) => $record->verification_status !== 'diterima' && Auth::user()?->hasRole(['superadmin', 'panitia_ppdb']))
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Penerimaan Siswa Baru')
                    ->modalDescription(fn ($record) => "Terima calon siswa '{$record->child_full_name}' ({$record->registration_number}) dan masukkan secara otomatis ke master siswa aktif?")
                    ->form([
                        Select::make('class_id')
                            ->label('Penempatan Rombel Kelas (Opsional)')
                            ->options(ClassRoom::pluck('class_name', 'id'))
                            ->searchable()
                            ->placeholder('Tunda penempatan atau pilih kelas'),
                    ])
                    ->action(function ($record, array $data) {
                        $enrollmentService = app(PpdbEnrollmentService::class);
                        $student = $enrollmentService->acceptRegistration($record, Auth::id(), $data['class_id'] ?? null);

                        Notification::make()
                            ->title('Calon Siswa Berhasil Diterima')
                            ->body("{$record->child_full_name} resmi terdaftar di master siswa (ID Siswa: #{$student->id}).")
                            ->success()
                            ->send();
                    }),

                // Action: Tolak Calon Siswa
                Action::make('reject')
                    ->label('Tolak')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn ($record) => $record->verification_status !== 'ditolak' && Auth::user()?->hasRole(['superadmin', 'panitia_ppdb']))
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pendaftaran Calon Siswa')
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->placeholder('Contoh: Usia belum mencukupi batas minimal 6 tahun per 1 Juli.'),
                    ])
                    ->action(function ($record, array $data) {
                        $enrollmentService = app(PpdbEnrollmentService::class);
                        $enrollmentService->rejectRegistration($record, $data['rejection_reason'], Auth::id());

                        Notification::make()
                            ->title('Pendaftaran Ditolak')
                            ->body("Pendaftaran {$record->child_full_name} telah ditolak dengan alasan: {$data['rejection_reason']}.")
                            ->warning()
                            ->send();
                    }),

                // Action: WhatsApp Ortu
                Action::make('whatsapp')
                    ->label('Hubungi WA')
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                    ->color('info')
                    ->url(function ($record) {
                        $clean = preg_replace('/[^0-9]/', '', $record->parent_phone);
                        if (str_starts_with($clean, '0')) {
                            $clean = '62' . substr($clean, 1);
                        }
                        $msg = rawurlencode("Halo Bapak/Ibu {$record->parent_name}, kami dari Panitia PPDB SDN Cikereteg 01 menginformasikan status pendaftaran putra/putri Anda ({$record->child_full_name} - {$record->registration_number}).");
                        return "https://wa.me/{$clean}?text={$msg}";
                    })
                    ->openUrlInNewTab(),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

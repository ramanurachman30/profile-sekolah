<?php

namespace App\Filament\Resources\ClassRooms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ClassRoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('class_name')
                    ->label('Nama Rombel')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('grade.grade_level')
                    ->label('Tingkat')
                    ->formatStateUsing(fn ($state) => "Kelas {$state}")
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('homeroomTeacher.full_name')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->placeholder('Belum Ditentukan'),

                TextColumn::make('room_name')
                    ->label('Ruangan')
                    ->placeholder('-'),

                TextColumn::make('capacity')
                    ->label('Kapasitas')
                    ->suffix(' Siswa')
                    ->alignCenter(),

                TextColumn::make('students_count')
                    ->counts('students')
                    ->label('Terisi')
                    ->suffix(' Siswa')
                    ->badge()
                    ->color('info')
                    ->alignCenter(),

                TextColumn::make('academicYear.year_code')
                    ->label('Tahun Ajaran')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('grade_id', 'asc')
            ->filters([
                SelectFilter::make('grade_id')
                    ->label('Tingkat Kelas')
                    ->relationship('grade', 'grade_level'),

                SelectFilter::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'year_code'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()?->role === 'superadmin'),
                ]),
            ]);
    }
}

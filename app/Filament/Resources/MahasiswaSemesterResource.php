<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaSemesterResource\Pages;
use App\Filament\Resources\MahasiswaSemesterResource\RelationManagers;
use App\Models\MahasiswaSemester;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MahasiswaSemesterResource extends Resource
{
    protected static ?string $model = MahasiswaSemester::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Kadep Akademik';

    protected static ?string $navigationLabel = 'Rekap Nilai Mahasiswa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Placeholder::make('mhs')
                ->label('Mahasiswa')
                ->content(fn($record) => $record?->mahasiswa?->name ?? '-'),

            Placeholder::make('sms')
                ->label('Semester')
                ->content(fn($record) => $record?->semester?->code ?? '-'),

            TextInput::make('ips')->readOnly(),
            TextInput::make('ipk')->readOnly(),
            TextInput::make('npa')->label('Nilai Akademik')->readOnly(),
            TextInput::make('npk')->label('Nilai Kepribadian')->readOnly(),
            TextInput::make('npj')->label('Nilai Jasmani')->readOnly(),
            TextInput::make('na')->label('Nilai Akhir')->readOnly(),

            Forms\Components\Toggle::make('eligible_next'), // opsional
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.code')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mahasiswa.angkatan')
                    ->label('Angkatan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mahasiswa.programStudy.code')
                    ->label('Prodi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ips')
                    ->label('IPS')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ipk')
                    ->label('IPK')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npa')
                    ->label('Nilai Akademik')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npk')
                    ->label('Nilai Kepribadian')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npj')
                    ->label('Nilai Jasmani')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('na')
                    ->label('Nilai Akhir')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('eligible_next')
                    ->searchable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMahasiswaSemesters::route('/'),
            'create' => Pages\CreateMahasiswaSemester::route('/create'),
            'edit' => Pages\EditMahasiswaSemester::route('/{record}/edit'),
        ];
    }
}

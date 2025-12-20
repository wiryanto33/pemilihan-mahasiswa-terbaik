<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramStudyResource\Pages;
use App\Filament\Resources\ProgramStudyResource\RelationManagers;
use App\Models\ProgramStudy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgramStudyResource extends Resource
{
    protected static ?string $model = ProgramStudy::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Kadep Akademik';

    protected static ?string $navigationLabel = 'Program Studi';
    protected static ?string $modelLabel = 'Program Studi';
    protected static ?string $pluralModelLabel = 'Program Studi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode Program Studi')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('level')
                    ->label('Strata')
                    ->placeholder('Pilih Strata')
                    ->options(['S2' => 'S2', 'S1' => 'S1', 'D3' => 'D3'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Program Studi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level')
                    ->label('Strata'),
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
            'index' => Pages\ListProgramStudies::route('/'),
            'create' => Pages\CreateProgramStudy::route('/create'),
            'edit' => Pages\EditProgramStudy::route('/{record}/edit'),
        ];
    }
}

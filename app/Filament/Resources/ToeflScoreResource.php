<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToeflScoreResource\Pages;
use App\Filament\Resources\ToeflScoreResource\RelationManagers;
use App\Models\ToeflScore;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ToeflScoreResource extends Resource
{
    protected static ?string $model = ToeflScore::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?string $navigationGroup = 'TOEFL';
    protected static ?string $modelLabel = 'Nilai TOEFL';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('mahasiswa_id')
                    ->relationship('mahasiswa', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('score')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(677),
                Forms\Components\DatePicker::make('test_date')
                    ->label('Tanggal Tes')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.name')
                    ->label('Mahasiswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mahasiswa.nrp')
                    ->label('NRP')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Skor TOEFL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('test_date')
                    ->label('Tanggal Tes')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListToeflScores::route('/'),
            'create' => Pages\CreateToeflScore::route('/create'),
            'edit' => Pages\EditToeflScore::route('/{record}/edit'),
        ];
    }
}

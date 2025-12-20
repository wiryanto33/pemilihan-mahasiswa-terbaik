<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FitnessMetricResource\Pages;
use App\Models\FitnessMetric;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FitnessMetricResource extends Resource
{
    protected static ?string $model = FitnessMetric::class;
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Aturan Garjas';
    protected static ?string $navigationLabel = 'Pembandingan';
    protected static ?string $modelLabel = 'Pembandingan';
    protected static ?string $pluralModelLabel = 'Pembandingan';
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('rule_set_id')
                ->relationship('ruleSet', 'name')
                ->label('Rule Set')->required()->searchable()->preload(),
            Forms\Components\TextInput::make('key')->label('Key')->required()
                ->helperText('Contoh: run_12min, pull_up, shuttle_run, swim_50m, posture_bmi_delta, posture_category'),
            Forms\Components\Select::make('direction')->label('Arah')
                ->options(['min' => 'Semakin besar semakin baik', 'max' => 'Semakin kecil semakin baik'])
                ->helperText('Biarkan kosong untuk metric kategori.'),
            Forms\Components\TextInput::make('unit')->label('Unit')->placeholder('meter / rep / sec / bmi'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('ruleSet.name')->label('Rule Set')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('key')->label('Key')->searchable(),
            Tables\Columns\TextColumn::make('direction')
                ->label('Arah')
                ->formatStateUsing(fn(?string $state): string => match ($state) {
                    'min'    => 'Min (>=)',
                    'max'    => 'Max (<=)',
                    default  => '-',
                }),
            Tables\Columns\TextColumn::make('unit')->label('Unit'),
        ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFitnessMetrics::route('/'),
            'create' => Pages\CreateFitnessMetric::route('/create'),
            'edit' => Pages\EditFitnessMetric::route('/{record}/edit'),
        ];
    }
}

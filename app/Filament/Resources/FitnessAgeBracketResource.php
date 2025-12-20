<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FitnessAgeBracketResource\Pages;
use App\Models\{FitnessAgeBracket, FitnessRuleSet};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FitnessAgeBracketResource extends Resource
{
    protected static ?string $model = FitnessAgeBracket::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Aturan Garjas';
    protected static ?string $navigationLabel = 'Rentang Usia';
    protected static ?string $modelLabel = 'Rentang Usia';
    protected static ?string $pluralModelLabel = 'Usia';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('rule_set_id')
                ->label('Rule Set')
                ->relationship('ruleSet', 'name')
                ->required()
                ->searchable()
                ->preload(),
            Forms\Components\Select::make('gender')
                ->label('Gender')
                ->options(['male' => 'Pria', 'female' => 'Wanita'])
                ->required(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('age_min')->label('Umur Min')->numeric()->required(),
                Forms\Components\TextInput::make('age_max')->label('Umur Max')->numeric()->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('ruleSet.name')->label('Rule Set')->sortable()->searchable(),
            Tables\Columns\BadgeColumn::make('gender')->label('Gender')
                ->colors(['primary' => 'male', 'danger' => 'female'])
                ->formatStateUsing(fn(?string $state): string => match ($state) {
                    'male'   => 'Pria',
                    'female' => 'Wanita',
                    default  => '-',
                }),
            Tables\Columns\TextColumn::make('age_min')->label('Min')->sortable(),
            Tables\Columns\TextColumn::make('age_max')->label('Max')->sortable(),
        ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFitnessAgeBrackets::route('/'),
            'create' => Pages\CreateFitnessAgeBracket::route('/create'),
            'edit' => Pages\EditFitnessAgeBracket::route('/{record}/edit'),
        ];
    }
}

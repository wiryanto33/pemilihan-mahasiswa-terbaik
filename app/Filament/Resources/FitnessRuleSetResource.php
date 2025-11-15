<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FitnessRuleSetResource\Pages;
use App\Models\FitnessRuleSet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FitnessRuleSetResource extends Resource
{
    protected static ?string $model = FitnessRuleSet::class;
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $navigationGroup = 'Aturan Garjas';
    protected static ?string $navigationLabel = 'Pedoman Aturan';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Rule Set')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\DatePicker::make('effective_date')
                        ->label('Tanggal Berlaku')
                        ->native(false),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktifkan')
                        ->helperText('Bila diaktifkan, rule set lain akan dinonaktifkan.')
                        ->reactive()
                        ->afterStateUpdated(function ($state, $record) {
                            if ($state) {
                                // jadikan single-active
                                \App\Models\FitnessRuleSet::where('id', '!=', $record?->id)->update(['is_active' => false]);
                            }
                        }),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('effective_date')->label('Berlaku')->date()->sortable(),
            Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean()->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
        ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('setActive')
                    ->label('Jadikan Aktif')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn($record) => !$record->is_active)
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        \DB::transaction(function () use ($record) {
                            \App\Models\FitnessRuleSet::where('id', '!=', $record->id)->update(['is_active' => false]);
                            $record->update(['is_active' => true]);
                        });
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFitnessRuleSets::route('/'),
            'create' => Pages\CreateFitnessRuleSet::route('/create'),
            'edit' => Pages\EditFitnessRuleSet::route('/{record}/edit'),
        ];
    }
}

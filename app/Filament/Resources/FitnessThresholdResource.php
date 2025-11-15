<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FitnessThresholdResource\Pages;
use App\Models\{FitnessThreshold, FitnessAgeBracket, FitnessMetric};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class FitnessThresholdResource extends Resource
{
    protected static ?string $model = FitnessThreshold::class;
    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $navigationGroup = 'Aturan Garjas';
    protected static ?string $navigationLabel = 'Tabel Nilai Garjas';
    protected static ?int $navigationSort = 40;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Konteks')
                ->schema([
                    Forms\Components\Select::make('age_bracket_id')
                        ->label('Age Bracket')
                        ->relationship('bracket', 'id', fn($q) => $q->with('ruleSet'))
                        ->getOptionLabelFromRecordUsing(fn(FitnessAgeBracket $r) =>
                        "{$r->ruleSet?->name} | " . ($r->gender === 'male' ? 'Pria' : 'Wanita') . " {$r->age_min}-{$r->age_max}")
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('metric_id')
                        ->label('Metric')
                        ->relationship('metric', 'key', fn($q) => $q->with('ruleSet'))
                        ->getOptionLabelFromRecordUsing(fn(FitnessMetric $m) =>
                        "{$m->ruleSet?->name} | {$m->key} " . ($m->direction ? "({$m->direction})" : ''))
                        ->searchable()
                        ->preload()
                        ->required(),
                ])->columns(2),

            Forms\Components\Section::make('Nilai → Skor')
                ->schema([
                    Forms\Components\TextInput::make('min_value')->numeric()->label('Min Value (pakai untuk direction=min)'),
                    Forms\Components\TextInput::make('max_value')->numeric()->label('Max Value (pakai untuk direction=max)'),
                    Forms\Components\TextInput::make('score')->numeric()->minValue(0)->maxValue(100)->required(),
                    Forms\Components\Placeholder::make('help')
                        ->content('Untuk metric waktu (shuttle_run, swim_50m) pakai Max Value. Untuk jarak/rep pakai Min Value.'),
                ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('bracket.ruleSet.name')->label('Rule Set')->sortable()->toggleable(),
            Tables\Columns\TextColumn::make('bracket.gender')->label('Gender')
                ->formatStateUsing(fn(?string $state): string => match ($state) {
                    'male'   => 'Pria',
                    'female' => 'Wanita',
                    default  => '-',
                }),
            Tables\Columns\TextColumn::make('bracket.age_min')->label('Min')->sortable(),
            Tables\Columns\TextColumn::make('bracket.age_max')->label('Max')->sortable(),
            Tables\Columns\TextColumn::make('metric.key')->label('Metric')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('metric.direction')->label('Arah')
                ->formatStateUsing(fn(?string $state): string => match ($state) {
                    'min'    => 'Min (>=)',
                    'max'    => 'Max (<=)',
                    default  => '-',
                }),
            Tables\Columns\TextColumn::make('min_value')->numeric(2)->label('Min'),
            Tables\Columns\TextColumn::make('max_value')->numeric(2)->label('Max'),
            Tables\Columns\TextColumn::make('score')->label('Skor')->sortable(),
        ])
            ->filters([
                SelectFilter::make('gender')
                    ->label('Gender')
                    ->options(['male' => 'Pria', 'female' => 'Wanita'])
                    ->query(function ($query, $data) {
                        if ($data['value'] ?? null) {
                            $query->whereHas('bracket', fn($q) => $q->where('gender', $data['value']));
                        }
                    }),
                SelectFilter::make('metric')
                    ->label('Metric')
                    ->options(fn() => \App\Models\FitnessMetric::pluck('key', 'id')->toArray())
                    ->query(function ($query, $data) {
                        if ($data['value'] ?? null) {
                            $query->where('metric_id', $data['value']);
                        }
                    }),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFitnessThresholds::route('/'),
            'create' => Pages\CreateFitnessThreshold::route('/create'),
            'edit' => Pages\EditFitnessThreshold::route('/{record}/edit'),
        ];
    }
}

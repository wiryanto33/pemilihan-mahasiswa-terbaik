<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonalityAssessmentResource\Pages;
use App\Models\PersonalityAssessment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PersonalityAssessmentResource extends Resource
{
    protected static ?string $model = PersonalityAssessment::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Korsis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('mahasiswa_id')
                    ->relationship('mahasiswa', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('semester_id')
                    ->relationship('semester', 'code')
                    ->required(),

                Forms\Components\TextInput::make('director_score')
                    ->label('Nilai Direktur')
                    ->numeric()->minValue(0)->maxValue(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateNpk($set, $get)),

                Forms\Components\TextInput::make('korsis_score')
                    ->label('Nilai Korsis')
                    ->numeric()->minValue(0)->maxValue(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateNpk($set, $get)),

                Forms\Components\TextInput::make('kaprodi_score')
                    ->label('Nilai Kaprodi')
                    ->numeric()->minValue(0)->maxValue(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, Get $get) => self::updateNpk($set, $get)),

                Forms\Components\TextInput::make('npk_final')
                    ->label('NPK Final')
                    ->readOnly()
                    ->numeric()
                    ->dehydrated(), // tetap disimpan ke DB
            ]);
    }

    /**
     * Hitung NPK final secara reaktif (0.20*Direktur + 0.50*Korsis + 0.30*Kaprodi).
     */
    protected static function updateNpk(Set $set, Get $get): void
    {
        $dir = self::toFloat($get('director_score'));
        $kor = self::toFloat($get('korsis_score'));
        $kap = self::toFloat($get('kaprodi_score'));

        if ($dir === null || $kor === null || $kap === null) {
            $set('npk_final', null);
            return;
        }

        $npk = round((0.20 * $dir) + (0.50 * $kor) + (0.30 * $kap), 2);
        $set('npk_final', $npk);
    }

    protected static function toFloat($v): ?float
    {
        if ($v === '' || $v === null) return null;
        return is_numeric($v) ? (float) $v : null;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.name')->label('Mahasiswa')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('semester.code')->label('Semester')->sortable(),
                Tables\Columns\TextColumn::make('director_score')->label('Direktur')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('korsis_score')->label('Korsis')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('kaprodi_score')->label('Kaprodi')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('npk_final')->label('NPK Final')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPersonalityAssessments::route('/'),
            'create' => Pages\CreatePersonalityAssessment::route('/create'),
            'edit' => Pages\EditPersonalityAssessment::route('/{record}/edit'),
        ];
    }
}

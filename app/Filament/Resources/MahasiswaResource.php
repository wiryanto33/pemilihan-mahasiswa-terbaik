<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Filament\Resources\MahasiswaResource\RelationManagers;
use App\Models\Mahasiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationIcon = 'fas-user-graduate';

    protected static ?string $navigationGroup = 'Prodi';

    public static function form(Form $form): Form
    {
        $user = auth()->user();
        $locked = !$user?->hasRole('super_admin'); // true jika user prodi (bukan super_admin)

        return $form
            ->schema([
                Forms\Components\Select::make('program_study_id')
                    ->label('Program Studi')
                    ->relationship(
                        name: 'programStudy',
                        titleAttribute: 'name',
                        modifyQueryUsing: function (Builder $query) {
                            $user = auth()->user();

                            // Jika bukan super_admin, tampilkan hanya prodi user
                            if ($user && !$user->hasRole('super_admin') && $user->program_study_id) {
                                $query->where('id', $user->program_study_id);   // <- ganti whereKey() dengan where()
                            }
                        }
                    )
                    ->default(fn() => auth()->user()?->program_study_id)
                    ->disabled(fn() => auth()->user() && !auth()->user()->hasRole('super_admin')) // kunci untuk user prodi
                    ->dehydrated(fn() => true)   // pastikan tetap tersubmit walau disabled
                    ->required()
                    ->preload()
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->level} - {$record->name}"),
                    
                Forms\Components\TextInput::make('nrp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    //simpan foto di storage/app/public/foto
                    ->directory('foto')
                    ->maxSize(2048),
                Forms\Components\TextInput::make('name')

                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pangkat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('korps')
                    ->maxLength(255),
                Forms\Components\TextInput::make('angkatan')
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->options(['Pria' => 'Pria', 'Wanita' => 'Wanita'])
                    ->required(),
                Forms\Components\DatePicker::make('birth_date'),
                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $q = parent::getEloquentQuery();

        $user = auth()->user();
        if ($user?->hasRole(['super_admin'])) {
            return $q; // full access
        }

        // user prodi: hanya prodi-nya
        return $q->where('program_study_id', $user->program_study_id);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('programStudy.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nrp')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pangkat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('korps')
                    ->searchable(),
                Tables\Columns\TextColumn::make('angkatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
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
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}

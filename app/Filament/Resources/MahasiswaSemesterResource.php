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
use Illuminate\Support\Facades\DB;

class MahasiswaSemesterResource extends Resource
{
    protected static ?string $model = MahasiswaSemester::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Kadep Akademik';

    protected static ?string $navigationLabel = 'Rekap Nilai Mahasiswa';
    protected static ?string $modelLabel = 'Rekap Nilai Mahasiswa';
    protected static ?string $pluralModelLabel = 'Rekap Nilai Mahasiswa Per Semester';

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
            ->query(function (Tables\Contracts\HasTable $livewire) {
                $user = auth()->user();

                $semesterId = $livewire->tableFilters['semester_id']['value'] ?? null;

                $subLatest = DB::table('mahasiswa_semesters as ms1')
                    ->selectRaw('ms1.mahasiswa_id, MAX(ms1.id) as max_id')
                    ->when($semesterId, fn($q) => $q->where('ms1.semester_id', $semesterId))
                    ->groupBy('ms1.mahasiswa_id');

                return MahasiswaSemester::query()
                    ->with(['mahasiswa.programStudy', 'semester'])
                    ->joinSub($subLatest, 'latest', function ($join) {
                        $join->on('mahasiswa_semesters.id', '=', 'latest.max_id');
                    })
                    ->when(
                        !$user?->hasRole('super_admin') && $user?->program_study_id,
                        fn($q) => $q->whereHas('mahasiswa', fn($m) => $m->where('program_study_id', $user->program_study_id))
                    );
            })
            ->defaultSort('na', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('Peringkat')
                    ->rowIndex()
                    ->alignCenter()
                    ->weight('bold'),
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
                Tables\Filters\SelectFilter::make('semester_id')
                    ->label('Semester')
                    ->options(fn() => \App\Models\Semester::query()->orderByDesc('code')->pluck('code', 'id'))
                    ->query(function (Builder $q, $data) {
                        // Handled in base query to correctly join latest
                    }),
                Tables\Filters\SelectFilter::make('angkatan')
                    ->label('Angkatan')
                    ->options(fn() => \App\Models\Mahasiswa::query()
                        ->whereNotNull('angkatan')
                        ->distinct()
                        ->orderByDesc('angkatan')
                        ->pluck('angkatan', 'angkatan'))
                    ->query(function (Builder $q, $data) {
                        if ($data['value'] ?? null) {
                            $q->whereHas('mahasiswa', fn($m) => $m->where('angkatan', $data['value']));
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Rekap Nilai Mahasiswa Per Semester')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalWidth('5xl')
                    ->modalContent(fn($record) => view(
                        'filament.tables.mahasiswa-semester-detail-modal',
                        [
                            'mahasiswa' => $record->mahasiswa,
                            'semesters' => \App\Models\MahasiswaSemester::with('semester')
                                ->where('mahasiswa_id', $record->mahasiswa_id)
                                ->orderByDesc('semester_id')
                                ->get(),
                        ]
                    )),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
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

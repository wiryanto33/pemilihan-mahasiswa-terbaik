<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicScorsResource\Pages;
use App\Models\AcademicScors;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\DB;

class AcademicScorsResource extends Resource
{
    protected static ?string $model = AcademicScors::class;


    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Prodi';
    protected static ?string $navigationLabel = 'Nilai Akademik';
    protected static ?string $modelLabel = 'Nilai Akademik';
    protected static ?string $pluralModelLabel = 'Nilai Akademik';

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        return $form->schema([
            // =========================
            // 1) IDENTITAS MAHASISWA
            // =========================
            Forms\Components\Section::make('Identitas Mahasiswa')
                ->description('Pilih mahasiswa. Prodi & angkatan akan terisi otomatis.')
                ->icon('heroicon-o-user-circle')
                ->schema([
                    Forms\Components\Grid::make(12)->schema([
                        Forms\Components\Select::make('mahasiswa_id')
                            ->label('Mahasiswa')
                            ->columnSpan(8)
                            // opsi awal (preload) difilter sesuai prodi user (non super_admin)
                            ->options(function () use ($user) {
                                return \App\Models\Mahasiswa::query()
                                    ->when(
                                        !$user?->hasRole('super_admin'),
                                        fn($q) =>
                                        $q->where('program_study_id', $user?->program_study_id)
                                    )
                                    ->orderBy('name')
                                    ->get()
                                    ->mapWithKeys(fn($m) => [
                                        $m->id => "{$m->name}/ {$m->pangkat} ({$m->korps}) {$m->nrp}"
                                    ]);
                                // ->pluck('name', 'id');
                            })
                            // hasil pencarian ikut difilter prodi user
                            ->getSearchResultsUsing(function (string $search) use ($user) {
                                return \App\Models\Mahasiswa::query()
                                    ->when(
                                        !$user?->hasRole('super_admin'),
                                        fn($q) =>
                                        $q->where('program_study_id', $user?->program_study_id)
                                    )
                                    ->where(
                                        fn($q) => $q
                                            ->where('name', 'like', "%{$search}%")
                                            ->orWhere('nrp', 'like', "%{$search}%")
                                    )
                                    ->orderBy('name')
                                    ->limit(50)
                                    ->pluck('name', 'id');
                            })
                            ->getOptionLabelUsing(function ($value) {
                                if (!$value) return null;
                                $m = \App\Models\Mahasiswa::with('programStudy')->find($value);
                                if (!$m) return null;

                                $prodi = $m->programStudy->name ?? 'N/A';
                                $angk  = $m->angkatan ?? '-';
                                return "{$m->name} — {$prodi}, Angkatan {$angk}";
                            })
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, Set $set) {
                                $m = $state ? \App\Models\Mahasiswa::with('programStudy')->find($state) : null;
                                $set('mahasiswa_prodi', $m?->programStudy?->name);
                                $set('mahasiswa_angkatan', $m?->angkatan);
                            }),

                        Forms\Components\TextInput::make('mahasiswa_prodi')
                            ->label('Program Studi')
                            ->columnSpan(4)
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\TextInput::make('mahasiswa_angkatan')
                            ->label('Angkatan')
                            ->columnSpan(4)
                            ->disabled()
                            ->dehydrated(false),
                    ]),
                ])->collapsible(),

            // ==============
            // 2) AKADEMIK
            // ==============
            Forms\Components\Section::make('Akademik')
                ->description('Tetapkan mata kuliah & semester.')
                ->icon('heroicon-o-academic-cap')
                ->schema([
                    Forms\Components\Grid::make(12)->schema([
                        Forms\Components\Select::make('matakuliah_id')
                            ->label('Mata Kuliah')
                            ->columnSpan(8)
                            // opsi awal
                            ->options(function () use ($user) {
                                return \App\Models\Matakuliah::query()
                                    ->when(
                                        !$user?->hasRole('super_admin'),
                                        fn($q) =>
                                        $q->where('program_study_id', $user?->program_study_id)
                                    )
                                    ->orderBy('name')
                                    ->pluck('name', 'id');
                            })
                            // hasil pencarian
                            ->getSearchResultsUsing(function (string $search) use ($user) {
                                return \App\Models\Matakuliah::query()
                                    ->when(
                                        !$user?->hasRole('super_admin'),
                                        fn($q) =>
                                        $q->where('program_study_id', $user?->program_study_id)
                                    )
                                    ->where('name', 'like', "%{$search}%")
                                    ->orderBy('name')
                                    ->limit(50)
                                    ->pluck('name', 'id');
                            })
                            ->getOptionLabelUsing(function ($value) {
                                if (!$value) return null;
                                $mk = \App\Models\Matakuliah::with('programStudy')->find($value);
                                if (!$mk) return null;
                                $prodi = $mk->programStudy?->name ?? 'N/A';
                                $sks   = $mk->sks ?? '-';
                                return "{$mk->name} ({$prodi}, {$sks} SKS)";
                            })
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),

                        Forms\Components\Select::make('semester_id')
                            ->label('Semester')
                            ->columnSpan(4)
                            ->relationship('semester', 'code')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),
                    ]),
                ])->collapsible(),

            // ==============
            // 3) PENILAIAN
            // ==============
            Forms\Components\Section::make('Penilaian')
                ->description('Masukkan nilai NU/UTS/UAS (0–100).')
                ->icon('heroicon-o-pencil-square')
                ->schema([
                    Forms\Components\Grid::make(12)->schema([
                        Forms\Components\TextInput::make('nu')
                            ->label('Quiz (NU)')
                            ->placeholder('Masukkan Nilai Quiz')
                            ->helperText('Opsional. Jika kosong, N = (4*UTS + 6*UAS)/10')
                            ->numeric()->minValue(0)->maxValue(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, Get $get) => self::updateFinalFields($set, $get))
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('uts')
                            ->label('UTS')
                            ->placeholder('Masukkan Nilai UTS')
                            ->numeric()->minValue(0)->maxValue(100)
                            ->live(onBlur: true)->required()
                            ->afterStateUpdated(fn(Set $set, Get $get) => self::updateFinalFields($set, $get))
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('uas')
                            ->label('UAS')
                            ->placeholder('Masukkan Nilai UAS')
                            ->numeric()->minValue(0)->maxValue(100)
                            ->live(onBlur: true)->required()
                            ->afterStateUpdated(fn(Set $set, Get $get) => self::updateFinalFields($set, $get))
                            ->columnSpan(4),
                    ]),
                ])->collapsible(),

            // =================
            // 4) HASIL AKHIR
            // =================
            Forms\Components\Section::make('Hasil Akhir')
                ->description('Nilai akhir dihitung otomatis.')
                ->icon('heroicon-o-check-badge')
                ->schema([
                    Forms\Components\Grid::make(12)->schema([
                        Forms\Components\TextInput::make('final_numeric')
                            ->label('Nilai Akhir (N)')
                            ->readOnly()
                            ->numeric()
                            ->dehydrated()
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('final_letter')
                            ->label('Grade')
                            ->readOnly()
                            ->maxLength(3)
                            ->dehydrated()
                            ->columnSpan(3),
                    ]),
                ])->collapsible(),
        ]);
    }



    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        return parent::getEloquentQuery()
            ->with(['mahasiswa.programStudy', 'matakuliah', 'semester'])
            ->when(
                !$user?->hasRole('super_admin'),
                fn($q) => $q->whereHas(
                    'mahasiswa',
                    fn($m) =>
                    $m->where('program_study_id', $user->program_study_id)
                )
            );
    }

    /**
     * Hitung & set final_numeric + final_letter secara reaktif.
     */
    protected static function updateFinalFields(Set $set, Get $get): void
    {
        $nu  = self::toFloat($get('nu'));
        $uts = self::toFloat($get('uts'));
        $uas = self::toFloat($get('uas'));

        // Hanya hitung jika UTS & UAS terisi (NU opsional)
        if ($uts !== null && $uas !== null) {
            if ($nu !== null) {
                $final = round((2 * $nu + 3 * $uts + 5 * $uas) / 10, 2);
            } else {
                $final = round((4 * $uts + 6 * $uas) / 10, 2);
            }
            $set('final_numeric', $final);
            $set('final_letter', self::toLetter($final));
        } else {
            $set('final_numeric', null);
            $set('final_letter', null);
        }
    }

    protected static function toFloat($v): ?float
    {
        if ($v === '' || $v === null) return null;
        return is_numeric($v) ? (float) $v : null;
    }

    protected static function toLetter(float $n): string
    {
        return match (true) {
            $n >= 85 => 'A',
            $n >= 80 => 'B+',
            $n >= 70 => 'B',
            $n >= 65 => 'C+',
            $n >= 55 => 'C',
            $n >= 40 => 'D',
            default => 'E',
        };
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $user = auth()->user();

                return Mahasiswa::query()
                    ->with('programStudy')
                    ->when(
                        // semua role selain super_admin disaring per prodi
                        !$user?->hasRole('super_admin'),
                        fn($q) => $q->where('program_study_id', $user?->program_study_id)
                    );
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Mahasiswa')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nrp')
                    ->label('NRP')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('programStudy.code')
                    ->label('Program Studi')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn($record) => 'Detail Nilai Akademik')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalWidth('6xl')
                    ->modalContent(fn($record) => view(
                        'filament.tables.academic-scor-detail-modal',
                        [
                            'mahasiswa' => $record,
                            'scores' => \App\Models\AcademicScors::with(['matakuliah', 'semester'])
                                ->where('mahasiswa_id', $record->id)
                                ->orderByDesc('semester_id')
                                ->get(),
                        ]
                    )),

                Tables\Actions\EditAction::make()
                    ->url(fn($record) => \App\Filament\Resources\MahasiswaResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->requiresConfirmation(),
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
            'index' => Pages\ListAcademicScors::route('/'),
            'create' => Pages\CreateAcademicScors::route('/create'),
            'edit' => Pages\EditAcademicScors::route('/{record}/edit'),

        ];
    }
}

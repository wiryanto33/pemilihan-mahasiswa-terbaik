<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PhysicalTestResource\Pages;
use App\Filament\Resources\PhysicalTestResource\RelationManagers;
use App\Models\PhysicalTest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use App\Support\Juklak\PhysicalScoring;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\DatePicker;
use Illuminate\Validation\Rules\Unique;

class PhysicalTestResource extends Resource
{
    protected static ?string $model = PhysicalTest::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';

    protected static ?string $navigationGroup = 'Kadep Pers';
    protected static ?string $navigationLabel = 'Nilai Garjas Mahasiswa';
    protected static ?string $modelLabel = 'Nilai Garjas Mahasiswa';
    protected static ?string $pluralModelLabel = 'Nilai Garjas';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ===== Identitas =====
                Section::make('Identitas')
                    ->description('Data mahasiswa & semester penilaian')
                    ->schema([
                        Grid::make(3)->schema([
                            Forms\Components\Select::make('mahasiswa_id')
                                ->relationship('mahasiswa', 'name')
                                ->required()
                                ->preload()
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                    if ($state) {
                                        $mhs = \App\Models\Mahasiswa::find($state);
                                        if ($mhs && $mhs->gender) {
                                            // Set gender untuk keperluan perhitungan
                                            $set('temp_gender', $mhs->gender === 'Pria' ? 'male' : 'female');
                                            // Trigger recalculation
                                            self::recalcFromRaw($set, $get);
                                        }
                                    }
                                }),

                            Forms\Components\Select::make('semester_id')
                                ->relationship('semester', 'code')
                                ->required()
                                ->unique(
                                    table: PhysicalTest::class,
                                    column: 'semester_id',
                                    ignoreRecord: true,
                                    modifyRuleUsing: fn (Unique $rule, Get $get) => $rule
                                        ->where('mahasiswa_id', $get('mahasiswa_id')),
                                ),

                            // Hidden field untuk menyimpan gender sementara
                            Forms\Components\Hidden::make('temp_gender'),

                            // Tanggal pelaksanaan tes (default hari ini)
                            DatePicker::make('test_date')
                                ->label('Tanggal Tes')
                                ->default(now())
                                ->required()
                                ->live()
                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                            // Display gender untuk user (read-only)
                            Forms\Components\Placeholder::make('gender_display')
                                ->label('Jenis Kelamin')
                                ->content(function (Get $get): string {
                                    $mahasiswaId = $get('mahasiswa_id');
                                    if ($mahasiswaId) {
                                        $mhs = \App\Models\Mahasiswa::find($mahasiswaId);
                                        return $mhs?->gender ?? 'Belum dipilih';
                                    }
                                    return 'Pilih mahasiswa terlebih dahulu';
                                }),

                            // Umur hasil kalkulasi (read-only)
                            Forms\Components\Placeholder::make('age_display')
                                ->label('Umur saat Tes')
                                ->content(function (Get $get): string {
                                    $mhsId = $get('mahasiswa_id');
                                    $testDate = $get('test_date') ? \Carbon\Carbon::parse($get('test_date')) : now();
                                    if (!$mhsId) return 'Pilih mahasiswa terlebih dahulu';
                                    $mhs = \App\Models\Mahasiswa::find($mhsId);
                                    if (!$mhs?->birth_date) return 'Tanggal lahir belum diisi';
                                    $age = \Carbon\Carbon::parse($mhs->birth_date)->diffInYears($testDate);
                                    return floor($age) . ' tahun';
                                }),
                        ]),
                    ]),

                // ===== Postur =====
                Section::make('Postur Tubuh')
                    ->description('Tinggi, berat, & nilai postur (konversi sesuai tabel Juklak)')
                    ->schema([
                        Grid::make(3)->schema([
                            Forms\Components\TextInput::make('height_cm')
                                ->label('Tinggi (cm)')
                                ->numeric()
                                ->minValue(100)->maxValue(230),
                            // ->live()
                            // ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                            Forms\Components\TextInput::make('weight_kg')
                                ->label('Berat (kg)')
                                ->numeric()
                                ->minValue(35)->maxValue(180),
                            // ->live()
                            // ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                            Forms\Components\TextInput::make('posture_score')
                                ->label('Nilai Postur (NP)')
                                ->helperText('Masukkan nilai hasil konversi tabel postur Juklak (0–100).')
                                ->numeric()->minValue(0)->maxValue(100)
                        ]),
                    ]),

                Tabs::make('Kesamaptaan')
                    ->tabs([
                        // ===== BATERAI A =====
                        Tab::make('Baterai A (Lari 12 Menit)')
                            ->schema([
                                Fieldset::make('Lari 12 Menit')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('run_12min_meter')
                                                ->label('Jarak (meter)')
                                                ->helperText('Jarak tempuh selama 12 menit.')
                                                ->numeric()->minValue(0)
                                                ->live()
                                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                                            Forms\Components\TextInput::make('garjas_a_score')
                                                ->label('Nilai Garjas A (NA)')
                                                ->helperText('Nilai hasil konversi jarak → skor (0-100) sesuai usia/gender.')
                                                ->numeric()->minValue(0)->maxValue(100)
                                                ->readOnly()
                                                ->dehydrated(),
                                        ]),
                                    ]),
                            ]),

                        // ===== BATERAI B (PRIA) =====
                        Tab::make('Baterai B (Pria)')
                            ->schema([
                                Fieldset::make('Item Baterai B - PRIA')
                                    ->schema([
                                        Grid::make(4)->schema([
                                            Forms\Components\TextInput::make('pull_up')
                                                ->label('Pull Up (repetisi)')
                                                ->numeric()->minValue(0)->maxValue(100)
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                                            Forms\Components\TextInput::make('sit_up')
                                                ->label('Sit Up (repetisi)')
                                                ->numeric()->minValue(0)->maxValue(100)
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                                            Forms\Components\TextInput::make('push_up')
                                                ->label('Push Up (repetisi)')
                                                ->numeric()->minValue(0)->maxValue(100)
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                                            Forms\Components\TextInput::make('shuttle_run_sec')
                                                ->label('Shuttle Run (detik)')
                                                ->numeric()->minValue(0)->maxValue(100)
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),
                                        ]),
                                    ])
                                    ->visible(function (Get $get): bool {
                                        $mahasiswaId = $get('mahasiswa_id');
                                        if ($mahasiswaId) {
                                            $mhs = \App\Models\Mahasiswa::find($mahasiswaId);
                                            return $mhs?->gender === 'Pria';
                                        }
                                        return false;
                                    }),
                            ]),

                        // ===== BATERAI B (WANITA) =====
                        Tab::make('Baterai B (Wanita)')
                            ->schema([
                                Fieldset::make('Item Baterai B - WANITA')
                                    ->schema([
                                        Grid::make(4)->schema([
                                            Forms\Components\TextInput::make('chinning')
                                                ->label('Chinning (repetisi)')
                                                ->numeric()->minValue(0)->maxValue(100)
                                                ->live()
                                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                                            Forms\Components\TextInput::make('modified_sit_up')
                                                ->label('Modified Sit Up (repetisi)')
                                                ->numeric()->minValue(0)->maxValue(100)
                                                ->live()
                                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                                            Forms\Components\TextInput::make('modified_push_up')
                                                ->label('Modified Push Up (repetisi)')
                                                ->numeric()->minValue(0)->maxValue(100)
                                                ->live()
                                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                                            Forms\Components\TextInput::make('shuttle_run_sec')
                                                ->label('Shuttle Run (detik)')
                                                ->numeric()->minValue(0)->maxValue(100)
                                                ->live()
                                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),
                                        ]),
                                    ])
                                    ->visible(function (Get $get): bool {
                                        $mahasiswaId = $get('mahasiswa_id');
                                        if ($mahasiswaId) {
                                            $mhs = \App\Models\Mahasiswa::find($mahasiswaId);
                                            return $mhs?->gender === 'Wanita';
                                        }
                                        return false;
                                    }),
                            ]),
                    ]),

                // ===== Ringkasan Garjas (Baterai B AVG + Garjas Total) =====
                Section::make('Ringkasan Garjas')
                    ->description('Rata-rata Baterai B dan Nilai Garjas (NA & NRB dirata-ratakan)')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('garjas_b_avg_score')
                                ->label('Nilai Baterai B Rata-rata (NRB)')
                                ->readOnly()
                                ->numeric()
                                ->dehydrated(),

                            Forms\Components\TextInput::make('garjas_score')
                                ->label('Nilai Garjas (NG)')
                                ->helperText('NG = (NA + NRB) / 2')
                                ->readOnly()
                                ->numeric()
                                ->dehydrated(),
                        ]),
                    ]),

                // ===== Renang =====
                Section::make('Renang 50m')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('swim_50m_sec')
                                ->label('Waktu (detik)')
                                ->numeric()->minValue(0)
                                ->live()
                                ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcFromRaw($set, $get)),

                            Forms\Components\TextInput::make('swim_score')
                                ->label('Nilai Renang (NR)')
                                ->helperText('Nilai hasil konversi waktu → skor (0–100).')
                                ->numeric()->minValue(0)->maxValue(100)
                                ->readOnly()
                                ->dehydrated(),
                        ]),
                    ]),

                // ===== NAJ =====
                Section::make('Nilai Akhir Jasmani (NAJ)')
                    ->description('NAJ = (NP×2 + NG×5 + NR×3) / 10')
                    ->schema([
                        Forms\Components\TextInput::make('naj')
                            ->label('NAJ')
                            ->readOnly()
                            ->numeric()
                            ->dehydrated(),
                    ]),
            ]);
    }

    protected static function recalcFromRaw(Set $set, Get $get): void
    {
        // ========== 0) Gender & Umur (umur terhadap test_date) ==========
        $mahasiswaId = $get('mahasiswa_id');
        $gender = 'male';
        $age = 22;

        $testDate = $get('test_date')
            ? \Carbon\Carbon::parse($get('test_date'))
            : now();

        if ($mahasiswaId) {
            $mhs = \App\Models\Mahasiswa::find($mahasiswaId);
            if ($mhs?->gender) {
                $gender = $mhs->gender === 'Pria' ? 'male' : 'female';
            }
            if ($mhs?->birth_date) {
                // gunakan umur bulat untuk tabel Juklak
                $age = \Carbon\Carbon::parse($mhs->birth_date)->diffInYears($testDate);
            }
        } else {
            // fallback ke temp_gender jika mahasiswa belum dipilih
            $gender = $get('temp_gender') ?: $gender;
        }

        // ========== 1) Postur (NP) ==========
        // Nilai postur diinput manual oleh user,
        // tidak lagi dihitung otomatis dari tinggi & berat.
        $np = $get('posture_score') !== null
            ? (float) $get('posture_score')
            : null;

        // ========== 2) Lari 12 menit (NA) — RAW PRIORITY ==========
        $na = null;
        if ($get('run_12min_meter')) {
            $na = \App\Support\Juklak\PhysicalScoring::scoreRun12Min(
                (int)$get('run_12min_meter'),
                $gender,
                $age
            );
            $set('garjas_a_score', $na);
        } elseif ($get('garjas_a_score')) {
            $na = (float)$get('garjas_a_score');
        }

        // ========== 3) Baterai B (NRB) ==========
        $scores = [];
        $shuttle = $get('shuttle_run_sec') !== null ? (float)$get('shuttle_run_sec') : null;

        if ($gender === 'male') {
            $scores = \App\Support\Juklak\PhysicalScoring::scoreBatteryBMale(
                $get('pull_up') !== null ? (int)$get('pull_up') : null,
                $get('sit_up') !== null ? (int)$get('sit_up') : null,
                $get('push_up') !== null ? (int)$get('push_up') : null,
                $shuttle,
                $age
            );
        } else {
            $scores = \App\Support\Juklak\PhysicalScoring::scoreBatteryBFemale(
                $get('chinning') !== null ? (int)$get('chinning') : null,
                $get('modified_sit_up') !== null ? (int)$get('modified_sit_up') : null,
                $get('modified_push_up') !== null ? (int)$get('modified_push_up') : null,
                $shuttle,
                $age
            );
        }

        $nrb = !empty(array_filter($scores, fn($v) => $v !== null))
            ? \App\Support\Juklak\PhysicalScoring::nrbAvg($scores)
            : null;
        if ($nrb !== null) {
            $set('garjas_b_avg_score', $nrb);
        }

        // ========== 4) NG = (NA + NRB)/2 ==========
        $ng = \App\Support\Juklak\PhysicalScoring::ng($na, $nrb);
        $set('garjas_score', $ng);

        // ========== 5) Renang 50m (NR) — RAW PRIORITY ==========
        $nr = null;
        if ($get('swim_50m_sec')) {
            $nr = \App\Support\Juklak\PhysicalScoring::scoreSwim50m(
                (float)$get('swim_50m_sec'),
                $gender,
                $age
            );
            $set('swim_score', $nr);
        } elseif ($get('swim_score')) {
            $nr = (float)$get('swim_score');
        }

        // ========== 6) NAJ ==========
        $naj = \App\Support\Juklak\PhysicalScoring::naj($np, $ng, $nr);
        $set('naj', $naj);

        // (Opsional) logging debug
        \Log::info('Physical Test Live Recalc', compact(
            'mahasiswaId',
            'gender',
            'age',
            'np',
            'na',
            'scores',
            'nrb',
            'ng',
            'nr',
            'naj'
        ));
    }



    // ... rest of the methods remain the same
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.name')
                    ->label('Mahasiswa')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('mahasiswa.gender')
                    ->label('Gender')
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.code')
                    ->label('Semester')
                    ->sortable(),
                Tables\Columns\TextColumn::make('naj')
                    ->label('Nilai Akhir Jasmani')
                    ->numeric(2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPhysicalTests::route('/'),
            'create' => Pages\CreatePhysicalTest::route('/create'),
            'edit' => Pages\EditPhysicalTest::route('/{record}/edit'),
        ];
    }
}

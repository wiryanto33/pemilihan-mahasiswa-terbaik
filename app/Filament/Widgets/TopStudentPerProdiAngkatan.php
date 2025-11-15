<?php

namespace App\Filament\Widgets;

use App\Models\Mahasiswa;
use App\Models\ProgramStudy;
use App\Models\MahasiswaSemester;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class TopStudentPerProdiAngkatan extends BaseWidget
{
    protected static ?string $heading = 'Mahasiswa Terbaik Prodi dan Angkatan';
    protected static ?string $subheading = 'Menampilkan 1 mahasiswa dengan NA tertinggi di setiap kombinasi Prodi dan Angkatan.';
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder|Relation|null
    {
        // Subquery: ambil NA maksimum per (program_study_id, angkatan)
        $sub = MahasiswaSemester::query()
            ->join('mahasiswas as m', 'm.id', '=', 'mahasiswa_semesters.mahasiswa_id')
            ->selectRaw('m.program_study_id, m.angkatan, MAX(mahasiswa_semesters.na) as max_na')
            ->groupBy('m.program_study_id', 'm.angkatan');

        // Join kembali ke mahasiswa_semesters untuk ambil record juara
        // Jika ada seri NA, pecahkan via updated_at terbaru lalu id terbesar
        $base = MahasiswaSemester::query()
            ->with(['mahasiswa.programStudy', 'semester'])
            ->join('mahasiswas as m', 'm.id', '=', 'mahasiswa_semesters.mahasiswa_id')
            ->joinSub($sub, 't', function ($j) {
                $j->on('t.program_study_id', '=', 'm.program_study_id')
                    ->on('t.angkatan', '=', 'm.angkatan')
                    ->on('t.max_na', '=', 'mahasiswa_semesters.na');
            })
            ->select('mahasiswa_semesters.*', 'm.angkatan', 'm.program_study_id')
            ->orderBy('m.program_study_id')
            ->orderByDesc('mahasiswa_semesters.na')
            ->orderByDesc('mahasiswa_semesters.updated_at')
            ->orderByDesc('mahasiswa_semesters.id');

        return $base;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\ImageColumn::make('mahasiswa.foto')
                ->label('Foto')
                ->circular()
                ->height(44)
                ->width(44),

            Tables\Columns\TextColumn::make('mahasiswa.name')
                ->label('Nama')
                ->searchable()
                ->weight('semibold'),

            Tables\Columns\TextColumn::make('mahasiswa.programStudy.code')
                ->label('Prodi')
                ->badge()
                ->sortable()
                ->color('info'),

            Tables\Columns\TextColumn::make('mahasiswa.angkatan')
                ->label('Angkatan')
                ->badge()
                ->sortable()
                ->color('gray'),

            Tables\Columns\TextColumn::make('semester.code')
                ->label('Semester')
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),

            Tables\Columns\TextColumn::make('ips')
                ->label('IPS')
                ->numeric(2)
                ->alignRight()
                ->toggleable()
                ->sortable(),

            Tables\Columns\TextColumn::make('ipk')
                ->label('IPK')
                ->numeric(2)
                ->alignRight()
                ->toggleable()
                ->sortable(),

            Tables\Columns\TextColumn::make('npa')
                ->label('Akademik')
                ->numeric(2)
                ->alignRight()
                ->toggleable()
                ->sortable(),

            Tables\Columns\TextColumn::make('npk')
                ->label('Kepribadian')
                ->numeric(2)
                ->alignRight()
                ->toggleable()
                ->sortable(),

            Tables\Columns\TextColumn::make('npj')
                ->label('Jasmani')
                ->numeric(2)
                ->alignRight()
                ->toggleable()
                ->sortable(),

            Tables\Columns\BadgeColumn::make('na')
                ->label('Nilai Akhir')
                ->sortable()
                ->alignment('right')
                ->formatStateUsing(fn($state) => number_format((float)$state, 2))
                ->colors([
                    'success' => fn($state) => $state >= 90,
                    'info'    => fn($state) => $state >= 80 && $state < 90,
                    'warning' => fn($state) => $state >= 70 && $state < 80,
                    'danger'  => fn($state) => $state < 70,
                ])
                ->extraAttributes(['style' => 'min-width:84px;text-align:right;']),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('program_study_id')
                ->label('Prodi')
                ->options(fn() => ProgramStudy::query()
                    ->orderBy('level')->orderBy('name')
                    ->pluck('name', 'id'))
                ->query(function (Builder $q, $data) {
                    if ($data['value'] ?? null) {
                        $q->where('m.program_study_id', $data['value']);
                    }
                }),

            Tables\Filters\SelectFilter::make('angkatan')
                ->label('Angkatan')
                ->options(fn() => Mahasiswa::query()
                    ->whereNotNull('angkatan')
                    ->distinct()
                    ->orderByDesc('angkatan')
                    ->pluck('angkatan', 'angkatan'))
                ->query(function (Builder $q, $data) {
                    if ($data['value'] ?? null) {
                        $q->where('m.angkatan', $data['value']);
                    }
                }),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            // Tables\Actions\Action::make('detail')
            //     ->label('Detail')
            //     ->icon('heroicon-o-eye')
            //     ->url(fn($record) => route('filament.admin.resources.mahasiswa-semesters.edit', $record))
            //     ->openUrlInNewTab(),

            Tables\Actions\Action::make('download_pengesahan')
                ->label('Download Pengesahan')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn($record) => route('ms.pengesahan', $record))
                ->openUrlInNewTab(false)     // langsung download di tab yang sama
                ->visible(fn($record) => filled($record->na)), // opsional: tampil jika NA ada
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        // Biasanya jumlah kombinasi Prodi×Angkatan tidak terlalu banyak; bikin tanpa paginate biar ringkas.
        return false;
    }
}

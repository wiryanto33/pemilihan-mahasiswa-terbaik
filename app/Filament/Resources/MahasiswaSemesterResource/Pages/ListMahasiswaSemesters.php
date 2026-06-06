<?php

namespace App\Filament\Resources\MahasiswaSemesterResource\Pages;

use App\Filament\Resources\MahasiswaSemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMahasiswaSemesters extends ListRecords
{
    protected static string $resource = MahasiswaSemesterResource::class;

    protected static string $view = 'filament.pages.list-mahasiswa-semesters';

    public ?int $activeProdiId = null;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function selectProdi(?int $prodiId): void
    {
        $this->activeProdiId = $prodiId;
        $this->resetPage(); // Reset table pagination
    }

    public function getProdis()
    {
        $user = auth()->user();
        return \App\Models\ProgramStudy::query()
            ->when(
                $user && !$user->hasRole('super_admin') && $user->program_study_id,
                fn($q) => $q->where('id', $user->program_study_id)
            )
            ->withCount('mahasiswa')
            ->orderBy('level')
            ->orderBy('name')
            ->get();
    }

    public function getActiveProdiName(): ?string
    {
        if (!$this->activeProdiId) {
            return null;
        }

        return \App\Models\ProgramStudy::find($this->activeProdiId)?->name;
    }

    public function getActiveProdiLevel(): ?string
    {
        if (!$this->activeProdiId) {
            return null;
        }

        return \App\Models\ProgramStudy::find($this->activeProdiId)?->level;
    }

    public function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return parent::table($table)
            ->modifyQueryUsing(function (\Illuminate\Database\Eloquent\Builder $query) {
                if ($this->activeProdiId) {
                    $query->whereHas('mahasiswa', fn($m) => $m->where('program_study_id', $this->activeProdiId));
                } else {
                    $query->whereRaw('1 = 0');
                }
            });
    }
}

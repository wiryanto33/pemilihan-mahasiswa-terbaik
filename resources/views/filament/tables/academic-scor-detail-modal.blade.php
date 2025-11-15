@php
    $avg = round($scores->avg('final_numeric') ?? 0, 2);
    $min = $scores->min('final_numeric');
    $max = $scores->max('final_numeric');
    $total = $scores->count();
@endphp

<div class="space-y-4">

    {{-- Header: identitas + tombol export --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
        {{-- Kiri: foto + identitas (ambil 2 kolom di layar besar) --}}
        <div class="flex items-center gap-4 min-w-0 md:col-span-2">
            {{-- Foto --}}
            <img src="{{ $mahasiswa->foto ? Storage::url($mahasiswa->foto) : asset('images/default-avatar.png') }}"
                alt="Foto {{ $mahasiswa->name }}" class="w-16 h-16 rounded-full object-cover border border-gray-300">

            {{-- Identitas --}}
            <div class="min-w-0">
                <div class="text-xl font-semibold truncate">{{ $mahasiswa->name }}</div>
                <div class="text-sm text-gray-500">
                    PANGKAT: <span class="font-medium">{{ $mahasiswa->pangkat ?? '-' }}</span>
                    <span class="mx-2">•</span>
                    NRP: <span class="font-medium">{{ $mahasiswa->nrp ?? '-' }}</span>
                    <span class="mx-2">•</span>
                    Prodi: <span class="font-medium">{{ $mahasiswa->programStudy->name ?? '-' }}</span>
                </div>
            </div>
        </div>


    </div>
    {{-- Ringkasan statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">
            <div class="text-xs text-gray-400">Total MK</div>
            <div class="text-lg font-semibold">{{ $total }}</div>
        </div>
        <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">
            <div class="text-xs text-gray-400">Rata-rata NA</div>
            <div class="text-lg font-semibold">{{ number_format($avg, 2) }}</div>
        </div>
        <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">
            <div class="text-xs text-gray-400">NA Tertinggi</div>
            <div class="text-lg font-semibold">{{ $max ?? '-' }}</div>
        </div>
        <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3">
            <div class="text-xs text-gray-400">NA Terendah</div>
            <div class="text-lg font-semibold">{{ $min ?? '-' }}</div>
        </div>
    </div>

    {{-- Tabel nilai --}}
    <div class="overflow-x-auto rounded-xl border border-white/10">
        <table class="min-w-full text-sm">
            <thead class="bg-white/5">
                <tr class="text-left">
                    <th class="px-4 py-2 font-medium">Mata Kuliah</th>
                    <th class="px-4 py-2 font-medium">Semester</th>
                    <th class="px-4 py-2 font-medium text-center">Quiz</th>
                    <th class="px-4 py-2 font-medium text-center">UTS</th>
                    <th class="px-4 py-2 font-medium text-center">UAS</th>
                    <th class="px-4 py-2 font-medium text-center">Nilai Akhir</th>
                    <th class="px-4 py-2 font-medium text-center">Grade</th>
                    <th class="px-4 py-2 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($scores as $s)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-4 py-2">{{ $s->matakuliah->name }}</td>
                        <td class="px-4 py-2">{{ $s->semester->code }}</td>
                        <td class="px-4 py-2 text-center">{{ $s->nu }}</td>
                        <td class="px-4 py-2 text-center">{{ $s->uts }}</td>
                        <td class="px-4 py-2 text-center">{{ $s->uas }}</td>
                        <td class="px-4 py-2 text-center font-semibold">{{ $s->final_numeric }}</td>
                        <td class="px-4 py-2 text-center">
                            <span
                                class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold
                    @class([
                        'bg-green-600/20 text-green-300' => $s->final_letter === 'A',
                        'bg-blue-600/20 text-blue-300' => in_array($s->final_letter, ['B+', 'B']),
                        'bg-amber-600/20 text-amber-300' => in_array($s->final_letter, ['C+', 'C']),
                        'bg-rose-600/20 text-rose-300' => in_array($s->final_letter, ['D', 'E']),
                        'bg-gray-600/20 text-gray-300' => !$s->final_letter,
                    ])">
                                {{ $s->final_letter ?? '-' }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-2 text-right whitespace-nowrap">
                            <x-filament::button tag="a" :href="\App\Filament\Resources\AcademicScorsResource::getUrl('edit', ['record' => $s])" size="xs" color="primary"
                                icon="heroicon-m-pencil-square">
                                Kelola Nilai
                            </x-filament::button>
                        </td>


                    </tr>
                @empty
                    {{-- Ubah colspan jadi 8 karena kolom Aksi ditambahkan --}}
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-400">Belum ada nilai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Catatan kecil --}}
    <div class="text-xs text-gray-400">
        * Nilai Akhir = kalkulasi dari NU/UTS/UAS sesuai aturan yang telah ditetapkan.
    </div>

    {{-- Kanan: tombol export (selalu muncul, tidak ketindih) --}}
    {{-- Kanan: tombol export --}}
    <div class="flex justify-start md:justify-end gap-2 shrink-0 relative z-10 pointer-events-auto">

        <x-filament::button tag="a" href="{{ route('exports.academic-scores.excel', $mahasiswa->id) }}"
            target="_blank" rel="noopener" size="sm" color="success" icon="heroicon-m-arrow-down-tray">
            Export Excel
        </x-filament::button>

        <x-filament::button tag="a" href="{{ route('pdf.academic-scores.pdf', $mahasiswa->id) }}"
            target="_blank" rel="noopener" size="sm" color="danger" icon="heroicon-m-printer">
            Cetak PDF
        </x-filament::button>

    </div>
</div>

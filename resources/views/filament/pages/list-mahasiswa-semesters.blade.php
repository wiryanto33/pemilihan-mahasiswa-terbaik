<x-filament-panels::page>
    @if (!$activeProdiId)
        <div class="space-y-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Monitoring Perankingan Per Prodi</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pilih salah satu program studi di bawah ini untuk melihat detail rekap nilai dan daftar peringkat mahasiswa.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($this->getProdis() as $prodi)
                    @php
                        // Set specific gradient colors based on prodi or level
                        $gradient = match ($prodi->level) {
                            'D3' => 'from-blue-500/10 via-cyan-500/5 to-transparent border-blue-500/20 hover:border-blue-500/40',
                            'S1' => 'from-purple-500/10 via-pink-500/5 to-transparent border-purple-500/20 hover:border-purple-500/40',
                            'S2' => 'from-emerald-500/10 via-teal-500/5 to-transparent border-emerald-500/20 hover:border-emerald-500/40',
                            default => 'from-gray-500/10 to-transparent border-gray-500/20 hover:border-gray-500/40',
                        };
                        
                        $badgeColor = match ($prodi->level) {
                            'D3' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                            'S1' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                            'S2' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300',
                        };

                        // Calculate average NA for this prodi
                        $avgNa = round(\App\Models\MahasiswaSemester::whereHas('mahasiswa', fn($q) => $q->where('program_study_id', $prodi->id))->avg('na'), 2) ?: 0;
                    @endphp
                    
                    <div 
                        wire:click="selectProdi({{ $prodi->id }})"
                        class="group cursor-pointer relative bg-white dark:bg-gray-900 p-6 rounded-2xl border shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 bg-gradient-to-br {{ $gradient }}"
                    >
                        <div class="flex items-start justify-between">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                {{ $prodi->level }}
                            </span>
                            <div class="text-right">
                                <span class="text-xs text-gray-400 dark:text-gray-500 block">Rata-rata NA</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                    {{ $avgNa ? number_format($avgNa, 2) : '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-200">
                                {{ $prodi->name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-mono">
                                Kode: {{ $prodi->code }}
                            </p>
                        </div>

                        <div class="mt-6 flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-4">
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 gap-x-1.5">
                                <x-heroicon-m-user-group class="w-4 h-4 text-gray-400" />
                                <span>{{ $prodi->mahasiswa_count }} Mahasiswa</span>
                            </div>
                            <span class="text-xs font-semibold text-primary-600 dark:text-primary-400 group-hover:underline flex items-center gap-x-1">
                                Lihat Rekap & Ranking
                                <x-heroicon-m-chevron-right class="w-3.5 h-3.5 transform group-hover:translate-x-1 transition-transform duration-200" />
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-y-4">
                <div class="flex items-center gap-x-4">
                    <button 
                        wire:click="selectProdi(null)"
                        class="inline-flex items-center justify-center w-10 h-10 bg-white hover:bg-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-xl border border-gray-200 dark:border-gray-750 shadow-sm transition hover:scale-105"
                        title="Kembali"
                    >
                        <x-heroicon-m-arrow-left class="w-5 h-5" />
                    </button>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-x-2">
                            <span>{{ $this->getActiveProdiName() }}</span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900/30 dark:text-primary-300">
                                {{ $this->getActiveProdiLevel() }}
                            </span>
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Daftar peringkat dan rekap nilai semester mahasiswa.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-4 shadow-sm">
                {{ $this->table }}
            </div>
        </div>
    @endif
</x-filament-panels::page>

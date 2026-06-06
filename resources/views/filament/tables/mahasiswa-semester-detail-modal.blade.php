<div class="space-y-6">
    <div class="flex items-center gap-x-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
        @if ($mahasiswa->foto)
            <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="Foto" class="w-16 h-16 rounded-full object-cover border-2 border-primary-500" />
        @else
            <div class="w-16 h-16 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400 font-bold text-xl">
                {{ substr($mahasiswa->name, 0, 1) }}
            </div>
        @endif
        <div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $mahasiswa->name }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">NRP: {{ $mahasiswa->nrp }} | Angkatan: {{ $mahasiswa->angkatan }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Prodi: {{ $mahasiswa->programStudy?->name }} ({{ $mahasiswa->programStudy?->level }})</p>
        </div>
    </div>

    <div class="overflow-hidden border border-gray-200 dark:border-gray-750 rounded-xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    <th class="px-4 py-3">Semester</th>
                    <th class="px-4 py-3 text-right">IPS</th>
                    <th class="px-4 py-3 text-right">IPK</th>
                    <th class="px-4 py-3 text-right">Akademik</th>
                    <th class="px-4 py-3 text-right">Kepribadian</th>
                    <th class="px-4 py-3 text-right">Jasmani</th>
                    <th class="px-4 py-3 text-right">Nilai Akhir</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                @forelse ($semesters as $s)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition duration-150 text-gray-700 dark:text-gray-300">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $s->semester?->code }}</td>
                        <td class="px-4 py-3 text-right font-mono">{{ number_format($s->ips, 2) }}</td>
                        <td class="px-4 py-3 text-right font-mono">{{ number_format($s->ipk, 2) }}</td>
                        <td class="px-4 py-3 text-right font-mono">{{ number_format($s->npa, 2) }}</td>
                        <td class="px-4 py-3 text-right font-mono">{{ number_format($s->npk, 2) }}</td>
                        <td class="px-4 py-3 text-right font-mono">{{ number_format($s->npj, 2) }}</td>
                        <td class="px-4 py-3 text-right font-bold text-primary-600 dark:text-primary-400 font-mono">{{ number_format($s->na, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            <a 
                                href="{{ route('ms.pengesahan', $s) }}" 
                                class="inline-flex items-center gap-x-1 text-xs font-semibold text-success-600 dark:text-success-400 hover:underline"
                            >
                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Download
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            Belum ada rekap nilai semester untuk mahasiswa ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

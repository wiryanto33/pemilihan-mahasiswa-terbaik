<?php

namespace Database\Seeders;

use App\Models\Matakuliah;
use App\Models\ProgramStudy;
use Illuminate\Database\Seeder;

/**
 * MatakuliahSeeder
 *
 * D3 = 6 semester → 4–5 matakuliah per semester (24–30 total per prodi)
 * S1 = 4 semester → 5–6 matakuliah per semester
 * S2 = 4 semester → 4–5 matakuliah per semester
 *
 * Kode format: {prefix}{semester}{urut}
 * Prodi D3: D3-TI → TI, D3-TM → TM, D3-TE → TE, D3-HO → HO
 * Prodi S1: S1-TE → SE, S1-TMI → MI, S1-HO → SH, S1-TM → SM
 * Prodi S2: S2-ASRO → AS
 */
class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        // ========================
        // D3 - TEKNIK INFORMATIKA
        // ========================
        $this->seedProdi('D3-TI', [
            // Semester 1
            ['code' => 'TI111', 'name' => 'Pengantar Teknologi Informasi',    'sks' => 2],
            ['code' => 'TI112', 'name' => 'Algoritma dan Pemrograman',         'sks' => 3],
            ['code' => 'TI113', 'name' => 'Matematika Dasar',                  'sks' => 2],
            ['code' => 'TI114', 'name' => 'Kalkulus',                          'sks' => 2],
            // Semester 2
            ['code' => 'TI121', 'name' => 'Pemrograman Berorientasi Objek',    'sks' => 3],
            ['code' => 'TI122', 'name' => 'Struktur Data',                     'sks' => 3],
            ['code' => 'TI123', 'name' => 'Basis Data',                        'sks' => 2],
            ['code' => 'TI124', 'name' => 'Statistika',                        'sks' => 2],
            // Semester 3
            ['code' => 'TI131', 'name' => 'Jaringan Komputer',                 'sks' => 3],
            ['code' => 'TI132', 'name' => 'Sistem Operasi',                    'sks' => 2],
            ['code' => 'TI133', 'name' => 'Pemrograman Web',                   'sks' => 3],
            ['code' => 'TI134', 'name' => 'Rekayasa Perangkat Lunak',          'sks' => 2],
            // Semester 4
            ['code' => 'TI141', 'name' => 'Keamanan Jaringan',                 'sks' => 3],
            ['code' => 'TI142', 'name' => 'Pemrograman Mobile',                'sks' => 3],
            ['code' => 'TI143', 'name' => 'Data Mining',                       'sks' => 2],
            ['code' => 'TI144', 'name' => 'Interaksi Manusia Komputer',        'sks' => 2],
            // Semester 5
            ['code' => 'TI151', 'name' => 'Cloud Computing',                   'sks' => 3],
            ['code' => 'TI152', 'name' => 'Kecerdasan Buatan',                 'sks' => 3],
            ['code' => 'TI153', 'name' => 'Manajemen Proyek TI',               'sks' => 2],
            ['code' => 'TI154', 'name' => 'Etika Profesi',                     'sks' => 1],
            // Semester 6
            ['code' => 'TI161', 'name' => 'Tugas Akhir / Proyek Akhir',        'sks' => 4],
            ['code' => 'TI162', 'name' => 'Seminar Teknologi',                 'sks' => 1],
            ['code' => 'TI163', 'name' => 'Magang / Praktik Kerja',            'sks' => 3],
        ]);

        // ========================
        // D3 - TEKNIK MESIN
        // ========================
        $this->seedProdi('D3-TM', [
            // Semester 1
            ['code' => 'TM111', 'name' => 'Fisika Teknik',                     'sks' => 2],
            ['code' => 'TM112', 'name' => 'Kimia Teknik',                      'sks' => 2],
            ['code' => 'TM113', 'name' => 'Matematika Teknik',                 'sks' => 3],
            ['code' => 'TM114', 'name' => 'Menggambar Teknik',                 'sks' => 2],
            // Semester 2
            ['code' => 'TM121', 'name' => 'Mekanika Fluida',                   'sks' => 3],
            ['code' => 'TM122', 'name' => 'Material Teknik',                   'sks' => 2],
            ['code' => 'TM123', 'name' => 'Proses Manufaktur',                 'sks' => 3],
            ['code' => 'TM124', 'name' => 'Statika Struktur',                  'sks' => 2],
            // Semester 3
            ['code' => 'TM131', 'name' => 'Termodinamika',                     'sks' => 3],
            ['code' => 'TM132', 'name' => 'Elemen Mesin',                      'sks' => 3],
            ['code' => 'TM133', 'name' => 'Pengukuran Teknik',                 'sks' => 2],
            ['code' => 'TM134', 'name' => 'Mekatronika',                       'sks' => 2],
            // Semester 4
            ['code' => 'TM141', 'name' => 'Motor Bakar',                       'sks' => 3],
            ['code' => 'TM142', 'name' => 'Sistem Pendingin',                  'sks' => 2],
            ['code' => 'TM143', 'name' => 'CNC dan CAM',                       'sks' => 3],
            ['code' => 'TM144', 'name' => 'Teknik Las',                        'sks' => 2],
            // Semester 5
            ['code' => 'TM151', 'name' => 'Perawatan Mesin',                   'sks' => 3],
            ['code' => 'TM152', 'name' => 'Teknik Kompresi',                   'sks' => 3],
            ['code' => 'TM153', 'name' => 'Keselamatan Kerja',                 'sks' => 1],
            ['code' => 'TM154', 'name' => 'Manajemen Produksi',                'sks' => 2],
            // Semester 6
            ['code' => 'TM161', 'name' => 'Tugas Akhir',                       'sks' => 4],
            ['code' => 'TM162', 'name' => 'Seminar Teknologi Mesin',           'sks' => 1],
            ['code' => 'TM163', 'name' => 'Praktik Industri',                  'sks' => 3],
        ]);

        // ========================
        // D3 - TEKNIK ELEKTRO
        // ========================
        $this->seedProdi('D3-TE', [
            // Semester 1
            ['code' => 'TE111', 'name' => 'Rangkaian Listrik',                 'sks' => 3],
            ['code' => 'TE112', 'name' => 'Matematika Teknik',                 'sks' => 2],
            ['code' => 'TE113', 'name' => 'Fisika Listrik',                    'sks' => 2],
            ['code' => 'TE114', 'name' => 'Menggambar Elektrik',               'sks' => 1],
            // Semester 2
            ['code' => 'TE121', 'name' => 'Elektronika Dasar',                 'sks' => 3],
            ['code' => 'TE122', 'name' => 'Teknik Digital',                    'sks' => 3],
            ['code' => 'TE123', 'name' => 'Sistem Kendali',                    'sks' => 2],
            ['code' => 'TE124', 'name' => 'Komunikasi Data',                   'sks' => 2],
            // Semester 3
            ['code' => 'TE131', 'name' => 'Mesin Listrik',                     'sks' => 3],
            ['code' => 'TE132', 'name' => 'Sistem Tenaga Listrik',             'sks' => 3],
            ['code' => 'TE133', 'name' => 'Mikrokontroler',                    'sks' => 2],
            ['code' => 'TE134', 'name' => 'Pengolahan Sinyal',                 'sks' => 2],
            // Semester 4
            ['code' => 'TE141', 'name' => 'Instalasi Listrik',                 'sks' => 3],
            ['code' => 'TE142', 'name' => 'Elektronika Daya',                  'sks' => 3],
            ['code' => 'TE143', 'name' => 'Instrumentasi',                     'sks' => 2],
            ['code' => 'TE144', 'name' => 'PLC dan Otomasi',                   'sks' => 2],
            // Semester 5
            ['code' => 'TE151', 'name' => 'Sistem Proteksi',                   'sks' => 3],
            ['code' => 'TE152', 'name' => 'Telekomunikasi',                    'sks' => 3],
            ['code' => 'TE153', 'name' => 'Keselamatan Listrik',               'sks' => 1],
            ['code' => 'TE154', 'name' => 'Manajemen Energi',                  'sks' => 2],
            // Semester 6
            ['code' => 'TE161', 'name' => 'Tugas Akhir',                       'sks' => 4],
            ['code' => 'TE162', 'name' => 'Seminar Elektro',                   'sks' => 1],
            ['code' => 'TE163', 'name' => 'Praktik Industri',                  'sks' => 3],
        ]);

        // ========================
        // D3 - TEKNIK HIDROOSEANOGRAFI
        // ========================
        $this->seedProdi('D3-HO', [
            // Semester 1
            ['code' => 'HO111', 'name' => 'Pengantar Oseanografi',             'sks' => 2],
            ['code' => 'HO112', 'name' => 'Matematika Terapan',                'sks' => 3],
            ['code' => 'HO113', 'name' => 'Fisika Laut',                       'sks' => 2],
            ['code' => 'HO114', 'name' => 'Kartografi dan Peta Laut',          'sks' => 2],
            // Semester 2
            ['code' => 'HO121', 'name' => 'Hidrografi Dasar',                  'sks' => 3],
            ['code' => 'HO122', 'name' => 'Pasang Surut',                      'sks' => 2],
            ['code' => 'HO123', 'name' => 'Survei Batimetri',                  'sks' => 3],
            ['code' => 'HO124', 'name' => 'Geologi Kelautan',                  'sks' => 2],
            // Semester 3
            ['code' => 'HO131', 'name' => 'Dinamika Laut',                     'sks' => 3],
            ['code' => 'HO132', 'name' => 'Navigasi Maritim',                  'sks' => 3],
            ['code' => 'HO133', 'name' => 'Sistem Informasi Geografi Laut',    'sks' => 2],
            ['code' => 'HO134', 'name' => 'Hidrodinamika',                     'sks' => 2],
            // Semester 4
            ['code' => 'HO141', 'name' => 'Remote Sensing Kelautan',           'sks' => 3],
            ['code' => 'HO142', 'name' => 'Arus dan Gelombang',                'sks' => 3],
            ['code' => 'HO143', 'name' => 'Pemodelan Numerik Laut',            'sks' => 2],
            ['code' => 'HO144', 'name' => 'Penginderaan Jauh',                 'sks' => 2],
            // Semester 5
            ['code' => 'HO151', 'name' => 'Survei Oseanografi',                'sks' => 3],
            ['code' => 'HO152', 'name' => 'Meteorologi Maritim',               'sks' => 3],
            ['code' => 'HO153', 'name' => 'Manajemen Data Kelautan',           'sks' => 2],
            ['code' => 'HO154', 'name' => 'Etika Profesi Maritim',             'sks' => 1],
            // Semester 6
            ['code' => 'HO161', 'name' => 'Tugas Akhir',                       'sks' => 4],
            ['code' => 'HO162', 'name' => 'Seminar Hidrooseanografi',          'sks' => 1],
            ['code' => 'HO163', 'name' => 'Praktik Lapangan',                  'sks' => 3],
        ]);

        // ========================
        // S1 - TEKNIK ELEKTRO
        // ========================
        $this->seedProdi('S1-TE', [
            // Semester 1
            ['code' => 'SE111', 'name' => 'Rangkaian Listrik Lanjut',          'sks' => 3],
            ['code' => 'SE112', 'name' => 'Matematika Rekayasa',               'sks' => 3],
            ['code' => 'SE113', 'name' => 'Elektronika Industri',              'sks' => 3],
            ['code' => 'SE114', 'name' => 'Pemrograman Sistem',                'sks' => 2],
            ['code' => 'SE115', 'name' => 'Fisika Kuantum Terapan',            'sks' => 2],
            // Semester 2
            ['code' => 'SE121', 'name' => 'Sistem Tenaga Lanjut',             'sks' => 3],
            ['code' => 'SE122', 'name' => 'Kendali Otomatis',                  'sks' => 3],
            ['code' => 'SE123', 'name' => 'Teknik Frekuensi Radio',            'sks' => 3],
            ['code' => 'SE124', 'name' => 'Pemrograman Mikrokontroler',        'sks' => 2],
            ['code' => 'SE125', 'name' => 'Probabilitas dan Statistika',       'sks' => 2],
            // Semester 3
            ['code' => 'SE131', 'name' => 'Sistem Komunikasi',                 'sks' => 3],
            ['code' => 'SE132', 'name' => 'Kendali Digital',                   'sks' => 3],
            ['code' => 'SE133', 'name' => 'Rekayasa Sistem Tertanam',          'sks' => 3],
            ['code' => 'SE134', 'name' => 'Kecerdasan Buatan Terapan',         'sks' => 2],
            ['code' => 'SE135', 'name' => 'Manajemen Proyek Rekayasa',         'sks' => 2],
            // Semester 4
            ['code' => 'SE141', 'name' => 'Skripsi / Tugas Akhir',            'sks' => 6],
            ['code' => 'SE142', 'name' => 'Seminar Riset',                     'sks' => 2],
            ['code' => 'SE143', 'name' => 'Etika Rekayasa',                    'sks' => 2],
            ['code' => 'SE144', 'name' => 'Kerja Praktek',                     'sks' => 2],
        ]);

        // ========================
        // S1 - TEKNIK MANAJEMEN INDUSTRI
        // ========================
        $this->seedProdi('S1-TMI', [
            // Semester 1
            ['code' => 'MI111', 'name' => 'Pengantar Manajemen Industri',      'sks' => 2],
            ['code' => 'MI112', 'name' => 'Matematika Industri',               'sks' => 3],
            ['code' => 'MI113', 'name' => 'Statistika Industri',               'sks' => 3],
            ['code' => 'MI114', 'name' => 'Proses Bisnis',                     'sks' => 2],
            ['code' => 'MI115', 'name' => 'Ekonomi Teknik',                    'sks' => 2],
            // Semester 2
            ['code' => 'MI121', 'name' => 'Riset Operasi',                     'sks' => 3],
            ['code' => 'MI122', 'name' => 'Sistem Manufaktur',                 'sks' => 3],
            ['code' => 'MI123', 'name' => 'Manajemen Rantai Pasok',            'sks' => 3],
            ['code' => 'MI124', 'name' => 'Ergonomi',                          'sks' => 2],
            ['code' => 'MI125', 'name' => 'Kualitas dan Standarisasi',         'sks' => 2],
            // Semester 3
            ['code' => 'MI131', 'name' => 'Perencanaan dan Pengendalian Prod.','sks' => 3],
            ['code' => 'MI132', 'name' => 'Manajemen Proyek',                  'sks' => 3],
            ['code' => 'MI133', 'name' => 'Sistem Informasi Manajemen',        'sks' => 3],
            ['code' => 'MI134', 'name' => 'Lean Manufacturing',                'sks' => 2],
            ['code' => 'MI135', 'name' => 'Analisis Keputusan',                'sks' => 2],
            // Semester 4
            ['code' => 'MI141', 'name' => 'Skripsi',                           'sks' => 6],
            ['code' => 'MI142', 'name' => 'Seminar Industri',                  'sks' => 2],
            ['code' => 'MI143', 'name' => 'Kerja Praktek',                     'sks' => 2],
            ['code' => 'MI144', 'name' => 'Etika Profesi',                     'sks' => 2],
        ]);

        // ========================
        // S1 - HIDROOSEANOGRAFI
        // ========================
        $this->seedProdi('S1-HO', [
            // Semester 1
            ['code' => 'SH111', 'name' => 'Oseanografi Fisika Lanjut',         'sks' => 3],
            ['code' => 'SH112', 'name' => 'Matematika Lanjut',                 'sks' => 3],
            ['code' => 'SH113', 'name' => 'Pemodelan Laut',                    'sks' => 3],
            ['code' => 'SH114', 'name' => 'Kartografi Digital',                'sks' => 2],
            ['code' => 'SH115', 'name' => 'Geologi Bahari Lanjut',             'sks' => 2],
            // Semester 2
            ['code' => 'SH121', 'name' => 'Hidrografi Lanjut',                 'sks' => 3],
            ['code' => 'SH122', 'name' => 'Penginderaan Jauh Bahari',          'sks' => 3],
            ['code' => 'SH123', 'name' => 'Survei Kelautan Lanjut',            'sks' => 3],
            ['code' => 'SH124', 'name' => 'Klimatologi Laut',                  'sks' => 2],
            ['code' => 'SH125', 'name' => 'Teknik Peramalan Gelombang',        'sks' => 2],
            // Semester 3
            ['code' => 'SH131', 'name' => 'Sistem Navigasi Terintegrasi',      'sks' => 3],
            ['code' => 'SH132', 'name' => 'Big Data Kelautan',                 'sks' => 3],
            ['code' => 'SH133', 'name' => 'Pemodelan Numerik Lanjut',          'sks' => 3],
            ['code' => 'SH134', 'name' => 'Analisis Risiko Maritim',           'sks' => 2],
            ['code' => 'SH135', 'name' => 'Metodologi Riset',                  'sks' => 2],
            // Semester 4
            ['code' => 'SH141', 'name' => 'Skripsi',                           'sks' => 6],
            ['code' => 'SH142', 'name' => 'Seminar Oseanografi',               'sks' => 2],
            ['code' => 'SH143', 'name' => 'Kerja Lapangan',                    'sks' => 2],
            ['code' => 'SH144', 'name' => 'Etika Riset',                       'sks' => 2],
        ]);

        // ========================
        // S1 - TEKNIK MESIN
        // ========================
        $this->seedProdi('S1-TM', [
            // Semester 1
            ['code' => 'SM111', 'name' => 'Mekanika Lanjut',                   'sks' => 3],
            ['code' => 'SM112', 'name' => 'Matematika Rekayasa',               'sks' => 3],
            ['code' => 'SM113', 'name' => 'Termodinamika Lanjut',              'sks' => 3],
            ['code' => 'SM114', 'name' => 'Komputasi Rekayasa',                'sks' => 2],
            ['code' => 'SM115', 'name' => 'Material Teknik Lanjut',            'sks' => 2],
            // Semester 2
            ['code' => 'SM121', 'name' => 'Mekanika Fluida Lanjut',            'sks' => 3],
            ['code' => 'SM122', 'name' => 'Desain Mesin',                      'sks' => 3],
            ['code' => 'SM123', 'name' => 'Sistem Manufaktur Lanjut',          'sks' => 3],
            ['code' => 'SM124', 'name' => 'Simulasi dan Pemodelan',            'sks' => 2],
            ['code' => 'SM125', 'name' => 'Analisis Tegangan',                 'sks' => 2],
            // Semester 3
            ['code' => 'SM131', 'name' => 'Perpindahan Panas Lanjut',          'sks' => 3],
            ['code' => 'SM132', 'name' => 'Robotika dan Otomasi',              'sks' => 3],
            ['code' => 'SM133', 'name' => 'Manajemen Perawatan',               'sks' => 3],
            ['code' => 'SM134', 'name' => 'Metode Elemen Hingga',              'sks' => 2],
            ['code' => 'SM135', 'name' => 'Metodologi Riset',                  'sks' => 2],
            // Semester 4
            ['code' => 'SM141', 'name' => 'Skripsi',                           'sks' => 6],
            ['code' => 'SM142', 'name' => 'Seminar Teknik Mesin',              'sks' => 2],
            ['code' => 'SM143', 'name' => 'Kerja Praktek',                     'sks' => 2],
            ['code' => 'SM144', 'name' => 'Etika dan Hukum Rekayasa',          'sks' => 2],
        ]);

        // ========================
        // S2 - ANALISIS SISTEM RISET DAN OPERASI
        // ========================
        $this->seedProdi('S2-ASRO', [
            // Semester 1
            ['code' => 'AS111', 'name' => 'Riset Operasi Lanjut',              'sks' => 3],
            ['code' => 'AS112', 'name' => 'Analisis Sistem Kompleks',          'sks' => 3],
            ['code' => 'AS113', 'name' => 'Statistika Terapan',                'sks' => 3],
            ['code' => 'AS114', 'name' => 'Metodologi Riset',                  'sks' => 2],
            // Semester 2
            ['code' => 'AS121', 'name' => 'Pemodelan Sistem Dinamis',          'sks' => 3],
            ['code' => 'AS122', 'name' => 'Manajemen Strategis',               'sks' => 3],
            ['code' => 'AS123', 'name' => 'Analisis Keputusan Multi Kriteria', 'sks' => 3],
            ['code' => 'AS124', 'name' => 'Kecerdasan Komputasional',          'sks' => 2],
            // Semester 3
            ['code' => 'AS131', 'name' => 'Optimasi Lanjut',                   'sks' => 3],
            ['code' => 'AS132', 'name' => 'Simulasi Sistem',                   'sks' => 3],
            ['code' => 'AS133', 'name' => 'Manajemen Risiko',                  'sks' => 2],
            ['code' => 'AS134', 'name' => 'Seminar Proposal Tesis',            'sks' => 2],
            // Semester 4
            ['code' => 'AS141', 'name' => 'Tesis',                             'sks' => 6],
            ['code' => 'AS142', 'name' => 'Seminar Hasil Tesis',               'sks' => 2],
            ['code' => 'AS143', 'name' => 'Ujian Tesis',                       'sks' => 2],
        ]);

        // ========================
        // S2 - TEKNIK HIDROOSEANOGRAFI (S2)
        // ========================
        $this->seedProdi('S2-HO', [
            // Semester 1
            ['code' => 'SHO211', 'name' => 'Oseanografi Lanjut',                'sks' => 3],
            ['code' => 'SHO212', 'name' => 'Matematika Terapan Lanjut',         'sks' => 3],
            ['code' => 'SHO213', 'name' => 'Analisis Data Laut',                'sks' => 3],
            ['code' => 'SHO214', 'name' => 'Metodologi Riset S2',               'sks' => 2],
            // Semester 2
            ['code' => 'SHO221', 'name' => 'Dinamika Perairan Dangkal',         'sks' => 3],
            ['code' => 'SHO222', 'name' => 'Manajemen Pesisir Terpadu',         'sks' => 3],
            ['code' => 'SHO223', 'name' => 'Model Hidrodinamika Numerik',       'sks' => 3],
            ['code' => 'SHO224', 'name' => 'Sistem Informasi Spasial Kelautan', 'sks' => 2],
            // Semester 3
            ['code' => 'SHO231', 'name' => 'Topik Khusus Hidrooseanografi',     'sks' => 3],
            ['code' => 'SHO232', 'name' => 'Survei dan Eksplorasi Laut Dalam',  'sks' => 3],
            ['code' => 'SHO233', 'name' => 'Publikasi Ilmiah',                  'sks' => 2],
            ['code' => 'SHO234', 'name' => 'Seminar Proposal Tesis',            'sks' => 2],
            // Semester 4
            ['code' => 'SHO241', 'name' => 'Tesis',                             'sks' => 6],
            ['code' => 'SHO242', 'name' => 'Seminar Hasil Tesis',               'sks' => 2],
            ['code' => 'SHO243', 'name' => 'Ujian Tesis',                       'sks' => 2],
        ]);
    }

    /**
     * Helper: Buat matakuliah untuk satu prodi.
     */
    private function seedProdi(string $prodiCode, array $matakuliahs): void
    {
        $prodi = ProgramStudy::where('code', $prodiCode)->first();

        if (! $prodi) {
            $this->command->warn("Prodi [{$prodiCode}] tidak ditemukan, skip.");
            return;
        }

        foreach ($matakuliahs as $mk) {
            Matakuliah::updateOrCreate(
                ['code' => $mk['code']],
                [
                    'program_study_id' => $prodi->id,
                    'name'             => $mk['name'],
                    'sks'              => $mk['sks'],
                ]
            );
        }
    }
}

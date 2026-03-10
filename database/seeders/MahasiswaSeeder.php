<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\ProgramStudy;
use Illuminate\Database\Seeder;

/**
 * MahasiswaSeeder
 *
 * Level D3 (6 semester):
 *   - D3-TI : 10 mahasiswa
 *   - D3-TM : 15 mahasiswa
 *   - D3-TE : 7  mahasiswa
 *   - D3-HO : 12 mahasiswa
 *
 * Level S1 (4 semester):
 *   - S1-TE  : 8  mahasiswa
 *   - S1-TMI : 10 mahasiswa
 *   - S1-HO  : 5  mahasiswa
 *   - S1-TM  : 8  mahasiswa
 *
 * NRP format: {PREFIX}{3-digit-urut}
 * Data disengaja bervariasi (nilai, gender) agar
 * logika pemilihan mahasiswa terbaik bisa diuji.
 */
class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // D3 - TEKNIK INFORMATIKA (10 mahasiswa)
        // =====================
        $this->seedGroup('D3-TI', 'TI', '2022', [
            ['name' => 'Ahmad Fauzi',        'pangkat' => 'Kopda',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '2000-03-15'],
            ['name' => 'Budi Santoso',        'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '2000-07-22'],
            ['name' => 'Citra Dewi',          'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-01-10'],
            ['name' => 'Deni Prasetyo',       'pangkat' => 'Kopda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-05-30'],
            ['name' => 'Eka Rahmawati',       'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-09-18'],
            ['name' => 'Fajar Nugroho',       'pangkat' => 'Koptu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-11-05'],
            ['name' => 'Gita Permatasari',    'pangkat' => 'Prada',  'korps' => 'T', 'gender' => 'Wanita', 'birth_date' => '2001-04-25'],
            ['name' => 'Hendra Wijaya',       'pangkat' => 'Kopda',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '2000-08-12'],
            ['name' => 'Indah Kusuma',        'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-06-03'],
            ['name' => 'Joko Susilo',         'pangkat' => 'Kopda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-12-20'],
        ]);

        // =====================
        // D3 - TEKNIK MESIN (15 mahasiswa)
        // =====================
        $this->seedGroup('D3-TM', 'TM', '2022', [
            ['name' => 'Agus Setiawan',       'pangkat' => 'Kopda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-02-14'],
            ['name' => 'Bagas Wicaksono',     'pangkat' => 'Prada',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-04-28'],
            ['name' => 'Cahyo Purnomo',       'pangkat' => 'Koptu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2001-07-07'],
            ['name' => 'Dian Anggraini',      'pangkat' => 'Prada',  'korps' => 'T', 'gender' => 'Wanita', 'birth_date' => '2001-10-15'],
            ['name' => 'Eko Budiyanto',       'pangkat' => 'Kopda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-01-22'],
            ['name' => 'Fitri Handayani',     'pangkat' => 'Prada',  'korps' => 'T', 'gender' => 'Wanita', 'birth_date' => '2001-03-09'],
            ['name' => 'Gunawan Hartono',     'pangkat' => 'Serda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1999-11-25'],
            ['name' => 'Hesti Purwanti',      'pangkat' => 'Prada',  'korps' => 'T', 'gender' => 'Wanita', 'birth_date' => '2001-08-17'],
            ['name' => 'Imam Muklis',         'pangkat' => 'Kopda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-06-29'],
            ['name' => 'Jaya Sulistiyo',      'pangkat' => 'Prada',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2001-02-11'],
            ['name' => 'Kartika Sari',        'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-05-04'],
            ['name' => 'Lukman Hakim',        'pangkat' => 'Koptu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-09-16'],
            ['name' => 'Maya Safitri',        'pangkat' => 'Prada',  'korps' => 'T', 'gender' => 'Wanita', 'birth_date' => '2001-12-01'],
            ['name' => 'Nanda Pratama',       'pangkat' => 'Kopda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-03-19'],
            ['name' => 'Oktaviani Putri',     'pangkat' => 'Prada',  'korps' => 'T', 'gender' => 'Wanita', 'birth_date' => '2001-10-08'],
        ]);

        // =====================
        // D3 - TEKNIK ELEKTRO (7 mahasiswa)
        // =====================
        $this->seedGroup('D3-TE', 'TE', '2022', [
            ['name' => 'Andri Hermawan',      'pangkat' => 'Kopda',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '2000-05-20'],
            ['name' => 'Bella Octavia',       'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-02-28'],
            ['name' => 'Candra Kusuma',       'pangkat' => 'Koptu',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '2000-08-15'],
            ['name' => 'Dewi Ratnasari',      'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-11-11'],
            ['name' => 'Eko Saputra',         'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '2001-04-02'],
            ['name' => 'Farida Hanum',        'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-07-30'],
            ['name' => 'Gilang Ramadhan',     'pangkat' => 'Kopda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-10-18'],
        ]);

        // =====================
        // D3 - TEKNIK HIDROOSEANOGRAFI (12 mahasiswa)
        // =====================
        $this->seedGroup('D3-HO', 'HO', '2022', [
            ['name' => 'Aditya Nugraha',      'pangkat' => 'Kopda',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '2000-01-15'],
            ['name' => 'Bintang Cahaya',      'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '2001-04-22'],
            ['name' => 'Cantika Permata',     'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-07-10'],
            ['name' => 'Dika Permana',        'pangkat' => 'Kopda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-09-05'],
            ['name' => 'Elisa Marlena',       'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-12-18'],
            ['name' => 'Fandi Ahmad',         'pangkat' => 'Koptu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-06-25'],
            ['name' => 'Galih Prakosa',       'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '2001-03-08'],
            ['name' => 'Hana Puspitasari',    'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-10-14'],
            ['name' => 'Ivan Setiadi',        'pangkat' => 'Kopda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2000-02-27'],
            ['name' => 'Julia Anggraeni',     'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-08-03'],
            ['name' => 'Kevin Aliansyah',     'pangkat' => 'Prada',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '2001-05-19'],
            ['name' => 'Layla Nurfadilah',    'pangkat' => 'Prada',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '2001-11-30'],
        ]);

        // =====================
        // S1 - TEKNIK ELEKTRO (8 mahasiswa)
        // =====================
        $this->seedGroup('S1-TE', 'STE', '2022', [
            ['name' => 'Aldi Firmansyah',     'pangkat' => 'Sertu',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '1999-05-12'],
            ['name' => 'Bella Fitriani',      'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-09-20'],
            ['name' => 'Chandra Maulana',     'pangkat' => 'Sertu',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '1998-11-08'],
            ['name' => 'Desy Kurniasih',      'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-03-25'],
            ['name' => 'Erwin Suryana',       'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-07-14'],
            ['name' => 'Fitria Nuraeni',      'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-01-30'],
            ['name' => 'Galang Putra',        'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-10-05'],
            ['name' => 'Hera Lestari',        'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-06-17'],
        ]);

        // =====================
        // S1 - TEKNIK MANAJEMEN INDUSTRI (10 mahasiswa)
        // =====================
        $this->seedGroup('S1-TMI', 'TMI', '2022', [
            ['name' => 'Arif Budiman',        'pangkat' => 'Sertu',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '1999-02-18'],
            ['name' => 'Bayu Nugroho',        'pangkat' => 'Serda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1999-07-22'],
            ['name' => 'Claudia Wulandari',   'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-04-10'],
            ['name' => 'Dimas Arifin',        'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-12-03'],
            ['name' => 'Erna Susanti',        'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-08-27'],
            ['name' => 'Fauzan Pratama',      'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-05-15'],
            ['name' => 'Gita Kusuma',         'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-10-09'],
            ['name' => 'Hamid Wahyudi',       'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-03-21'],
            ['name' => 'Ika Nurhaliza',       'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-11-14'],
            ['name' => 'Jefri Setiawan',      'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-09-28'],
        ]);

        // =====================
        // S1 - HIDROOSEANOGRAFI (5 mahasiswa)
        // =====================
        $this->seedGroup('S1-HO', 'SHO', '2022', [
            ['name' => 'Abi Prayogo',         'pangkat' => 'Sertu',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '1999-01-07'],
            ['name' => 'Bela Saraswati',      'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-06-20'],
            ['name' => 'Cakra Aditama',       'pangkat' => 'Sertu',  'korps' => 'E', 'gender' => 'Pria',   'birth_date' => '1998-11-13'],
            ['name' => 'Dinda Alviani',       'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-04-05'],
            ['name' => 'Edo Triandika',       'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-08-29'],
        ]);

        // =====================
        // S1 - TEKNIK MESIN (8 mahasiswa)
        // =====================
        $this->seedGroup('S1-TM', 'STM', '2022', [
            ['name' => 'Alfian Maulana',      'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1999-03-08'],
            ['name' => 'Bima Saktiawan',      'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-10-22'],
            ['name' => 'Cindy Maharani',      'pangkat' => 'Serda',  'korps' => 'T', 'gender' => 'Wanita', 'birth_date' => '1999-07-15'],
            ['name' => 'Danang Pratama',      'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-05-30'],
            ['name' => 'Endang Kurnia',       'pangkat' => 'Serda',  'korps' => 'T', 'gender' => 'Wanita', 'birth_date' => '1999-01-18'],
            ['name' => 'Feri Irawan',         'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-09-04'],
            ['name' => 'Ghina Aulia',         'pangkat' => 'Serda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1999-12-27'],
            ['name' => 'Hari Prabowo',        'pangkat' => 'Sertu',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1998-06-11'],
        ]);
        // =====================
        // S2 - ANALISIS SISTEM RISET DAN OPERASI (5 mahasiswa)
        // =====================
        $this->seedGroup('S2-ASRO', 'ASRO', '2022', [
            ['name' => 'Wahyudi Kusuma',      'pangkat' => 'Letda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1995-03-08'],
            ['name' => 'Ratna Sari',          'pangkat' => 'Letda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1996-10-22'],
            ['name' => 'Teguh Saputra',       'pangkat' => 'Letda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1995-07-15'],
            ['name' => 'Anisa Kirana',        'pangkat' => 'Letda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1996-05-30'],
            ['name' => 'Dharma Hidayat',      'pangkat' => 'Letda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1995-01-18'],
        ]);

        // =====================
        // S2 - TEKNIK HIDROOSEANOGRAFI (5 mahasiswa)
        // =====================
        $this->seedGroup('S2-HO', 'SHO2', '2022', [
            ['name' => 'Bobby Pramana',       'pangkat' => 'Letda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1995-09-04'],
            ['name' => 'Nurul Hidayah',       'pangkat' => 'Letda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1996-12-27'],
            ['name' => 'Yusuf Wibowo',        'pangkat' => 'Letda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1995-06-11'],
            ['name' => 'Rini Astuti',         'pangkat' => 'Letda',  'korps' => 'E', 'gender' => 'Wanita', 'birth_date' => '1996-02-14'],
            ['name' => 'Ardiansyah Rahmat',   'pangkat' => 'Letda',  'korps' => 'T', 'gender' => 'Pria',   'birth_date' => '1995-11-20'],
        ]);
    }

    /**
     * Helper: Buat mahasiswa untuk satu prodi dengan prefix NRP otomatis.
     *
     * @param string $prodiCode  Kode prodi dari tabel program_studies
     * @param string $nrpPrefix  Prefix untuk NRP mahasiswa
     * @param string $angkatan   Tahun angkatan
     * @param array  $data       Array data mahasiswa
     */
    private function seedGroup(
        string $prodiCode,
        string $nrpPrefix,
        string $angkatan,
        array  $data
    ): void {
        $prodi = ProgramStudy::where('code', $prodiCode)->first();

        if (! $prodi) {
            $this->command->warn("Prodi [{$prodiCode}] tidak ditemukan, skip.");
            return;
        }

        foreach ($data as $i => $row) {
            $nrp = strtoupper($nrpPrefix) . str_pad($i + 1, 3, '0', STR_PAD_LEFT);

            Mahasiswa::updateOrCreate(
                ['nrp' => $nrp],
                [
                    'program_study_id' => $prodi->id,
                    'name'             => $row['name'],
                    'pangkat'          => $row['pangkat'],
                    'korps'            => $row['korps'],
                    'angkatan'         => $angkatan,
                    'gender'           => $row['gender'],
                    'birth_date'       => $row['birth_date'],
                    'active'           => true,
                ]
            );
        }
    }
}

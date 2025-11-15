<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Lembar Pengesahan Mahasiswa Terbaik</title>
    <style>
        /* --- Halaman --- */
        @page {
            margin: 22mm 20mm 25mm 20mm;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111;
        }

        /* --- Utilitas --- */
        .mt-2 {
            margin-top: 8px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .mt-6 {
            margin-top: 24px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .small {
            font-size: 10px;
            color: #555;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 8px;
            background: #eef5ff;
            font-size: 11px;
        }

        /* --- Garis kop --- */
        .line {
            border-top: 2px solid #000;
            margin-top: 6px;
        }

        /* --- Tabel umum --- */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 6px 8px;
            border: 1px solid #333;
        }

        .no-border th,
        .no-border td {
            border: none;
            padding: 0;
        }

        /* --- Tabel identitas --- */
        .data-table th {
            width: 35%;
            text-align: left;
            background: #f9f9f9;
        }

        .data-table td {
            width: 65%;
        }

        /* --- Watermark --- */
        .watermark {
            position: fixed;
            top: 45%;
            left: 20%;
            opacity: 0.04;
            font-size: 70px;
            transform: rotate(-25deg);
            z-index: -1;
            color: #000;
        }

        /* --- QR --- */
        .qr-box {
            border: 1px solid #ddd;
            padding: 6px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <!-- Watermark -->
    <div class="watermark">STTAL</div>

    <!-- KOP -->
    <table class="no-border">
        <tr>
            <td style="width:20%; text-align:left;">
                <img src="{{ public_path('img/logo-tni-al.png') }}" style="height:80px;">
            </td>
            <td style="width:60%; text-align:center; line-height:1.3;">
                <div style="font-size:15px; font-weight:bold;">SEKOLAH TINGGI TEKNOLOGI ANGKATAN LAUT</div>
                <div>Jl. Bumimoro-Morokrembangan, Surabaya</div>
                <div>Telp. (031) xxx xxxx • Email: xxx@sttal.ac.id</div>
            </td>
            <td style="width:20%; text-align:right;">
                <img src="{{ public_path('img/logo-sttal-kecil.png') }}" style="height:80px;">
            </td>
        </tr>
    </table>
    <div class="line"></div>

    <!-- Judul -->
    <div class="center mt-4">
        <h2 style="margin:0;">LEMBAR PENGESAHAN MAHASISWA TERBAIK</h2>
    </div>
    <div class="center mt-2">
        Program Studi: <strong>{{ $ms->mahasiswa->programStudy->name ?? '-' }}</strong>
        &nbsp; • &nbsp; Angkatan: <span class="badge">{{ $ms->mahasiswa->angkatan ?? '-' }}</span>
    </div>

    <!-- Tabel Data -->
    <table class="data-table mt-4">
        <tr>
            <th>NRP</th>
            <td>{{ $ms->mahasiswa->nrp ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $ms->mahasiswa->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Semester</th>
            <td>{{ $ms->semester->code ?? '-' }}</td>
        </tr>
        <tr>
            <th>IPS / IPK</th>
            <td>{{ number_format((float) $ms->ips, 2) }} / {{ number_format((float) $ms->ipk, 2) }}</td>
        </tr>
        <tr>
            <th>Nilai Akademik (NPA)</th>
            <td>{{ number_format((float) $ms->npa, 2) }}</td>
        </tr>
        <tr>
            <th>Nilai Kepribadian (NPK)</th>
            <td>{{ number_format((float) $ms->npk, 2) }}</td>
        </tr>
        <tr>
            <th>Nilai Jasmani (NPJ)</th>
            <td>{{ number_format((float) $ms->npj, 2) }}</td>
        </tr>
        <tr>
            <th>Nilai Akhir (NA)</th>
            <td><strong>{{ number_format((float) $ms->na, 2) }}</strong></td>
        </tr>
    </table>

    <!-- Narasi -->
    <div class="mt-6" style="text-align:justify;">
        Berdasarkan rekapitulasi nilai akhir (NA), mahasiswa atas nama
        <strong>{{ $ms->mahasiswa->name ?? '-' }}</strong>
        (NRP <strong>{{ $ms->mahasiswa->nrp ?? '-' }}</strong>) ditetapkan sebagai
        <strong>Mahasiswa Terbaik</strong> untuk kombinasi
        <strong>Program Studi {{ $ms->mahasiswa->programStudy->name ?? '-' }}</strong>
        dan <strong>Angkatan {{ $ms->mahasiswa->angkatan ?? '-' }}</strong>,
        dengan NA sebesar <strong>{{ number_format((float) $ms->na, 2) }}</strong>.
    </div>

    <!-- QR & Tanda Tangan -->
    <!-- Tanggal & Tempat -->
    <div style="text-align:left; margin-bottom:20px;">
        Surabaya, {{ $tanggalId }}
    </div>

    <table class="no-border" style="width:100%; table-layout:fixed; margin-top:10px;">
        <tr>
            <!-- Kolom kiri: Kadep Akademik -->
            <td style="width:50%; text-align:center; vertical-align:top;">
                <div>Mengetahui,</div>
                <div><strong>Kadep Akademik</strong></div>
                <div style="height:80px;"></div>
                <div style="text-decoration: underline;">_________________________</div>
                <div class="small">NRP: _____________________</div>
            </td>

            <!-- Kolom kanan: Kaprodi -->
            <td style="width:50%; text-align:center; vertical-align:top;">
                <br>
                <div><strong>Ka. Program Studi</strong></div>
                <div style="height:80px;"></div>
                <div style="text-decoration: underline;">_________________________</div>
                <div class="small">NRP: _____________________</div>
            </td>
        </tr>

        <!-- Baris kedua: QR code di pojok kanan -->
        <tr>
            <td colspan="2" style="text-align:right; padding-top:20px; ">
                <br>
                <div class="small">Dokumen ini dilengkapi QR untuk verifikasi keaslian.</div>
                <div class="qr-box mt-2 center ">
                    <img src="{{ $qrBase64 }}" style="height:110px;">
                </div>
                <div class="small mt-2">Scan atau buka:<br>{{ $verifyUrl }}</div>
            </td>
        </tr>
    </table>


</body>

</html>

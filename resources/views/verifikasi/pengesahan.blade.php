<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Verifikasi Lembar Pengesahan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            margin: 0;
            padding: 16px;
            background: #f3f4f6;
            color: #111827;
        }

        .container {
            max-width: 720px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px 20px 28px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
        }

        h1 {
            font-size: 22px;
            margin: 0 0 4px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 18px;
        }

        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 11px;
            background: #ecfdf5;
            color: #166534;
            font-weight: 600;
        }

        .section-title {
            font-size: 13px;
            font-weight: 600;
            margin: 20px 0 8px;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            width: 34%;
            text-align: left;
            color: #4b5563;
            background: #f9fafb;
        }

        td {
            width: 66%;
        }

        .status {
            margin-top: 16px;
            padding: 10px 12px;
            border-radius: 8px;
            background: #ecfdf5;
            color: #166534;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-icon {
            width: 18px;
            height: 18px;
            border-radius: 999px;
            border: 2px solid #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .footer {
            margin-top: 16px;
            font-size: 11px;
            color: #6b7280;
            text-align: right;
        }

        @media (max-width: 640px) {
            .container {
                padding: 18px 14px 22px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Verifikasi Lembar Pengesahan</h1>
        <div class="subtitle">
            Sistem Mahasiswa Terbaik STTAL
        </div>

        <div class="status">
            <div class="status-icon">✓</div>
            <div>
                <strong>Dokumen TERVERIFIKASI ASLI</strong><br>
                Data di bawah diambil langsung dari basis data resmi.
            </div>
        </div>

        <div class="section-title">Data Mahasiswa</div>
        <table>
            <tr>
                <th>Nama</th>
                <td>{{ $ms->mahasiswa->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>NRP</th>
                <td>{{ $ms->mahasiswa->nrp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Program Studi</th>
                <td>{{ $ms->mahasiswa->programStudy->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Angkatan</th>
                <td>{{ $ms->mahasiswa->angkatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Semester</th>
                <td>{{ $ms->semester->code ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">Ringkasan Nilai</div>
        <table>
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

        <div class="footer">
            Waktu verifikasi:
            {{ $verifiedAt->translatedFormat('d F Y H:i') }} WIB
        </div>
    </div>
</body>

</html>


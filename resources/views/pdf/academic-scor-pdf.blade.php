<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Nilai</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111;
        }

        h2 {
            margin: 0 0 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        thead {
            background: #f3f3f3;
        }

        .meta {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2>Rekap Nilai Akademik</h2>
    <div class="meta">
        <strong>Nama:</strong> {{ $mhs->name }}<br>
        <strong>NRP:</strong> {{ $mhs->nrp }}<br>
        <strong>Prodi:</strong> {{ $mhs->programStudy->name ?? '-' }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Mata Kuliah</th>
                <th>Semester</th>
                <th>Quiz</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Nilai Akhir</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scores as $s)
                <tr>
                    <td>{{ $s->matakuliah->name }}</td>
                    <td>{{ $s->semester->code }}</td>
                    <td>{{ $s->nu }}</td>
                    <td>{{ $s->uts }}</td>
                    <td>{{ $s->uas }}</td>
                    <td>{{ $s->final_numeric }}</td>
                    <td>{{ $s->final_letter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

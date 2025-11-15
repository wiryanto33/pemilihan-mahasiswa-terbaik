<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaSemester;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Carbon\Carbon;

// Endroid QR Code v6
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Color\Color;

class CetakPengesahanController extends Controller
{
    public function pengesahan(MahasiswaSemester $mahasiswaSemester)
    {
        $ms = $mahasiswaSemester->load(['mahasiswa.programStudy', 'semester']);

        // URL verifikasi
        $verifyUrl = url("/verifikasi/pengesahan/{$ms->getKey()}?token=" . sha1($ms->getKey() . 'sttal'));

        // === Generate QR (v6 Builder) -> Base64 PNG ===
        $builder = new Builder(
            writer: new PngWriter(),
            data: $verifyUrl,
            encoding: new Encoding('UTF-8'),
            size: 140,
            margin: 1,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );

        $result = $builder->build();


        $qrBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

        // Tanggal Indonesia
        $tanggalId = Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');

        $pdf = Pdf::loadView('pdf.lembar-pengesahan-sttal', [
            'ms'        => $ms,
            'verifyUrl' => $verifyUrl,
            'qrBase64'  => $qrBase64,
            'tanggalId' => $tanggalId,
        ])->setPaper('A4', 'portrait');

        $pdf->set_option('isRemoteEnabled', true);

        $filename = 'Lembar-Pengesahan_' .
            ($ms->mahasiswa->nrp ?? 'NRP') . '_' .
            Str::slug($ms->mahasiswa->name ?? 'Mahasiswa') . '.pdf';

        return $pdf->stream($filename);
    }
}

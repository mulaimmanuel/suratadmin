<?php

// app/Models/Surat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'keterangan', 'tanggal_surat',
        'departemen'
    ];

    // Di dalam model Surat
    public static function getOtomatisData()
    {
        $suratController = new \App\Http\Controllers\SuratController();
        return $suratController->getOtomatis();
    }

    public static function createWithOtomatisData($request)
    {
        $otomatis = self::getOtomatisData();

        return new self([
            'nomor_surat' => $otomatis['nomorSurat'],
            'keterangan' => $request->input('keterangan'),
            'tanggal_surat' => $request->input('tanggal_surat'),
            'departemen' => $otomatis['departemen'],
        ]);
    }


    public function getOtomatis($surat)
    {
        $bulanRomawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");

        $noUrutAkhir = $surat->value('id');
        $no = 1;

        if ($noUrutAkhir) {
            $noUrutSurat = sprintf("%03s", abs(intval($noUrutAkhir) + 1));
        } else {
            $noUrutSurat = sprintf("%03s", intval($no) + 1);
        }

        // Ambil nilai AWAL dari database atau tentukan sendiri sesuai kebutuhan
        // Gantilah dengan model Surat yang sesuai di aplikasi Anda
        $AWAL = $surat->value('nomor_surat');
        $departemen = $surat->value('departemen');

        if ($departemen == 'Direksi') {
            $AWAL = 'ADDIR';
        } else if ($departemen == 'Administrasi') {
            $AWAL = 'ADADMI';
        } else if ($departemen == 'HR') {
            $AWAL = 'HRGA';
        }

        $formatNomorSurat = $noUrutSurat . '/' . $AWAL . '/' . $bulanRomawi[date('n')] . '/' . date('Y');

        return [
            'nomorSurat' => $formatNomorSurat,
            'departemen' => $departemen,
            // Add other surat data here
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surats = Surat::latest()->paginate(10);

        return view('surats.index', compact('surats'))->with(
            'i',
            (request()->input('page', 1) - 1) * 5
        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('surats.create'); // Assuming you have a 'create' blade file in the 'surat' folder
    }

    private function generateNomorSurat($departemen, $tanggalSurat)
    {
        $AWAL = $this->getAWALValue($departemen);

        $tanggalSuratDateTime = \DateTime::createFromFormat('Y-m-d', $tanggalSurat);
        $bulanRomawi = $this->getRomanMonth($tanggalSuratDateTime);

        // looHitung berapa banyak surat dengan departemen yang sama pada bulan yang sama
        $jumlahSuratBulanIni = Surat::where('departemen', $departemen)
            ->whereYear('tanggal_surat', $tanggalSuratDateTime->format('Y'))
            ->whereMonth('tanggal_surat', $tanggalSuratDateTime->format('m'))
            ->count();

        $noUrutAkhir = $jumlahSuratBulanIni + 1;

        $suratNumber = sprintf("%03s", $noUrutAkhir) . '/' . $AWAL . '/' . $bulanRomawi . '/' . $tanggalSuratDateTime->format('Y');

        return $suratNumber;
    }

    public function store(Request $request)
    {
        $departemen = $request->input('departemen');
        $tanggalSurat = $request->input('tanggal_surat');
        $suratNumber = $this->generateNomorSurat($departemen, $tanggalSurat);

        $request->merge(['nomor_surat' => $suratNumber]);

        Surat::create($request->all());

        return redirect()->route('surats.index')->with('success', 'Surat created successfully.');
    }
    // ...

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function edit(Surat $surat)
    {
        //
        return view('surats.edit', compact('surat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Surat $surat)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'departemen' => 'required',
            'tanggal_surat' => 'required|date',
            // Add other validation rules as needed
        ]);

        $departemen = $request->input('departemen');
        $tanggalSurat = $request->input('tanggal_surat');
        $suratNumber = $this->generateNomorSurat($departemen, $tanggalSurat);

        $request->merge(['nomor_surat' => $suratNumber]);

        $surat->update($request->all());

        return redirect()->route('surats.index')->with('success', 'Surat updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surat $surat)
    {
        $surat->delete();

        return redirect()->route('surats.index')->with('success', 'Surat deleted successfully');
    }

    private function getAWALValue($departemen)
    {
        switch ($departemen) {
            case 'Direksi':
                return 'ADDIR';
            case 'HR':
                return 'HRGA';
            case 'Administrasi':
                return 'ADADM';
                // Add more cases as needed
        }
    }

    private function getNewNoUrut($lastSurat)
    {
        if ($lastSurat && $lastSurat->tanggal_surat) {
            $lastTanggalSurat = \DateTime::createFromFormat('Y-m-d', $lastSurat->tanggal_surat);
            $currentDate = now();

            // Check if the last surat is in the same month and year as the current date
            if ($lastTanggalSurat->format('Ym') == $currentDate->format('Ym')) {
                // If yes, increment the number
                return (int)$lastSurat->nomor_surat + 1;
            }
        }

        // Otherwise, start from 1
        return 1;
    }

    private function getRomanMonth(\DateTime $date)
    {
        $bulanRomawi = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        return $bulanRomawi[(int)$date->format('n')];
    }
}

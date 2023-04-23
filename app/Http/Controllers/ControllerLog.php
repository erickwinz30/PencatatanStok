<?php

namespace App\Http\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelLog;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class ControllerLog extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function readLog() {
        $xx = new ModelLog();
        $barang = $xx->readBarang();

        return view('viewBarang', ['barang'=> $barang]);
    }

    public function logBarangMasuk() {
        $xx = new ModelLog();
        $log = $xx->readLogMasuk();

        return view('viewLogMasuk', ['log'=> $log]);
    }

    public function logBarangKeluar() {
        $xx = new ModelLog();
        $log = $xx->readLogKeluar();

        return view('viewLogKeluar', ['log'=> $log]);
    }

    public function barangMasuk() {
        return view('viewBarangMasuk');
    }

    public function barangBaru() {
        return view('viewBarangBaru');
    }

    public function insertJumlahBarang() {
        return view('insertJumlah');
    }

    public function tambahBaru(Request $x) {
        
    }

    public function tampilJumlah(Request $x) {
        $jumlah_tambah = $x->input('txtJumlah');
        $xx = new ModelBarang();

        $hasil = $xx->getJumlahBarang('RP500', $jumlah_tambah);
        return view('viewJumlah', ['hasil' => $hasil]);
    }
}

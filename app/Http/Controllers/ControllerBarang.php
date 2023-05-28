<?php

namespace App\Http\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class ControllerBarang extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function readBarang()
    {
        $xx = new ModelBarang();
        $barang = $xx->readBarang();

        return view('viewBarang', ['barang' => $barang]);
    }

    public function editBarang($id_barang) {
        $xx = new ModelBarang();
        $barang = $xx->getIdBarang($id_barang);
        return view('viewUpdateBarang', ['barang' => $barang]);
    }

    public function editBarangMasuk($id_barang)
    {
        $xx = new ModelBarang();
        $barang = $xx->getIdBarang($id_barang);
        return view('viewBarangMasuk', ['barang' => $barang]);
    }

    public function editBarangKeluar($id_barang)
    {
        $xx = new ModelBarang();
        $barang = $xx->getIdBarang($id_barang);
        return view('viewBarangKeluar', ['barang' => $barang]);
    }

    public function insertBarangBaru()
    {
        return view('viewBarangBaru');
    }

    public function logMasukRetur()
    {
        return view('viewLogMasuk');
    }

    public function tambahBaru(Request $x)
    {
        $this->validate($x, [
            'id_barang' => 'required|min:2|max:8',
            'nama_barang' => 'required|min:2|max:50',
            'berat_barang' => 'required|numeric',
            'lead_time',
            'demand',
            'penjualan_tertinggi',
            'lead_time_terlama',
            'jumlah_barang' => 'required|numeric',
            'keterangan' => 'required|min:2|max:100',
        ]);

        $xx = new ModelBarang();
        $xx->simpanBaru($x);
        $xx2 = new ModelLog();
        $xx2->simpanLogBaru($x);
        return redirect('/viewBarang');
    }

    public function updateBarang(Request $x) {
        $validatedData = $x->validate([
            'id_barang' => 'required|min:2|max:8',
            'nama_barang' => 'required|min:2|max:50',
            'berat_barang' => 'required|numeric',
            'lead_time' => '',
            'demand' => '',
            'penjualan_tertinggi' => '',
            'lead_time_terlama' => '',
        ]);
        $xx = new ModelBarang();
        $xx->updateBarang($validatedData);
        return redirect('/viewBarang');
    }

    public function updateBarangMasuk(Request $x)
    {
        Log::info($x);

        $validatedData = $x->validate([
            'id_barang' => 'required|min:2|max:8',
            'jumlah_barang' => 'required|numeric',
            'status_barang' => 'required|min:2|max:8',
            'keterangan' => 'required|min:2|max:100',
        ]);
        $xx = new ModelBarang();
        $xx->updateBarangMasuk($validatedData);
        $xx2 = new ModelLog();
        $xx2->updateLogBarangMasuk($validatedData);
        return redirect('/viewBarang');
    }

    public function updateBarangKeluar(Request $x)
    {
        Log::info($x);

        $validatedData = $x->validate([
            'id_barang' => 'required|min:2|max:8',
            'jumlah_barang' => 'required|numeric',
            'status_barang' => 'required|min:2|max:8',
            'keterangan' => 'required|min:2|max:100',
        ]);
        $xx = new ModelBarang();
        $xx->updateBarangKeluar($validatedData);
        $xx2 = new ModelLog();
        $xx2->updateLogBarangKeluar($validatedData);
        return redirect('/viewBarang');
    }
}
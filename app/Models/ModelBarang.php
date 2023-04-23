<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ModelBarang extends Model
{

    public function readBarang()
    {
        // $ROP = 11;
        // $less_barang = DB::table('barang')->select('select id_barang where jumlah_barang <' + $ROP + ';');
        $this->fungsi_ROP();

        $barang = DB::table('barang')->get();
        return $barang;
    }

    public function fungsi_ROP()
    {
        $barang = DB::table('barang')->get();
        $error_items = [];

        foreach ($barang as $item) {
            if ($item->jumlah_barang < 11) {
                $error_items[] = $item->id_barang;
            }
        }

        if (!empty($error_items)) {
            $error_message = 'Jumlah barang ' . implode(', ', $error_items) . ' kurang dari 10!';
            return redirect('viewBarang')->with('error', $error_message);
        }
    }

    public function getIdBarang($id_Barang)
    {
        $id_barang = DB::table('barang')->where('id_barang', $id_Barang)->get();
        return $id_barang;
    }

    public function getJumlahBarang($id_barang, $x)
    {
        $jumlah = $x;
        $jumlah_barang = DB::table('barang')->where('id_barang', $id_barang)->value('jumlah_barang');
        $hasil_tambah = $jumlah_barang + $jumlah;
        return $hasil_tambah;
    }

    public function simpanBaru($x)
    {
        $barang = DB::table('barang')->insert([
            'id_barang' => $x->id_barang,
            'nama_barang' => $x->nama_barang,
            'berat_barang' => $x->berat_barang,
            'jumlah_barang' => $x->jumlah_barang
        ]);
    }

    public function updateBarangMasuk($data)
    {
        $currentDate = Carbon::now('Asia/Jakarta');

        $jumlah = $data['jumlah_barang'];
        $jumlah_barang = DB::table('barang')->where('id_barang', $data['id_barang'])->value('jumlah_barang');
        $hasil = $jumlah_barang + $jumlah;

        $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
            'berat_barang' => $data['berat_barang'],
            'jumlah_barang' => $hasil,
        ]);

        $log_barang = DB::table('log_barang')->where('id_barang', $data['id_barang'])->insert([
            'id_barang' => $data['id_barang'],
            'jumlah_barang' => $data['jumlah_barang'],
            'status_barang' => $data['status_barang'],
            'tanggal_log' => $currentDate,
            'keterangan' => $data['keterangan'],
        ]);
    }

    public function updateBarangKeluar($data)
    {
        $currentDate = Carbon::now('Asia/Jakarta');

        $jumlah = $data['jumlah_barang'];
        $jumlah_barang = DB::table('barang')->where('id_barang', $data['id_barang'])->value('jumlah_barang');
        $hasil = $jumlah_barang - $jumlah;

        $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
            'berat_barang' => $data['berat_barang'],
            'jumlah_barang' => $hasil,
        ]);

        $log_barang = DB::table('log_barang')->where('id_barang', $data['id_barang'])->insert([
            'id_barang' => $data['id_barang'],
            'jumlah_barang' => $data['jumlah_barang'],
            'status_barang' => 'Keluar',
            'tanggal_log' => $currentDate,
            'keterangan' => $data['keterangan'],
        ]);
    }
}

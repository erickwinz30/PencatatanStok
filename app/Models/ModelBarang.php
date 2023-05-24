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
        $barang = DB::table('barang')->get();
        return $barang;
    }

    public function updateBarang($data)
    {
        $lead_time = isset($data['lead_time']) ? $data['lead_time'] : null;
        $demand = isset($data['demand']) ? $data['demand'] : null;
        $penjualan_tertinggi = isset($data['penjualan_tertinggi']) ? $data['penjualan_tertinggi'] : null;
        $lead_time_terlama = isset($data['lead_time_terlama']) ? $data['lead_time_terlama'] : null;

        if ($lead_time === null || $demand === null || $penjualan_tertinggi === null || $lead_time_terlama === null) {
            $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
                'nama_barang' => $data['nama_barang'],
                'berat_barang' => $data['berat_barang'],
                'lead_time' => $data['lead_time'],
                'demand' => $data['demand'],
                'penjualan_tertinggi' => $data['penjualan_tertinggi'],
                'lead_time_terlama' => $data['lead_time_terlama'],
                'reorder_point' => '-',
            ]);
        } else {
            $lead_time_demand = $lead_time * $demand;
            $safety_stock = ($penjualan_tertinggi * $lead_time_terlama) - ($demand * $lead_time);
            $reorder_point = $lead_time_demand + $safety_stock;

            $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
                'nama_barang' => $data['nama_barang'],
                'berat_barang' => $data['berat_barang'],
                'lead_time' => $data['lead_time'],
                'demand' => $data['demand'],
                'penjualan_tertinggi' => $data['penjualan_tertinggi'],
                'lead_time_terlama' => $data['lead_time_terlama'],
                'reorder_point' => $reorder_point,
            ]);
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
        $lead_time = $x['lead_time'];
        $demand = $x['demand'];
        $penjualan_tertinggi = $x['penjualan_tertinggi'];
        $lead_time_terlama = $x['lead_time_terlama'];

        if ($lead_time === null || $demand === null || $penjualan_tertinggi === null || $lead_time_terlama === null) {
            $barang = DB::table('barang')->insert([
                'id_barang' => $x->id_barang,
                'nama_barang' => $x->nama_barang,
                'berat_barang' => $x->berat_barang,
                'lead_time' => $x->lead_time,
                'demand' => $x->demand,
                'penjualan_tertinggi' => $x->penjualan_tertinggi,
                'lead_time_terlama' => $x->lead_time_terlama,
                'jumlah_barang' => $x->jumlah_barang,
                'reorder_point' => '-',
            ]);
        } else {
            $lead_time_demand = $lead_time * $demand;
            $safety_stock = ($penjualan_tertinggi * $lead_time_terlama) - ($demand * $lead_time);
            $reorder_point = $lead_time_demand + $safety_stock;

            $barang = DB::table('barang')->insert([
                'id_barang' => $x->id_barang,
                'nama_barang' => $x->nama_barang,
                'berat_barang' => $x->berat_barang,
                'jumlah_barang' => $x->jumlah_barang,
                'lead_time' => $x->lead_time,
                'demand' => $x->demand,
                'penjualan_tertinggi' => $x->penjualan_tertinggi,
                'lead_time_terlama' => $x->lead_time_terlama,
                'reorder_point' => $reorder_point,
            ]);
        }
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
}

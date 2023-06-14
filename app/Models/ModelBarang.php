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
        //demand
        //1. Subquery
        $subquery = DB::table('log_barang')
            ->select(DB::raw('DATE(tanggal_log) AS tanggal, SUM(jumlah_barang) AS total_penjualan_harian'))
            ->where('id_barang', $data['id_barang'])
            ->where('status_barang', 'Terjual')
            ->groupBy(DB::raw('DATE(tanggal_log)'));
        //2. Demand / Rata penjualan
        $result_demand = DB::table(DB::raw("({$subquery->toSql()}) as subquery"))
        ->mergeBindings($subquery)
        ->select(DB::raw('AVG(total_penjualan_harian) AS rata_rata_penjualan_harian'))
        ->first();

        if ($result_demand !== null && $result_demand !== 0) {
            $rata_penjualan = round($result_demand->rata_rata_penjualan_harian, 2);
            $demand = $rata_penjualan;
        } else {
            $demand = null; // Atau nilai default yang sesuai jika hasil seleksi tidak ada
        }
        
        //Penjualan tertinggi
        //1. Subquery
        $subquery = DB::table('log_barang')
            ->select(DB::raw('DATE(tanggal_log) AS tanggal, SUM(jumlah_barang) AS total_penjualan_harian'))
            ->where('id_barang', $data['id_barang'])
            ->where('status_barang', 'Terjual')
            ->groupBy(DB::raw('DATE(tanggal_log)'));
        //2. Max / Penjualan tertinggi
        $result_penjualan_tertinggi = DB::table(DB::raw("({$subquery->toSql()}) as subquery"))
        ->mergeBindings($subquery)
        ->select(DB::raw('MAX(total_penjualan_harian) AS max_penjualan_harian'))
        ->first();

        if ($result_penjualan_tertinggi !== null && $result_penjualan_tertinggi !== 0 ) {
            $highest_penjualan = round($result_penjualan_tertinggi->max_penjualan_harian, 2);
            $penjualan_tertinggi = $highest_penjualan;
        } else {
            $penjualan_tertinggi = null; // Atau nilai default yang sesuai jika hasil seleksi tidak ada
        }

        $lead_time_terlama = isset($data['lead_time_terlama']) ? $data['lead_time_terlama'] : null;
        Log::info($lead_time);
        Log::info($demand);
        Log::info($penjualan_tertinggi);
        Log::info($lead_time_terlama);

        if ($demand == null || $penjualan_tertinggi == null) {
            $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
                'nama_barang' => $data['nama_barang'],
                'supplier_barang' => $data['supplier_barang'],
                'berat_barang' => $data['berat_barang'],
                'lead_time' => $data['lead_time'],
                'demand' => null,
                'penjualan_tertinggi' => null,
                'lead_time_terlama' => $data['lead_time_terlama'],
                'reorder_point' => '50',
            ]);
        } else if ($demand == 0 || $penjualan_tertinggi == 0) {
            $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
                'nama_barang' => $data['nama_barang'],
                'supplier_barang' => $data['supplier_barang'],
                'berat_barang' => $data['berat_barang'],
                'lead_time' => $data['lead_time'],
                'demand' => null,
                'penjualan_tertinggi' => null,
                'lead_time_terlama' => $data['lead_time_terlama'],
                'reorder_point' => '50',
            ]);
        } else {
            $lead_time_demand = $lead_time * $demand;
            $safety_stock = ($penjualan_tertinggi * $lead_time_terlama) - ($demand * $lead_time);
            $reorder_point = $lead_time_demand + $safety_stock;

            $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
                'nama_barang' => $data['nama_barang'],
                'supplier_barang' => $data['supplier_barang'],
                'berat_barang' => $data['berat_barang'],
                'lead_time' => $data['lead_time'],
                'demand' => $demand,
                'penjualan_tertinggi' => $penjualan_tertinggi,
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
        $barang = DB::table('barang')->insert([
            'id_barang' => $x->id_barang,
            'nama_barang' => $x->nama_barang,
            'supplier_barang'=> $x->supplier_barang,
            'berat_barang' => $x->berat_barang,
            'lead_time' => $x->lead_time,
            'demand' => null,
            'penjualan_tertinggi' => null,
            'lead_time_terlama' => $x->lead_time_terlama,
            'jumlah_barang' => $x->jumlah_barang,
            'reorder_point' => '50',
        ]);
    }

    public function updateBarangMasuk($data)
    {
        $currentDate = Carbon::now('Asia/Jakarta');

        $jumlah = $data['jumlah_barang'];
        $jumlah_barang = DB::table('barang')->where('id_barang', $data['id_barang'])->value('jumlah_barang');
        $hasil = $jumlah_barang + $jumlah;

        $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
            'jumlah_barang' => $hasil,
        ]);
    }

    public function updateBarangKeluar($data)
    {
        Log::info($data);
        $currentDate = Carbon::now('Asia/Jakarta');

        $jumlah = $data['jumlah_barang'];
        $jumlah_barang = DB::table('barang')->where('id_barang', $data['id_barang'])->value('jumlah_barang');
        $hasil = $jumlah_barang - $jumlah;

        $lead_time = DB::table('barang')->where('id_barang', $data['id_barang'])->value('lead_time');
        Log::info($lead_time);
        $lead_time_terlama = DB::table('barang')->where('id_barang', $data['id_barang'])->value('lead_time_terlama');
        Log::info($lead_time_terlama);

        //demand
        //1. Subquery
        $subquery = DB::table('log_barang')
            ->select(DB::raw('DATE(tanggal_log) AS tanggal, SUM(jumlah_barang) AS total_penjualan_harian'))
            ->where('id_barang', $data['id_barang'])
            ->where('status_barang', 'Terjual')
            ->groupBy(DB::raw('DATE(tanggal_log)'));
        //2. Demand / Rata penjualan
        $result_demand = DB::table(DB::raw("({$subquery->toSql()}) as subquery"))
        ->mergeBindings($subquery)
        ->select(DB::raw('AVG(total_penjualan_harian) AS rata_rata_penjualan_harian'))
        ->first();
        
        if ($result_demand) {
            $rata_penjualan = round($result_demand->rata_rata_penjualan_harian, 2);
            $demand = $rata_penjualan;
            Log::info($demand);
        } else {
            $demand = null; // Atau nilai default yang sesuai jika hasil seleksi tidak ada
        }

        //Penjualan tertinggi
        //1. Subquery
        $subquery = DB::table('log_barang')
            ->select(DB::raw('DATE(tanggal_log) AS tanggal, SUM(jumlah_barang) AS total_penjualan_harian'))
            ->where('id_barang', $data['id_barang'])
            ->where('status_barang', 'Terjual')
            ->groupBy(DB::raw('DATE(tanggal_log)'));
        //2. Max / Penjualan tertinggi
        $result_penjualan_tertinggi = DB::table(DB::raw("({$subquery->toSql()}) as subquery"))
        ->mergeBindings($subquery)
        ->select(DB::raw('MAX(total_penjualan_harian) AS max_penjualan_harian'))
        ->first();
        if ($result_penjualan_tertinggi) {
            $highest_penjualan = round($result_penjualan_tertinggi->max_penjualan_harian, 2);
            $penjualan_tertinggi = $highest_penjualan;
            Log::info($penjualan_tertinggi);
        } else {
            $penjualan_tertinggi = null; // Atau nilai default yang sesuai jika hasil seleksi tidak ada
        }

        if ($lead_time === null || $demand === null || $penjualan_tertinggi === null || $lead_time_terlama === null) {
            $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
                'lead_time' => $lead_time,
                'demand' => $demand,
                'penjualan_tertinggi' => $penjualan_tertinggi,
                'lead_time_terlama' => $lead_time_terlama,
                'jumlah_barang' => $hasil,
                'reorder_point' => '50',
            ]);
        } else {
            $lead_time_demand = $lead_time * $demand;
            $safety_stock = ($penjualan_tertinggi * $lead_time_terlama) - ($demand * $lead_time);
            $reorder_point = $lead_time_demand + $safety_stock;

            $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
                'demand' => $demand,
                'penjualan_tertinggi' => $penjualan_tertinggi,
                'jumlah_barang' => $hasil,
                'reorder_point' => $reorder_point,
            ]);
        }

        // $barang = DB::table('barang')->where('id_barang', $data['id_barang'])->update([
        //     'jumlah_barang' => $hasil,
        // ]);
    }
}
